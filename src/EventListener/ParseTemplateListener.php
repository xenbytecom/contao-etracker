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
        if ('mod_search' === $template->getName() && isset($template->count)) {
            $template->etrackerEnable = GeneratePageListener::isTrackingEnabled();
            $template->nonce = GeneratePageListener::getNonce();
        }
    }
}
