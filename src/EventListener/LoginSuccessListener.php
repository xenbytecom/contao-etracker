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

use Contao\FrontendUser;
use Contao\ModuleModel;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

#[AsEventListener]
class LoginSuccessListener
{
    public function __invoke(LoginSuccessEvent $event): void
    {
        $user = $event->getAuthenticatedToken()->getUser();

        if (!$user instanceof FrontendUser) {
            return;
        }

        $request = $event->getRequest();
        $session = $request->getSession();
        $moduleId = $session->has('etracker_login_module') ? $session->get('etracker_login_module') : null;

        if (!$moduleId) {
            return;
        }

        $module = ModuleModel::findById((int) $moduleId);

        if (!$module) {
            return;
        }

        $session->remove('etracker_login_module');
        $session->set('etracker_event_login', $module->id);
    }
}
