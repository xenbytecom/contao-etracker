<?php

/*
 * etracker plugin for Contao
 *
 * (c) Xenbyte, Stefan Brauner <info@xenbyte.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Xenbyte\ContaoEtracker\Controller\ContentElement\EtrackerOptoutController;

// $GLOBALS['TL_HOOKS']['generatePage'][] = [Etracker::class, 'generatePage'];

/*
 * Content elements
 */
$GLOBALS['TL_CTE']['includes']['etracker_optout'] = EtrackerOptoutController::class;
