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

namespace Xenbyte\ContaoEtracker\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Module;
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

        if (null === $request || false === ((bool) $module->etracker_track_registration)) {
            return;
        }

        $session = $request->getSession();

        $session->set('etracker_event_registration', $module->id);
    }
}
