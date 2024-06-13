<?php

declare(strict_types=1);

namespace Xenbyte\ContaoEtracker\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Xenbyte\ContaoEtracker\Model\EtrackerEventsModel;

/**
 * Beispiel-Kategorien als Vorlage bei Wechsel des Ereignis-Feldes.
 */
#[AsCallback(table: 'tl_etracker_events', target: 'fields.category.load')]
class EventCategoryDefaultCallback
{
    public function __invoke(string $currentValue, DataContainer|null $dc = null): string
    {
        if (null === $dc || '' !== $currentValue) {
            return $currentValue;
        }

        $category = '';
        $current = $dc->getCurrentRecord();

        if (\is_array($current) && \array_key_exists('event', $current)) {
            switch ($current['event']) {
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
        }

        return $category;
    }
}
