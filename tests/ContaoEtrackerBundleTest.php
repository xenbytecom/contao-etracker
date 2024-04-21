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
