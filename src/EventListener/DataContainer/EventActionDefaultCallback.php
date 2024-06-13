<?php

declare(strict_types=1);

namespace Xenbyte\ContaoEtracker\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Xenbyte\ContaoEtracker\Model\EtrackerEventsModel;

/**
 * Beispiel-Aktionen als Vorlage bei Wechsel des Ereignis-Feldes.
 */
#[AsCallback(table: 'tl_etracker_events', target: 'fields.action.load')]
class EventActionDefaultCallback
{
    public function __invoke(string|null $currentValue, DataContainer|null $dc = null): string|null
    {
        if (null === $dc || null !== $currentValue) {
            return $currentValue;
        }

        $category = '';
        $current = $dc->getCurrentRecord();

        if (\is_array($current) && \array_key_exists('event', $current)) {
            switch ($current['event']) {
                case EtrackerEventsModel::EVT_MAIL:
                case EtrackerEventsModel::EVT_PHONE:
                    $category = 'Klick';
                    break;
                case EtrackerEventsModel::EVT_GALLERY:
                    $category = 'Lightbox';
                    break;
                case EtrackerEventsModel::EVT_DOWNLOAD:
                    $category = 'Download';
                    break;
                case EtrackerEventsModel::EVT_LANGUAGE:
                case EtrackerEventsModel::EVT_ACCORDION:
                    $category = 'Auswahl';
                    break;
                default:
                    break;
            }
        }

        return $category;
    }
}
