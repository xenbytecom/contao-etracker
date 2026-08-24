<?php

declare(strict_types=1);

/*
 * etracker integration for Contao CMS
 *
 * Copyright (c) 2026 Xenbyte, Stefan Brauner
 *
 * @author     Stefan Brauner <https://www.xenbyte.com>
 * @link       https://github.com/xenbytecom/contao-etracker
 * @license    MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xenbyte\ContaoEtracker\EventListener;

use Contao\CoreBundle\Event\LayoutEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * Bindet den Tracking-Code in moderne Twig-Layouts ein, die nicht über PageRegular
 * gerendert werden und daher den generatePage-Hook nicht mehr auslösen.
 */
#[AsEventListener]
class LayoutListener
{
    public function __construct(private readonly GeneratePageListener $generatePageListener)
    {
    }

    public function __invoke(LayoutEvent $event): void
    {
        $this->generatePageListener->injectInto($event->getPage());
    }
}
