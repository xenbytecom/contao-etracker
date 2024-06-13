<?php

declare(strict_types=1);

namespace Xenbyte\ContaoEtracker\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
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
        if (null === $dc || null !== $currentValue) {
            return $currentValue;
        }

        $type = '';
        $current = $dc->getCurrentRecord();

        if (\is_array($current) && \array_key_exists('event', $current)) {
            switch ($current['event']) {
                case EtrackerEventsModel::EVT_MAIL:
                    $type = 'mail';
                    break;
                case EtrackerEventsModel::EVT_PHONE:
                    $type = 'phone';
                    break;
                default:
                    break;
            }
        }

        return $type;
    }
}
