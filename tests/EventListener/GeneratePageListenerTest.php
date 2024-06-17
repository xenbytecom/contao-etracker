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

namespace Xenbyte\ContaoEtracker\Tests\EventListener;

use Contao\BackendUser;
use Contao\FrontendUser;
use Contao\PageModel;
use Contao\System;
use Contao\TestCase\ContaoTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Security\Core\Security;
use Xenbyte\ContaoEtracker\EventListener\GeneratePageListener;

class GeneratePageListenerTest extends ContaoTestCase
{
    private GeneratePageListener $listener;

    private MockObject $security;

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
        $config = $this->getDefaultConfig();
        $config['etrackerEnable'] = false;
        $rootPage = $this->mockClassWithProperties(PageModel::class, $config);

        $this->assertFalse($this->listener::isTrackingEnabled($rootPage));
    }

    public function testDisabledTrackingExcludedFEUser(): void
    {
        $user = $this->createMock(FrontendUser::class);
        $this->security
            ->method('getUser')
            ->willReturn($user)
        ;

        $rootPage = $this->mockClassWithProperties(PageModel::class, $this->getDefaultConfig());

        $this->assertFalse($this->listener::isTrackingEnabled($rootPage));
    }

    public function testDisabledTrackingExcludedBEUser(): void
    {
        $user = $this->createMock(BackendUser::class);
        $this->security
            ->method('getUser')
            ->willReturn($user)
        ;

        $rootPage = $this->mockClassWithProperties(PageModel::class, $this->getDefaultConfig());

        $this->assertFalse($this->listener::isTrackingEnabled($rootPage));
    }

    public function testEnabledTracking(): void
    {
        $rootPage = $this->mockClassWithProperties(PageModel::class, $this->getDefaultConfig());

        $this->assertTrue($this->listener::isTrackingEnabled($rootPage));
    }

    /**
     * @return array<string, mixed>
     */
    private function getDefaultConfig(): array
    {
        return [
            'id' => 99,
            'type' => 'root',
            'etrackerEnable' => true,
            'etrackerAccountKey' => 'abcdef',
            'etrackerOptimiser' => false,
            'etrackerDoNotTrack' => false,
            'rootUseSSL' => true,
            'etrackerTrackingDomain' => null,
            'etrackerExcludeFEUser' => true,
            'etrackerExcludeBEUser' => true,
            'etrackerDebug' => 'disabled',
            'etrackerCDIFEUser' => false,
            'etrackerAreaname' => '',
        ];
    }
}
