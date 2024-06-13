<?php

/*
 * etracker plugin for Contao
 *
 * (c) Xenbyte, Stefan Brauner <info@xenbyte.com>
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
use Contao\PageModel;
use Contao\PageRegular;
use Contao\System;
use Nelmio\SecurityBundle\EventListener\ContentSecurityPolicyListener;
use Xenbyte\ContaoEtracker\Model\EtrackerEventsModel;

#[AsHook('generatePage')]
class GeneratePageListener
{
    public function __invoke(PageModel $pageModel, LayoutModel $layout, PageRegular $pageRegular): void
    {
        /** @var PageModel $rootPage */
        $rootPage = PageModel::findById($pageModel->rootId);

        if (self::isTrackingEnabled($rootPage)) {
            $objTemplate = new FrontendTemplate('etracker_head_code');

            // Seitenname @see
            // https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/parameter-setzen/
            $pagename = $this->getPagename($pageModel);
            if ('' !== $pagename) {
                $objTemplate->pagename = trim($pagename);
            }

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
    }

    public function generateEventTracking(PageModel $rootPage): string
    {
        $eventIds = unserialize($rootPage->etrackerEvents, [
            'allowed_classes' => false,
        ]);

        /** @var array<EtrackerEventsModel> $evts */
        $evts = EtrackerEventsModel::findMultipleByIds($eventIds);
        $script = '';

        foreach ($evts as $evt) {
            switch ($evt->event) {
                case EtrackerEventsModel::EVT_MAIL:
                    $selector = 'a[href^="mailto:"]';
                    $object = 'evt.target.textContent.trim() || evt.target.href';
                    break;
                case EtrackerEventsModel::EVT_PHONE:
                    $selector = 'a[href^="tel:"]';
                    $object = 'evt.target.textContent.trim() || evt.target.href';
                    break;
                case EtrackerEventsModel::EVT_GALLERY:
                    $selector = 'a[data-lightbox]';
                    $object = 'evt.target.href';
                    break;
                case EtrackerEventsModel::EVT_DOWNLOAD:
                    $selector = '.download-element a';
                    $object = "[].reduce.call(evt.target.childNodes, function(a, b) { return a + (b.nodeType === 3 ? b.textContent : ''); }, '').trim()";
                    break;
                case EtrackerEventsModel::EVT_ACCORDION:
                    $selector = 'section.ce_accordion div[aria-expanded="false"],h2.handorgel__header:not(.handorgel__header--opened)';
                    $object = "[].reduce.call(evt.target.childNodes, function(a, b) { return a + (b.nodeType === 3 ? b.textContent : ''); }, '').trim()";
                    break;
                case EtrackerEventsModel::EVT_LANGUAGE:
                    $selector = '.mod_changelanguage li a';
                    $object = 'evt.target.textContent.trim() || evt.target.hreflang';
                    break;
                default:
                    $selector = html_entity_decode($evt->selector ?? '');
                    if (($evt->object ?? '') !== '') {
                        $object = 'evt.target.'.$evt->object.'.trim()';
                    } else {
                        $object = $evt->object ?? 'evt.target.textContent.trim()';
                    }
                    break;
            }

            if ('' === $selector) {
                continue;
            }

            $debug = '';
            if ($this->isDebugMode($rootPage)) {
                $debug = 'console.log('.$object.');';
            }
            $script .= <<<JS
                    document.querySelectorAll('$selector').forEach(item => item.addEventListener("click", (evt) => {
                        {$debug}
                        if (_etracker !== undefined){
                            _etracker.sendEvent(new et_UserDefinedEvent($object, '$evt->category', '$evt->action', '$evt->type'));
                        }
                    }));
                JS;
        }
        $objTemplate = new FrontendTemplate('etracker_events');
        $objTemplate->et_event_script = $script;
        $objTemplate->nonce = self::getNonce();

        return $objTemplate->parse();
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

        if (true === (bool) $rootPage->etrackerOptimiser) {
            $script->setAttribute('data-enable-eo', 'true');
        }

        // Mozilla Observatory complains protocol-relative URLs, if Subresource Integrity
        // (SRI) is not implemented
        $host = $rootPage->etrackerTrackingDomain ?: 'code.etracker.com';
        $src = '//'.$host.'/code/e.js';
        if ($rootPage->rootUseSSL && !str_starts_with($src, 'http')) {
            $src = 'https:'.$src;
        }

        $script->setAttribute('src', $src);
        $script->setAttribute('async', '');
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
        $areas = $this->getParentAreas($currentPage);
        if (\count($areas) > 0) {
            $objTemplate->areas .= implode('/', $areas);
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
        //    var_dump($_SESSION['FORM_DATA']);
        if (isset($_SESSION) && \is_array($_SESSION) && \array_key_exists('ET_FORM_CONVERSION', $_SESSION) && \is_array($_SESSION['ET_FORM_CONVERSION']) && \array_key_exists($currentPage->id, $_SESSION['ET_FORM_CONVERSION'])) {
            // @see
            // https://www.etracker.com/en/docs/integration-setup-2/tracking-code-sdks/tracking-code-integration/event-tracker/#measure-form-interactions
            $objTemplate->formConversion = $_SESSION['ET_FORM_CONVERSION'][$currentPage->id];

            // FORM_DATA zurücksetzen, damit das Event kein zweites Mal getriggert wird
            unset($_SESSION['ET_FORM_CONVERSION']);
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
        $beHide = $excludeBeUser && $user instanceof BackendUser;
        $feHide = $excludeFeUser && $user instanceof FrontendUser;

        return $enabled && false === $beHide && false === $feHide;
    }

    public static function getNonce(): string|null
    {
        // Only generate nonce if CSP is enabled via Contao 5.3+ setting, in older
        // versions activated by default
        /** @var bool|null $cspEnabled */
        $cspEnabled = self::getRootPage()->enableCsp;
        if (false === $cspEnabled) {
            return null;
        }

        $responseContext = System::getContainer()->get('contao.routing.response_context_accessor')?->getResponseContext();
        if ($responseContext instanceof ResponseContext && $responseContext->has('Contao\CoreBundle\Routing\ResponseContext\Csp\CspHandler')) {
            /** @var CspHandler $cspHandler */
            $cspHandler = $responseContext->get('Contao\CoreBundle\Routing\ResponseContext\Csp\CspHandler');

            return $cspHandler->getNonce('script-src');
        }

        // CSP nonce before Contao 5.3
        if (System::getContainer()->has('xenbyte.csp_listener')) {
            /** @var ContentSecurityPolicyListener $cspListener */
            $cspListener = System::getContainer()->get('xenbyte.csp_listener');

            return $cspListener->getNonce('script');
        }

        return null;
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
        $parentPages = PageModel::findParentsById($page->id);

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
        $user = System::getContainer()->get('security.helper')?->getUser();

        return 'enabled' === $rootPage->etrackerDebug || ('backend-user' === $rootPage->etrackerDebug && $user instanceof BackendUser);
    }
}
