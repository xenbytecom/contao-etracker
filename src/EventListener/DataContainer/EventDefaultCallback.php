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

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\Database;
use Contao\DataContainer;
use Xenbyte\ContaoEtracker\Model\EtrackerEventsModel;

/**
 * Setzt die Standard-Werte in Abhängigkeit der Vorlage.
 */
#[AsCallback(table: 'tl_etracker_event', target: 'config.onbeforesubmit')]
class EventDefaultCallback
{
    /**
     * @param array<string, mixed> $values
     *
     * @return array<string, mixed>
     */
    public function __invoke(array $values, DataContainer $dc): array
    {
        // Aktuellen Wert aus der Datenbank holen
        $currentEvent = Database::getInstance()
            ->prepare('SELECT event FROM tl_etracker_event WHERE id=?')
            ->execute($dc->id)
            ->fetchAssoc()
        ;

        // Skip if event didn't change
        if (false !== $currentEvent && $currentEvent['event'] === (int) $values['event']) {
            return $values;
        }

        if (\array_key_exists('event', $values)) {
            $events = (int) $values['event'];

            switch ($events) {
                case EtrackerEventsModel::EVT_MAIL:
                    $values['category'] = 'Kontakt';
                    $values['action'] = 'Klick';
                    $values['type'] = 'mail';
                    break;
                case EtrackerEventsModel::EVT_PHONE:
                    $values['category'] = 'Kontakt';
                    $values['action'] = 'Klick';
                    $values['type'] = 'phone';
                    break;
                case EtrackerEventsModel::EVT_GALLERY:
                    $values['action'] = 'Lightbox';
                    $values['category'] = 'Galerie';
                    $values['type'] = '';
                    break;
                case EtrackerEventsModel::EVT_DOWNLOAD:
                    $values['action'] = 'Download';
                    $values['category'] = 'Download';
                    $values['type'] = '';
                    break;
                case EtrackerEventsModel::EVT_LANGUAGE:
                    $values['action'] = 'Auswahl';
                    $values['category'] = 'Sprache';
                    $values['type'] = '';
                    break;
                case EtrackerEventsModel::EVT_ACCORDION:
                    $values['action'] = 'Auswahl';
                    $values['category'] = 'Accordion';
                    $values['type'] = '';
                    break;
                case EtrackerEventsModel::EVT_LOGIN_SUCCESS:
                    $values['action'] = 'Erfolgreicher Login';
                    $values['category'] = 'Authentifizierung';
                    $values['type'] = '';
                    break;
                case EtrackerEventsModel::EVT_LOGIN_FAILURE:
                    $values['action'] = 'Fehlgeschlagener Login';
                    $values['category'] = 'Authentifizierung';
                    $values['type'] = '';
                    break;
                case EtrackerEventsModel::EVT_LOGOUT:
                    $values['action'] = 'Logout';
                    $values['category'] = 'Authentifizierung';
                    $values['type'] = '';
                    break;
                case EtrackerEventsModel::EVT_USER_REGISTRATION:
                    $values['action'] = 'Registrierung';
                    $values['category'] = 'Benutzer';
                    $values['type'] = '';
                    break;
                default:
                    break;
            }
        }

        return $values;
    }
}
