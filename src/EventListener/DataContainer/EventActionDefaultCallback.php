<?php

declare(strict_types=1);

namespace Xenbyte\ContaoEtracker\EventListener\DataContainer;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\Database\Result;
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

        $action = '';

        switch ($record->__get('event')) {
            case EtrackerEventsModel::EVT_MAIL:
            case EtrackerEventsModel::EVT_PHONE:
                $action = 'Klick';
                break;
            case EtrackerEventsModel::EVT_GALLERY:
                $action = 'Lightbox';
                break;
            case EtrackerEventsModel::EVT_DOWNLOAD:
                $action = 'Download';
                break;
            case EtrackerEventsModel::EVT_LANGUAGE:
            case EtrackerEventsModel::EVT_ACCORDION:
                $action = 'Auswahl';
                break;
            default:
                break;
        }

        return $action;
    }
}
