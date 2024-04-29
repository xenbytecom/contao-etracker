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
use Contao\Module;

#[AsHook('customizeSearch')]
class CustomizeSearchListener
{
    /**
     * @param array<int, int> $pageIds the current page IDs to be searched though
     */
    public function __invoke(array &$pageIds, string $keywords, string $queryType, bool $fuzzy, Module $module): void
    {
        $module->Template->etrackerEnable = GeneratePageListener::isTrackingEnabled();
        $module->Template->nonce = GeneratePageListener::getNonce();
    }
}
