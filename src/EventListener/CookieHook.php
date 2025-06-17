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
use Oveleon\ContaoCookiebar\Cookie;

#[AsHook('addCookieType')]
class CookieHook
{
    public function __invoke(string $type, Cookie $cookie): void
    {
        //        die("klappt's");        var_dump($another);        $script =
        // "_etracker.enableCookies('".Environment::get('host')."');";
    }
}
