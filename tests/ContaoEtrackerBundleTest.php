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

namespace Xenbyte\ContaoEtracker\Tests;

use PHPUnit\Framework\TestCase;
use Xenbyte\ContaoEtracker\ContaoEtrackerBundle;

class ContaoEtrackerBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new ContaoEtrackerBundle();

        $this->assertInstanceOf(ContaoEtrackerBundle::class, $bundle);
    }
}
