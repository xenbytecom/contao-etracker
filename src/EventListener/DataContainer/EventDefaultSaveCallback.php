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

namespace Xenbyte\ContaoEtracker\EventListener\DataContainer;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\Database\Result;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;

/**
 * Speichert die gesetzten Default-Werte unter Contao 4.13 korrekt in der Datenbank.
 */
#[AsCallback(table: 'tl_etracker_events', target: 'config.onsubmit')]
class EventDefaultSaveCallback
{
    public function __construct(private Connection $db)
    {
    }

    public function __invoke(DataContainer $dc): void
    {
        $version = (method_exists(ContaoCoreBundle::class, 'getVersion') ? ContaoCoreBundle::getVersion() : VERSION);
        if (!$dc->id || str_starts_with($version, '5.')) {
            // ignore in Contao 5 or newer
            return;
        }

        /** @var Result $record */
        $record = $dc->__get('activeRecord');

        $this->db->update(
            'tl_etracker_events',
            [
                'action' => $record->__get('action'),
                'category' => $record->__get('category'),
                'type' => $record->__get('type'),
            ],
            ['id' => $dc->id],
        );
    }
}
