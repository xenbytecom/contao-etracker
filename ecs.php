<?php

declare(strict_types=1);

use Contao\EasyCodingStandard\Set\SetList;
use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

$year = date('Y');

return ECSConfig::configure()
    ->withSets([SetList::CONTAO])
    ->withPaths([
        __DIR__ . '/contao',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withConfiguredRule(HeaderCommentFixer::class, [
        'header' => <<<EOF
etracker integration for Contao CMS

Copyright (c) $year Xenbyte, Stefan Brauner

@author     Stefan Brauner <https://www.xenbyte.com>
@link       https://github.com/xenbytecom/contao-etracker
@license    LGPL-3.0-or-later

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF,
        'location' => 'after_open'
    ])
    ->withParallel()
    ->withCache(sys_get_temp_dir().'/ecs_ecs_cache');
