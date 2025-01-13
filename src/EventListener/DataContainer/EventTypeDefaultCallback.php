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
use Xenbyte\ContaoEtracker\Model\EtrackerEventsModel;

/**
 * Beispiel-Typen als Vorlage bei Wechsel des Ereignis-Feldes.
 */
#[AsCallback(table: 'tl_etracker_events', target: 'fields.type.load')]
class EventTypeDefaultCallback
{
    public function __invoke(string|null $currentValue, DataContainer|null $dc = null): string|null
    {
        if (null === $dc || '' !== ((string) $currentValue)) {
            return $currentValue;
        }

        $version = (method_exists(ContaoCoreBundle::class, 'getVersion') ? ContaoCoreBundle::getVersion() : VERSION);
        if (!$dc->id || str_starts_with($version, '5.')) {
            // ignore in Contao 5 or newer
            return '';
        }

        /** @var Result|null $record */
        $record = $dc->__get('activeRecord');
        if (null === $record) {
            return '';
        }

        $type = '';

        switch ($record->__get('event')) {
            case EtrackerEventsModel::EVT_MAIL:
                $type = 'mail';
                break;
            case EtrackerEventsModel::EVT_PHONE:
                $type = 'phone';
                break;
            default:
                break;
        }

        return $type;
    }
}
