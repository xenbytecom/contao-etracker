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

use Contao\BackendTemplate;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\FrontendTemplate;

#[AsHook('parseTemplate')]
class ParseTemplateListener
{
    public function __invoke(BackendTemplate|FrontendTemplate $template): void
    {
        if (isset($template->count) && 'mod_search' === $template->getName()) {
            $template->etrackerEnable = GeneratePageListener::isTrackingEnabled();
            $template->nonce = GeneratePageListener::getNonce();

            if ($template->etrackerEnable && $template->etrackerSearchCampaignEnable) {
                $objTemplate = new FrontendTemplate('etracker_search_code');

                if (0 === $template->count) {
                    $objTemplate->etrackerSearchCampaign = $template->etrackerSearchCmpOnsiteNoresults;
                } else {
                    $objTemplate->etrackerSearchCampaign = $template->etrackerSearchCmpOnsiteResults;
                }
                $objTemplate->etrackerSearchMedOnsite = $template->etrackerSearchMedOnsite;
                $objTemplate->keyword = $template->keyword;

                $GLOBALS['TL_BODY'][] = $objTemplate->parse();
            }
        }
    }
}
