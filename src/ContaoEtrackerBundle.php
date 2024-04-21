<?php

/*
 * etracker plugin for Contao
 *
 * (c) Xenbyte, Stefan Brauner <info@xenbyte.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Xenbyte\ContaoEtracker;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ContaoEtrackerBundle extends Bundle
{
    public function getPath(): string
    {
        return $this->path ?? \dirname(__DIR__);
    }
}
