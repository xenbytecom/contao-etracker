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

use Contao\DataContainer;
use Contao\ModuleModel;
use Xenbyte\ContaoEtracker\Model\EtrackerEventsModel;

class EtrackerEventDcaHelper
{
    /**
     * Get module options based on the selected event type.
     */
    public function getModuleOptions(DataContainer $dc): array
    {
        $options = [];
        $currentEvent = $dc->activeRecord?->event; // Wert des 'event'-Feldes

        $moduleType = null;

        switch ($currentEvent) {
            case EtrackerEventsModel::EVT_LOGIN_SUCCESS:
            case EtrackerEventsModel::EVT_LOGIN_FAILURE:
                $moduleType = 'login';
                break;
            case EtrackerEventsModel::EVT_USER_REGISTRATION:
                $moduleType = 'registration';
                break;
        }

        if ($moduleType) {
            $modules = ModuleModel::findBy('type', $moduleType);
            if (null !== $modules) {
                while ($modules->next()) {
                    $options[$modules->id] = $modules->name.' [ID: '.$modules->id.']';
                }
            }
        }

        return $options;
    }

    public function getObjectOptions(DataContainer $dc): array
    {
        $currentEvent = $dc->activeRecord?->event; // Wert des 'event'-Feldes

        $options = [];

        switch ($currentEvent) {
            case EtrackerEventsModel::EVT_DOWNLOAD:
            case EtrackerEventsModel::EVT_ACCORDION:
                $options[] = EtrackerEventsModel::OBJ_TEXT_WIHOUT_CHILDS;
                break;
            case EtrackerEventsModel::EVT_LANGUAGE;
                $options[] = EtrackerEventsModel::OBJ_TEXT_HREFLANG_FALLBACK;
                break;
            case EtrackerEventsModel::EVT_LOGIN_SUCCESS:
            case EtrackerEventsModel::EVT_LOGIN_FAILURE:
            case EtrackerEventsModel::EVT_USER_REGISTRATION:
                $options[] = EtrackerEventsModel::OBJ_MODULE_TITLE;
                break;
            default:
                $options = [
                    EtrackerEventsModel::OBJ_TEXTCONTENT,
                    EtrackerEventsModel::OBJ_TEXT_HREF_FALLBACK,
                    EtrackerEventsModel::OBJ_TEXT_WIHOUT_CHILDS,
                    EtrackerEventsModel::OBJ_INNERTEXT,
                    EtrackerEventsModel::OBJ_ALT,
                    EtrackerEventsModel::OBJ_SRC,
                    EtrackerEventsModel::OBJ_HREF,
                    EtrackerEventsModel::OBJ_TITLE,
                ];
        }

        $options[] = EtrackerEventsModel::OBJ_CUSTOM_TEXT;

        return $options;
    }

    /**
     * Generates a more descriptive label for the event in the list view.
     */
    public function listEventLabel(array $row, string $label, DataContainer $dc, array $labelsData): string
    {
        $eventOptions = $GLOBALS['TL_DCA']['tl_etracker_events']['fields']['event']['options'] ?? [];
        $eventValue = $row['event'];
        $eventLabel = $eventOptions[$eventValue] ?? $eventValue; // Fallback auf den Wert, falls Label nicht gefunden

        return $row['title'].' <span style="color:#999;padding-left:3px;">['.$eventLabel.']</span>';
    }
}
