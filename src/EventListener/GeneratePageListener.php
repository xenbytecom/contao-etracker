<?php

/*
 * etracker integration for Contao CMS
 *
 * Copyright (c) 2025 Xenbyte, Stefan Brauner
 *
 * @author     Stefan Brauner <https://www.xenbyte.com>
 * @link       https://github.com/xenbytecom/contao-etracker
 * @license    LGPL-3.0-or-later
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Xenbyte\ContaoEtracker\EventListener;

use Contao\BackendUser;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Routing\ResponseContext\Csp\CspHandler;
use Contao\CoreBundle\Routing\ResponseContext\HtmlHeadBag\HtmlHeadBag;
use Contao\CoreBundle\Routing\ResponseContext\ResponseContext;
use Contao\FrontendTemplate;
use Contao\FrontendUser;
use Contao\LayoutModel;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\PageRegular;
use Contao\StringUtil;
use Contao\System;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Xenbyte\ContaoEtracker\Model\EtrackerEventsModel;

#[AsHook('generatePage')]
class GeneratePageListener
{
    private readonly SessionInterface $session;

    public function __construct(private readonly RequestStack $requestStack)
    {
        $request = $this->requestStack->getCurrentRequest();
        if (null === $request) {
            return;
        }

        $this->session = $request->getSession();
    }

    public function __invoke(PageModel $pageModel, LayoutModel $layout, PageRegular $pageRegular): void
    {
        /** @var PageModel $rootPage */
        $rootPage = PageModel::findById($pageModel->rootId);
        $trackingEnabled = self::isTrackingEnabled($rootPage);

        if ($trackingEnabled) {
            $objTemplate = new FrontendTemplate('etracker_head_code');

            // Seitenname @see
            // https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/parameter-setzen/
            $pagename = $this->getPagename($pageModel);
            if ('' !== $pagename) {
                $objTemplate->pagename = trim($pagename);
            }

            $objTemplate->etrackerTrackingDomain = $rootPage->etrackerTrackingDomain;

            try {
                $objTemplate->et_script = $this->getScriptCode($rootPage);
                $this->getParameters($objTemplate, $rootPage, $pageModel);
                $GLOBALS['TL_HEAD'][] = $objTemplate->parse();

                // Event-Tracking
                if (null !== $rootPage->etrackerEvents) {
                    $GLOBALS['TL_BODY'][] = $this->generateEventTracking($rootPage);
                }
            } catch (\DOMException) {
            }
        }

        // Logik für das Login-Event-Skript integrieren
        $this->injectDetectedEventsScript($trackingEnabled); // Hinzugefügt
    }

    /**
     * @return array{category: string, action: string, object: string, selector: string}
     */
    public function getEventVariables(EtrackerEventsModel $evt, int|null $moduleId = null): array
    {
        $eventData = [
            'category' => $evt->category ?: '',
            'action' => $evt->action ?: '',
        ];

        $eventData['selector'] = match ($evt->event) {
            EtrackerEventsModel::EVT_LOGIN_SUCCESS, EtrackerEventsModel::EVT_LOGIN_FAILURE, EtrackerEventsModel::EVT_LOGOUT, EtrackerEventsModel::EVT_USER_REGISTRATION => null,
            EtrackerEventsModel::EVT_MAIL => 'a[href^="mailto:"]',
            EtrackerEventsModel::EVT_PHONE => 'a[href^="tel:"]',
            EtrackerEventsModel::EVT_GALLERY => 'a[data-lightbox]',
            EtrackerEventsModel::EVT_DOWNLOAD => '.download-element a',
            EtrackerEventsModel::EVT_ACCORDION => 'section.ce_accordion div[aria-expanded="false"],h2.handorgel__header:not(.handorgel__header--opened)',
            EtrackerEventsModel::EVT_LANGUAGE => '.mod_changelanguage li a',
            default => html_entity_decode($evt->selector ?? ''),
        };

        switch ($evt->object) {
            case EtrackerEventsModel::OBJ_MODULE_NAME:
                $module = ModuleModel::findById($moduleId);
                if ($module instanceof ModuleModel) {
                    $eventData['object'] = $module->name ?: $module->type.' # '.$module->id;
                } else {
                    $eventData['object'] = 'Unknown Module #'.$moduleId;
                }
                break;
            case EtrackerEventsModel::OBJ_CUSTOM_TEXT:
                $eventData['object'] = addslashes($evt->object_text);
                break;
            default:
                $eventData['object'] = addslashes(EtrackerEventsModel::getObjectAttribute((int) ($evt->object ?? 0)));
                break;
        }

        return $eventData;
    }

    /**
     * JavaScript Code for Event Tracking.
     */
    public function generateEventTracking(PageModel $rootPage): string
    {
        $eventIds = unserialize($rootPage->etrackerEvents, [
            'allowed_classes' => false,
        ]);

        /** @var array<EtrackerEventsModel> $evts */
        $evts = EtrackerEventsModel::findMultipleByIds($eventIds);
        $script = '';
        $event = 'click';

        foreach ($evts as $evt) {
            $eventData = $this->getEventVariables($evt);

            if (null === $eventData['selector']) {
                continue;
            }

            $debug = '';
            if ($this->isDebugMode($rootPage)) {
                $debug = 'console.log('.$eventData['object'].');';
            }
            $script .= <<<JS
                    document.querySelectorAll('{$eventData['selector']}').forEach(item => item.addEventListener("$event", (evt) => {
                        {$debug}
                        if (_etracker !== undefined){
                            _etracker.sendEvent(new et_UserDefinedEvent('{$eventData['object']}', '$evt->category', '$evt->action', '$evt->type'));
                        }
                    }));
                JS;
        }

        return FrontendTemplate::generateInlineScript($script);
    }

    /**
     * Baut das Script-Element via PHP zusammen.
     *
     * @throws \DOMException
     */
    public function getScriptCode(PageModel $rootPage): string
    {
        $document = new \DOMDocument();
        $script = $document->createElement('script');
        $script->setAttribute('type', 'text/javascript');
        $script->setAttribute('charset', 'UTF-8');
        $script->setAttribute('id', '_etLoader');

        // @see
        // https://www.etracker.com/docs/faq/eu-dsgvo/cookie-less-cookies/wie-setze-ich-etracker-ohne-cookies-ein/
        // @see
        // https://www.etracker.com/docs/faq/eu-dsgvo/cookie-less-cookies/wie-aktiviere-ich-cookies/
        $script->setAttribute('data-block-cookies', 'true');

        //        $script->setAttribute('data-cookie-lifetime', '24'); // standard:
        // 24 = 24 Monate        $script->setAttribute('data-cookie-upgrade-url',
        // htmlspecialchars($cookieUpgradeURL)); @see
        // https://www.etracker.com/tipp-der-woche-do-not-track/
        if (true === (bool) $rootPage->etrackerDoNotTrack) {
            $script->setAttribute('data-respect-dnt', 'true');
        }

        // @see
        // https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/funktion-zweck/#Standardintegration
        $script->setAttribute('data-secure-code', $rootPage->etrackerAccountKey);

        // Mozilla Observatory complains protocol-relative URLs, if Subresource Integrity
        // (SRI) is not implemented
        $host = $rootPage->etrackerTrackingDomain ?: 'code.etracker.com';
        $src = '//'.$host.'/code/e.js';
        if ($rootPage->rootUseSSL && !str_starts_with($src, 'http')) {
            $src = 'https:'.$src;
        }

        $script->setAttribute('src', $src);
        $script->setAttribute('async', '');
        $nonce = self::getNonce();
        if (null !== $nonce) {
            $script->setAttribute('nonce', $nonce);
        }
        $document->append($script);
        $document->normalize();

        return $document->saveHTML();
    }

    /**
     * Ermitteln den JavaScript-Inhalt mit den etracker-Parametern.
     */
    public function getParameters(FrontendTemplate $objTemplate, PageModel $rootPage, PageModel $currentPage): void
    {
        $user = System::getContainer()->get('security.helper')?->getUser();

        $nonce = self::getNonce();
        if (null !== $nonce) {
            $objTemplate->nonce = $nonce;
        }

        // Bereiche
        if ('' !== ((string) $currentPage->etrackerAreas)) {
            $objTemplate->areas = $currentPage->etrackerAreas;
        } else {
            $areas = $this->getParentAreas($currentPage);
            if (\count($areas) > 0) {
                $objTemplate->areas .= implode('/', $areas);
            }
        }

        // Debug-Modus
        if ($this->isDebugMode($rootPage)) {
            $objTemplate->debugmode .= 'var _etr = { debugMode: true };'.PHP_EOL;
        }

        // Frontend-User-Information für Cross-Device-Tracking übergeben @see
        // https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/optionale-parameter/
        if ($user instanceof FrontendUser && '1' === $rootPage->etrackerCDIFEUser) {
            $objTemplate->cdi .= 'var et_cdi = "'.md5($user->getUserIdentifier()).'";'.PHP_EOL;
        }

        // @see
        // https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/eigene-segmente/
        // $feUser->gender könnte als eigenes Segment genutzt werden weitere denkbare
        // Segmente: Benutzersprache, Seitensprache, Benutzergruppe (geht aber nur eine),
        // city, state, country, Login-Status konfigurationsmöglichkeit: Segment 1:
        // [Dropdown], Segment 2: [Dropdown], ... Form conversion on form-target-page
        if ($this->session->has('ET_FORM_CONVERSION_'.$currentPage->id)) {
            // @see
            // https://www.etracker.com/en/docs/integration-setup-2/tracking-code-sdks/tracking-code-integration/event-tracker/#measure-form-interactions
            $objTemplate->formConversion = $this->session->get('ET_FORM_CONVERSION_'.$currentPage->id);

            // FORM_DATA zurücksetzen, damit das Event kein zweites Mal getriggert wird
            $this->session->remove('ET_FORM_CONVERSION'.$currentPage->id);
        }
    }

    /**
     * Ermittelt, ob das Tracking für die aktuelle Root-Page erlaubt/aktiviert ist.
     */
    public static function isTrackingEnabled(PageModel|null $rootPage = null): bool
    {
        if (null === $rootPage) {
            $rootPage = self::getRootPage();
        }

        if (!$rootPage instanceof PageModel) {
            return false;
        }

        $enabled = (bool) $rootPage->etrackerEnable;
        $excludeBeUser = (bool) $rootPage->etrackerExcludeBEUser;
        $excludeFeUser = (bool) $rootPage->etrackerExcludeFEUser;

        // Ausgabe nur, wenn aktiv und für den Nutzer zugelassen ist
        $user = System::getContainer()->get('security.helper')?->getUser();
        $beHide = $excludeBeUser && null !== BackendUser::getInstance()->id;
        $feHide = $excludeFeUser && $user instanceof FrontendUser;

        return $enabled && false === $beHide && false === $feHide;
    }

    public static function getNonce(): string|null
    {
        // Only generate nonce if CSP is enabled via settings
        /** @var bool|null $cspEnabled */
        $cspEnabled = self::getRootPage()->enableCsp;
        if (false === $cspEnabled) {
            return null;
        }

        $responseContext = System::getContainer()->get('contao.routing.response_context_accessor')?->getResponseContext();
        if ($responseContext instanceof ResponseContext && $responseContext->has(CspHandler::class)) {
            /** @var CspHandler $cspHandler */
            $cspHandler = $responseContext->get(CspHandler::class);

            return $cspHandler->getNonce('script-src');
        }

        return null;
    }

    public function getTriggerNameForEvent(int $event): string|null
    {
        return match ($event) {
            EtrackerEventsModel::EVT_LOGIN_SUCCESS => 'etracker_event_login',
            EtrackerEventsModel::EVT_LOGIN_FAILURE => 'etracker_event_login_failure',
            EtrackerEventsModel::EVT_LOGOUT => 'etracker_event_logout',
            EtrackerEventsModel::EVT_USER_REGISTRATION => 'etracker_event_registration',
            default => null,
        };
    }

    private function isTriggered(EtrackerEventsModel $evt, string $triggerName): bool
    {
        if (!$this->session->has($triggerName)) {
            return false;
        }

        $moduleId = (string) $this->session->get($triggerName);
        if ('' === $moduleId) {
            return false;
        }

        // no module check if logout event, because there is no logout module
        if (EtrackerEventsModel::EVT_LOGOUT === $evt->event) {
            return true;
        }

        // Check if the event is triggered for a module which is set as target for this event
        $targetModules = StringUtil::deserialize($evt->target_modules, true);
        if (!\in_array($moduleId, $targetModules, true)) {
            return false;
        }

        return true;
    }

    private function injectDetectedEventsScript(bool $trackingEnabled): void
    {
        $rootPage = self::getRootPage();
        if (!$rootPage instanceof PageModel) {
            return;
        }

        $eventIds = unserialize($rootPage->etrackerEvents, ['allowed_classes' => false]);
        $evts = EtrackerEventsModel::findMultipleByIds($eventIds);

        foreach ($evts as $evt) {
            /** @var EtrackerEventsModel $evt */
            $eventData['category'] = $evt->category ?: '';
            $eventData['action'] = $evt->action ?: '';

            $triggerName = $this->getTriggerNameForEvent((int) $evt->event);
            if (!$triggerName) {
                continue;
            }

            if ($this->isTriggered($evt, $triggerName)) {
                $moduleId = $this->session->get($triggerName);
                $eventData = $this->getEventVariables($evt, (int) $moduleId);
                $eventData['triggerName'] = $triggerName;

                $this->generateEventScript($eventData, $trackingEnabled);
            }
        }
    }

    private function generateEventScript(array $eventData, bool $trackingEnabled): void
    {
        if ($trackingEnabled) {
            $script = "document.addEventListener('DOMContentLoaded', () => {
  _etrackerOnReady.push(function () {
    _etracker.sendEvent(new et_UserDefinedEvent('{$eventData['category']}', '{$eventData['object']}', '{$eventData['action']}'));
  });";

            if ($this->isDebugMode(self::getRootPage())) {
                $script .= 'console.log("Event mit Aktion '.$eventData['action'].' ausgelöst");';
            }

            $script .= '});';

            $GLOBALS['TL_BODY'][] = FrontendTemplate::generateInlineScript($script);
        }
        $this->session->remove($eventData['triggerName']);
    }

    /**
     * Gets the name of the page.
     *
     * @param bool $readHeadBag If the HtmlHeadBag should be used to detect the page name
     */
    private function getPagename(PageModel $page, bool $readHeadBag = true): string
    {
        $etPagename = trim((string) $page->etrackerPagename);
        if ('' !== $etPagename) {
            return $etPagename;
        }

        $responseContext = System::getContainer()->get('contao.routing.response_context_accessor')?->getResponseContext();
        if ($readHeadBag && null !== $responseContext && $responseContext?->has(HtmlHeadBag::class)) {
            /** @var HtmlHeadBag $htmlHeadBag */
            $htmlHeadBag = $responseContext->get(HtmlHeadBag::class);

            // Read the title from HtmlHeadBag to get the title of news, events etc. instead
            // of the page name
            return $htmlHeadBag->getTitle();
        }

        return $page->pageTitle ?: $page->title;
    }

    /**
     * @return array<int, string>
     */
    private function getParentAreas(PageModel $page): array
    {
        $areas = [];
        $parentPages = PageModel::findParentsById($page->id) ?? [];

        foreach ($parentPages as $parent) {
            if ($parent->id === $page->id) {
                continue;
            }

            if ('root' === $parent->type && '' === (string) $parent->etrackerAreaname) {
                continue;
            }

            $areas[] = trim((string) $parent->etrackerAreaname) ?: $this->getPagename($parent, false);
        }

        return array_reverse($areas);
    }

    private static function getRootPage(): PageModel|null
    {
        return PageModel::findById($GLOBALS['objPage']->rootId);
    }

    private function isDebugMode(PageModel $rootPage): bool
    {
        return 'enabled' === $rootPage->etrackerDebug || ('backend-user' === $rootPage->etrackerDebug && null !== BackendUser::getInstance()->id);
    }
}
