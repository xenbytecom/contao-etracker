<?php

/*
 * etracker integration for Contao CMS
 *
 * Copyright (c) 2024 Xenbyte, Stefan Brauner
 *
 * @author     Stefan Brauner <https://www.xenbyte.com>
 * @link       https://github.com/xenbytecom/contao-etracker
 * @license    LGPL-3.0-or-later
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use PHPUnit\Framework\TestCase;
use Xenbyte\ContaoEtracker\ContaoEtrackerBundle;
use Xenbyte\ContaoEtracker\ContaoManager\Plugin;

class PluginTest extends TestCase
{
    public function testGetBundles(): void
    {
        $parser = $this->createMock(ParserInterface::class);

        /** @var BundleConfig $config */
        $config = (new Plugin())->getBundles($parser)[0];

        $this->assertInstanceOf(BundleConfig::class, $config);
        $this->assertSame(ContaoEtrackerBundle::class, $config->getName());
        $this->assertSame([ContaoCoreBundle::class], $config->getLoadAfter());
    }
}
