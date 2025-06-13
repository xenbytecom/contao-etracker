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
use Contao\FrontendTemplate;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsHook('parseFrontendTemplate')]
class ParseLoginTemplateListener
{
    // RequestStack per Dependency Injection hinzufügen
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function __invoke(string $buffer, string $templateName, FrontendTemplate $template): string
    {
        $request = $this->requestStack->getCurrentRequest();

        if (null !== $request && 'mod_login' === $templateName && true === ((bool) $template->etracker_track_login) && GeneratePageListener::isTrackingEnabled()) {
            $session = $request->getSession();
            $session->set('etracker_login_module', $template->id);
        }

        return $buffer;
    }
}
