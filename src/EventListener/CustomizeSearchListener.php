<?php

declare(strict_types=1);

namespace Xenbyte\ContaoEtracker\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Module;

#[AsHook('customizeSearch')]
class CustomizeSearchListener
{
    public function __invoke(array &$pageIds, string $keywords, string $queryType, bool $fuzzy, Module $module): void
    {
        $module->Template->{'etrackerEnable'} = GeneratePageListener::isTrackingEnabled();
        $module->Template->{'nonce'} = GeneratePageListener::getNonce();
    }
}
