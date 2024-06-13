<?php

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
