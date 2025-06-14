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

use Contao\FrontendUser;
use Contao\ModuleModel;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LogoutEvent;

#[AsEventListener]
class LogoutListener
{
    public function __invoke(LogoutEvent $event): void
    {
        $user = $event->getToken()?->getUser();

        // Ensure the user is an instance of FrontendUser
        if (!$user instanceof FrontendUser) {
            return;
        }

        $request = $event->getRequest();
        $session = $request->getSession();
        $moduleId = $session->has('etracker_logout_module') ? $session->get('etracker_logout_module') : null;

        if (!$moduleId) {
            return;
        }

        $module = ModuleModel::findById((int) $moduleId);

        if (!$module) {
            return;
        }

        $session->set('etracker_event_logout', $module->id);
    }
}
