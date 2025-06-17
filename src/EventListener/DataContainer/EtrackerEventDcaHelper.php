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

use Contao\DC_Table;
use Contao\Model\Collection;
use Contao\ModuleModel;
use Xenbyte\ContaoEtracker\Model\EtrackerEventsModel;

class EtrackerEventDcaHelper
{
    /**
     * Get module options based on the selected event type.
     *
     * @return array<int, string>
     */
    public function getModuleOptions(DC_Table $table): array
    {
        $options = [];

        /** @var array<string, mixed>|null $activeRecord */
        $activeRecord = $table->getActiveRecord();
        if (null === $activeRecord || !isset($activeRecord['event'])) {
            return $options;
        }

        $moduleType = null;

        switch ($activeRecord['event']) {
            case EtrackerEventsModel::EVT_LOGIN_SUCCESS:
            case EtrackerEventsModel::EVT_LOGIN_FAILURE:
                $moduleType = 'login';
                break;
            case EtrackerEventsModel::EVT_USER_REGISTRATION:
                $moduleType = 'registration';
                break;
        }

        if ($moduleType) {
            /** @var Collection<ModuleModel> $modules */
            $modules = ModuleModel::findBy('type', $moduleType);

            while ($modules->next()) {
                /** @var ModuleModel $modules */
                $options[$modules->id] = $modules->name.' [ID: '.$modules->id.']';
            }
        }

        return $options;
    }

    /**
     * Get object options based on the selected event type.
     *
     * @return array<int, int>
     */
    public function getObjectOptions(DC_Table $table): array
    {
        $options = [];

        /** @var array<string, mixed>|null $activeRecord */
        $activeRecord = $table->getActiveRecord();
        if (null === $activeRecord || !isset($activeRecord['event'])) {
            return $options;
        }

        switch ($activeRecord['event']) {
            case EtrackerEventsModel::EVT_DOWNLOAD:
            case EtrackerEventsModel::EVT_ACCORDION:
                $options[] = EtrackerEventsModel::OBJ_TEXT_WIHOUT_CHILDS;
                break;
            case EtrackerEventsModel::EVT_LANGUAGE:
                $options[] = EtrackerEventsModel::OBJ_TEXT_HREFLANG_FALLBACK;
                break;
            case EtrackerEventsModel::EVT_LOGIN_SUCCESS:
            case EtrackerEventsModel::EVT_LOGIN_FAILURE:
            case EtrackerEventsModel::EVT_USER_REGISTRATION:
                $options[] = EtrackerEventsModel::OBJ_MODULE_NAME;
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
}
