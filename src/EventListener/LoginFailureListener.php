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

use Contao\ModuleModel;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

#[AsEventListener]
class LoginFailureListener
{
    public function __invoke(LoginFailureEvent $event): void
    {
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

        $session->set('etracker_event_login_failure', $module->id);
    }
}
