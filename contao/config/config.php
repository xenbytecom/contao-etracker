<?php
declare(strict_types=1);

use Xenbyte\ContaoEtracker\Model\EtrackerEventsModel;

// Back end modules
$GLOBALS['BE_MOD']['system']['etracker-Events'] = [
    'tables' => [
        'tl_etracker_events',
    ],
];

// Models
$GLOBALS['TL_MODELS']['tl_etracker_events']  = EtrackerEventsModel::class;
