<?php

declare(strict_types=1);

use Contao\EasyCodingStandard\Set\SetList;
use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;

$year = date('Y');

return ECSConfig::configure()
    ->withSets([SetList::CONTAO])
    ->withPaths([
        __DIR__.'/contao',
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withSkip([
        HeaderCommentFixer::class => [
            __DIR__.'/ecs.php',
            __DIR__.'/rector.php',
        ],
    ])
    ->withRules([
        NoUnusedImportsFixer::class,
    ])
    ->withConfiguredRule(HeaderCommentFixer::class, [
        'header' => <<<EOF
            etracker integration for Contao CMS

            Copyright (c) $year Xenbyte, Stefan Brauner

            @author     Stefan Brauner <https://www.xenbyte.com>
            @link       https://github.com/xenbytecom/contao-etracker
            @license    MIT

            For the full copyright and license information, please view the LICENSE
            file that was distributed with this source code.
            EOF,
        'comment_type' => 'comment',
        'location' => 'after_declare_strict',
    ])
    ->withRootFiles()
    ->withParallel()
    ->withCache(sys_get_temp_dir().'/ecs_ecs_cache')
    ->withSpacing(Option::INDENTATION_SPACES, "\n")
;
