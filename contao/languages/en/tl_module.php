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

$GLOBALS['TL_LANG']['tl_module']['etracker_legend'] = 'etracker';

// fields
$GLOBALS['TL_LANG']['tl_module']['etrackerSearchCampaignEnable'] = ['enable etracker', 'Track internal search via etracker, requires etracker Pro or Enterprise'];
$GLOBALS['TL_LANG']['tl_module']['etrackerSearchMedOnsite'] = ['Onsite medium', 'Description for Onsite Medium as configured in etracker'];
$GLOBALS['TL_LANG']['tl_module']['etrackerSearchCmpOnsiteResults'] = ['Onsite campaign (with result)', 'Campaign name for search with result'];
$GLOBALS['TL_LANG']['tl_module']['etrackerSearchCmpOnsiteNoresults'] = ['Onsite campaign (without result)', 'Campaign name for search without result'];
$GLOBALS['TL_LANG']['tl_module']['etrackerTrackLogin'] = ['Track logins', 'if enabled, successful and failed login events are tracked'];
$GLOBALS['TL_LANG']['tl_module']['etrackerTrackRegistration'] = ['Track registrations', 'if enabled, user registrations events are tracked'];
