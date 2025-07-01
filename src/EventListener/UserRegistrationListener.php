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

namespace Xenbyte\ContaoEtracker\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Module;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Listener for the 'createNewUser' hook to track user registrations.
 */
#[AsHook('createNewUser')]
class UserRegistrationListener
{
    // RequestStack per Dependency Injection hinzufügen
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    /**
     * @param array<string, mixed> $userData
     */
    public function __invoke(int $userId, array $userData, Module $module): void
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request instanceof Request || false === ((bool) $module->etrackerTrackRegistration)) {
            return;
        }

        $session = $request->getSession();

        $session->set('etracker_event_registration', $module->id);
    }
}
