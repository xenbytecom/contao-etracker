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

namespace Xenbyte\ContaoEtracker\Tests\EventListener;

use Contao\BackendUser;
use Contao\FrontendUser;
use Contao\PageModel;
use Contao\System;
use Contao\TestCase\ContaoTestCase;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\RoleVoter;
use Xenbyte\ContaoEtracker\EventListener\GeneratePageListener;

class GeneratePageListenerTest extends ContaoTestCase
{
    private GeneratePageListener $listener;

    private MockObject $security;

    protected function setUp(): void
    {
        $this->listener = new GeneratePageListener();

        $this->security = $this->createMock(Security::class);

        $this->container = $this->getContainerWithContaoConfiguration();

        $security = $this->createMock(Security::class);
        $this->container->set('security.helper', $security);
        $this->container->set('security.token_storage', $this->createMock(TokenStorageInterface::class));
        $this->container->set('security.firewall.map', $this->createMock(FirewallMap::class));
        $this->container->set('security.authentication.trust_resolver', $this->createMock(AuthenticationTrustResolver::class));
        $this->container->set('security.access.simple_role_voter', $this->createMock(RoleVoter::class));
        $this->container->set('database_connection', $this->createMock(Connection::class));

        System::setContainer($this->container);
    }

    protected function tearDown(): void
    {
        $this->resetStaticProperties([BackendUser::class]);

        parent::tearDown();
    }

    public function testDisabledTracking(): void
    {
        $config = $this->getDefaultConfig();
        $config['etrackerEnable'] = false;
        $rootPage = $this->mockClassWithProperties(PageModel::class, $config);

        $this->assertFalse($this->listener::isTrackingEnabled($rootPage));
    }

    public function testDisabledTrackingExcludedBEUser(): void
    {
        $user = $this->mockClassWithProperties(BackendUser::class, ['id' => 12]);

        $token = $this->createMock(TokenInterface::class);
        $token
            ->method('getUser')
            ->willReturn($user)
        ;

        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $tokenStorage
            ->method('getToken')
            ->willReturn($token)
        ;

        $this->container->set('security.token_storage', $tokenStorage);
        System::setContainer($this->container);

        $rootPage = $this->mockClassWithProperties(PageModel::class, $this->getDefaultConfig());

        $this->assertFalse($this->listener::isTrackingEnabled($rootPage));
    }

    public function testDisabledTrackingExcludedFEUser(): void
    {
        $user = $this->createMock(FrontendUser::class);
        $this->security
            ->method('getUser')
            ->willReturn($user)
        ;
        $this->container->set('security.helper', $this->security);
        System::setContainer($this->container);

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
