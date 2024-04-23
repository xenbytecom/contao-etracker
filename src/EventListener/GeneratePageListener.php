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

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Routing\ResponseContext\HtmlHeadBag\HtmlHeadBag;
use Contao\FrontendTemplate;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\PageRegular;
use Contao\System;
use Contao\User;

#[AsHook('generatePage', priority: -5)]
class GeneratePageListener
{
    public function __invoke(PageModel $pageModel, LayoutModel $layout, PageRegular $pageRegular): void
    {
        /** @var PageModel $rootPage */
        $rootPage = PageModel::findById($pageModel->rootId);

        if (self::isTrackingEnabled()) {
            $objTemplate = new FrontendTemplate('analytics_etracker');

            $objTemplate->{'et_script'} = $this->getScriptCode($rootPage);
            $objTemplate->{'et_params'} = $this->getParameters($rootPage, $pageModel);

            $GLOBALS['TL_HEAD'][] = $objTemplate->parse();
        }
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
        if (true === (bool) $rootPage->{'etrackerDoNotTrack'}) {
            $script->setAttribute('data-respect-dnt', 'true');
        }

        // @see
        // https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/funktion-zweck/#Standardintegration
        $script->setAttribute('data-secure-code', $rootPage->{'etrackerAccountKey'});

        if (true === (bool) $rootPage->{'etrackerOptimiser'}) {
            $script->setAttribute('data-enable-eo', 'true');
        }

        // Mozilla Observatory complains protocol-relative URLs, if Subresource Integrity
        // (SRI) is not implemented
        $host = $rootPage->{'etrackerTrackingDomain'} ?: 'code.etracker.com';
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
    public function getParameters(PageModel $rootPage, PageModel $currentPage): string
    {
        $paramCode = '';

        // Seitenname @see
        // https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/parameter-setzen/
        $pagename = $this->getPagename($currentPage);
        if ('' !== $pagename) {
            $paramCode .= 'var et_pagename = "'.rawurlencode(trim($pagename)).'";'.PHP_EOL;
        }

        // Bereiche
        $areas = $this->getParentAreas($currentPage);
        if (\count($areas) > 0) {
            $paramCode .= 'var et_areas = "'.implode('/', $areas).'";'.PHP_EOL;
            //            $paramCode .= 'var et_areas = "' . rawurlencode(implode('/',
            // $areas)) . '";' . PHP_EOL;
        }

        // Debug-Modus
        if ('enabled' === $rootPage->{'etrackerDebug'} || ('backend-user' === $rootPage->{'etrackerDebug'} && System::getContainer()->get('contao.security.token_checker')?->hasBackendUser())) {
            $paramCode .= 'var _etr = { debugMode: true };';
        }

        // Frontend-User-Information für Cross-Device-Tracking übergeben @see
        // https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/optionale-parameter/
        $feUser = System::getContainer()->get('security.helper')?->getUser();
        if ($feUser instanceof User && '1' === $rootPage->{'etrackerCDIFEUser'}) {
            $paramCode .= 'var et_cdi = "'.md5($feUser->getUserIdentifier()).'";'.PHP_EOL;
        }

        // @see
        // https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/eigene-segmente/
        // $feUser->gender könnte als eigenes Segment genutzt werden weitere denkbare
        // Segmente: Benutzersprache, Seitensprache, Benutzergruppe (geht aber nur eine),
        // city, state, country, Login-Status konfigurationsmöglichkeit: Segment 1:
        // [Dropdown], Segment 2: [Dropdown], ...

        $paramCode .= 'var _etrackerOnReady = [];';

        if (isset($_SESSION) && \array_key_exists('FORM_DATA', $_SESSION) && \is_array($_SESSION['FORM_DATA']) && \array_key_exists('ET_FORM_TRACKING_DATA', $_SESSION['FORM_DATA']) && !empty($_SESSION['FORM_DATA']['FORM_SUBMIT'])) {
            $jumpToId = $_SESSION['FORM_DATA']['ET_FORM_TRACKING_DATA']['JUMPTO'];

            if ($jumpToId === $currentPage->id) {
                // @see
                // https://www.etracker.com/en/docs/integration-setup-2/tracking-code-sdks/tracking-code-integration/event-tracker/#measure-form-interactions
                $paramCode .= 'etForm.sendEvent("formConversion", '.$_SESSION['FORM_DATA']['ET_FORM_TRACKING_DATA']['NAME'].');';

                // FORM_DATA zurücksetzen, damit das Event kein zweites Mal getriggert wird
                unset($_SESSION['FORM_DATA']['ET_FORM_TRACKING_DATA']);
            }
        }

        return $paramCode;
    }

    /**
     * Ermittelt, ob das Tracking für die aktuelle Root-Page erlaubt/aktiviert ist.
     */
    public static function isTrackingEnabled(): bool
    {
        $rootPage = PageModel::findById($GLOBALS['objPage']->rootId);
        if (!$rootPage instanceof PageModel) {
            return false;
        }

        $enabled = (bool) $rootPage->{'etrackerEnable'};
        $excludeBeUser = (bool) $rootPage->{'etrackerExcludeBEUser'};
        $excludeFeUser = (bool) $rootPage->{'etrackerExcludeFEUser'};

        // Ausgabe nur, wenn aktiv und für den Nutzer zugelassen ist
        $beHide = $excludeBeUser && System::getContainer()->get('contao.security.token_checker')?->hasBackendUser();

        $feHide = $excludeFeUser && System::getContainer()->get('security.helper')?->getUser() instanceof User;

        return $enabled && '' !== $rootPage->{'etrackerAccountKey'} && false === $beHide && false === $feHide;
    }

    /**
     * Gets the name of the page.
     *
     * @param bool $readHeadBag If the HtmlHeadBag should be used to detect the page name
     */
    private function getPagename(PageModel $page, bool $readHeadBag = true): string
    {
        $etPagename = trim((string) $page->{'etrackerPagename'});
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

        return $page->{'pageTitle'} ?: $page->{'title'};
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

            if ('root' === $parent->type && '' === (string) $parent->{'etrackerAreaname'}) {
                continue;
            }

            $areas[] = trim((string) $parent->{'etrackerAreaname'}) ?: $this->getPagename($parent, false);
        }

        return array_reverse($areas);
    }
}
