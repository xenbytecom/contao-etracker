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

use Contao\FrontendUser;
use Contao\PageModel;
use Contao\System;
use Contao\TestCase\ContaoTestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Xenbyte\ContaoEtracker\EventListener\GeneratePageListener;

class GeneratePageListenerTest extends ContaoTestCase
{
    private GeneratePageListener $listener;

    private Security $security;

    protected function setUp(): void
    {
        $this->listener = new GeneratePageListener();

        $this->security = $this->createMock(Security::class);

        $container = $this->getContainerWithContaoConfiguration();
        $container->set('security.helper', $this->security);

        System::setContainer($container);
    }

    public function testDisabledTracking(): void
    {
        $rootPage = $this->mockClassWithProperties(PageModel::class, [
            'etrackerEnable' => false,
            'etrackerAccountKey' => 'abcdef',
        ]);

        $this->assertFalse($this->listener::isTrackingEnabled($rootPage));
    }

    public function testDisabledTrackingExcludedFEUser(): void
    {
        $user = $this->createMock(FrontendUser::class);
        $this->security
            ->method('getUser')
            ->willReturn($user)
        ;

        $rootPage = $this->mockClassWithProperties(PageModel::class, [
            'etrackerEnable' => true,
            'etrackerAccountKey' => 'abcdef',
            'etrackerExcludeFEUser' => true,
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
