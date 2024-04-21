<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

$header = <<<EOF
etracker plugin for Contao

(c) Xenbyte, Stefan Brauner <info@xenbyte.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

return ECSConfig::configure()
    ->withSets([__DIR__ . '/vendor/contao/easy-coding-standard/config/contao.php'])
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])

    // add a single rule
    ->withConfiguredRule(
        HeaderCommentFixer::class,
        ['header' => $header, 'location' => 'after_open']
    )

    // add sets - group of rules
    ->withPreparedSets(
        arrays: true,
    // namespaces: true,
    // spaces: true,
    // docblocks: true,
    // comments: true,
    );
