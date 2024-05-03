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

namespace Xenbyte\ContaoEtracker\Tests\EventListener;

use Contao\PageModel;
use Contao\TestCase\ContaoTestCase;
use Xenbyte\ContaoEtracker\EventListener\GeneratePageListener;

class GeneratePageListenerTest extends ContaoTestCase
{
    private GeneratePageListener $listener;

    protected function setUp(): void
    {
        $this->listener = new GeneratePageListener();
    }

    public function testDisabledTracking(): void
    {
        $rootPage = $this->mockClassWithProperties(PageModel::class, [
            'etrackerEnable' => false,
            'etrackerAccountKey' => 'abcdef',
        ]);

        $this->assertFalse($this->listener::isTrackingEnabled($rootPage));
    }

    public function testEnabledTracking(): void
    {
        $rootPage = $this->mockClassWithProperties(PageModel::class, [
            'etrackerEnable' => true,
            'etrackerAccountKey' => 'abcdef',
        ]);

        $this->assertTrue($this->listener::isTrackingEnabled($rootPage));
    }
}
