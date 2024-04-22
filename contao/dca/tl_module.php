<?php

/*
 * Contao Etracker Bundle
 *
 * (c) Xenbyte, Stefan Brauner <info@xenbyte.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

$GLOBALS['TL_DCA']['tl_module']['palettes']['etrackerOptOut'] =
    '{title_legend},name,headline;etracker_tld';

$GLOBALS['TL_DCA']['tl_module']['fields']['etrackerTLD'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['etrackerTLD'],
    'inputType' => 'text',
    'eval' => [
        'size' => 50,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(255) NOT NULL default ''",
];
