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

namespace Xenbyte\ContaoEtracker\Tests;

use PHPUnit\Framework\TestCase;
use Xenbyte\ContaoEtracker\ContaoEtrackerBundle;

class ContaoEtrackerBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new ContaoEtrackerBundle();

        $this->assertInstanceOf('Xenbyte\ContaoEtracker\ContaoEtrackerBundle', $bundle);
    }
}
