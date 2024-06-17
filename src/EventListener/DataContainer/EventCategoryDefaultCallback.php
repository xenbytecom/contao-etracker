<?php

/*
 * etracker integration for Contao CMS
 *
 * Copyright (c) 2024 Xenbyte, Stefan Brauner
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
 * Beispiel-Kategorien als Vorlage bei Wechsel des Ereignis-Feldes.
 */
#[AsCallback(table: 'tl_etracker_events', target: 'fields.category.load')]
class EventCategoryDefaultCallback
{
    public function __invoke(string|null $currentValue, DataContainer|null $dc = null): string
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

        $category = '';

        switch ($record->__get('event')) {
            case EtrackerEventsModel::EVT_MAIL:
            case EtrackerEventsModel::EVT_PHONE:
                $category = 'Kontakt';
                break;
            case EtrackerEventsModel::EVT_GALLERY:
                $category = 'Galerie';
                break;
            case EtrackerEventsModel::EVT_DOWNLOAD:
                $category = 'Download';
                break;
            case EtrackerEventsModel::EVT_ACCORDION:
                $category = 'Accordion';
                break;
            case EtrackerEventsModel::EVT_LANGUAGE:
                $category = 'Sprache';
                break;
            default:
                break;
        }

        return $category;
    }
}
