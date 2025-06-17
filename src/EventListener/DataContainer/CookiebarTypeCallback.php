<?php

declare(strict_types=1);

namespace Xenbyte\ContaoEtracker\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;

/**
 * Removes etracker fields on page settings if etracker is disabled at root level.
 */
#[AsCallback(table: 'tl_cookie', target: 'fields.type.options')]
class CookiebarTypeCallback
{
    public function __invoke(DataContainer|null $dc = null): array
    {
        $values = $GLOBALS['TL_DCA']['tl_cookie']['fields']['type']['options'];
        $values[] = 'etracker via Contao Etracker extension';

        return $values;
    }
}
