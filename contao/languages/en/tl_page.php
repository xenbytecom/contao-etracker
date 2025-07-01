<?php

declare(strict_types=1);

/*
 * etracker integration for Contao CMS
 *
 * Copyright (c) 2025 Xenbyte, Stefan Brauner
 *
 * @author     Stefan Brauner <https://www.xenbyte.com>
 * @link       https://github.com/xenbytecom/contao-etracker
 * @license    MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$GLOBALS['TL_LANG']['tl_page']['etracker_legend'] = 'etracker';

// fields
$GLOBALS['TL_LANG']['tl_page']['etrackerEnable'] = ['enable etracker', 'enables the etracker integration'];
$GLOBALS['TL_LANG']['tl_page']['etrackerAreaname'] = ['Area name', 'Area that is passed on to subpages for et_areas (otherwise page name or page title if no website start page)'];
$GLOBALS['TL_LANG']['tl_page']['etrackerAreas'] = ['Areas', 'Overwrites the generated area hierarchy; areas separated by "/", max. 5 levels'];
$GLOBALS['TL_LANG']['tl_page']['etrackerCDIFEUser'] = ['Cross-device tracking of front-end users', 'allows the transfer of the md5 hash of the user name as an et_cdi value for cross-device tracking'];
$GLOBALS['TL_LANG']['tl_page']['etrackerDebug'] = ['Debug mode', 'enables debug mode'];
$GLOBALS['TL_LANG']['tl_page']['etrackerCookieless'] = ['cookie less tracking', 'Tracking without cookies'];
$GLOBALS['TL_LANG']['tl_page']['etrackerTrackingDomain'] = ['custom tracking domain', 'only enter after setting up your own, different <a href="https://www.etracker.com/docs/integration-setup/tracking-code-sdks/eigene-tracking-domain-einrichten/" target="_blank">tracking domain</a>'];
$GLOBALS['TL_LANG']['tl_page']['etrackerAccountKey'] = ['key', 'etracker account key'];
$GLOBALS['TL_LANG']['tl_page']['etrackerDomain'] = ['Main Domain', 'in etracker added main domain, needed for Opt-out'];
$GLOBALS['TL_LANG']['tl_page']['etrackerPagename'] = ['page name', 'Overwrite page name, otherwise page title'];
$GLOBALS['TL_LANG']['tl_page']['etrackerDoNotTrack'] = ['Consider Do Not Track (DNT)', 'compliance is voluntary and not required for data protection-compliant use'];
$GLOBALS['TL_LANG']['tl_page']['etrackerExcludeFEUser'] = ['exclude frontend users', 'bei Aktivierung wird etracker nicht bei eingeloggten Benutzern im Frontend verwendet'];
$GLOBALS['TL_LANG']['tl_page']['etrackerExcludeBEUser'] = ['exclude backend users', 'bei Aktivierung wird etracker nicht bei eingeloggten Benutzern im Backend verwendet'];
$GLOBALS['TL_LANG']['tl_page']['etrackerEvents'] = ['etracker event tracking', 'Selection of which created events are to be tracked'];
$GLOBALS['TL_LANG']['tl_page']['etrackerOnlyPublished'] = ['only published pages', 'only published pages are tracked'];

// options
$GLOBALS['TL_LANG']['tl_page']['etrackerDebug']['options']['enabled'] = 'enabled';
$GLOBALS['TL_LANG']['tl_page']['etrackerDebug']['options']['backend-user'] = 'only backend users';
$GLOBALS['TL_LANG']['tl_page']['etrackerDebug']['options']['disabled'] = 'disabled';
