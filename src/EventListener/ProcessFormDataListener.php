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
use Contao\File;
use Contao\Form;

#[AsHook('processFormData')]
class ProcessFormDataListener
{
    /**
     * @param array<string, mixed>  $submittedData
     * @param array<string, mixed>  $formData
     * @param array<int, File>|null $files
     * @param array<string, string> $labels
     */
    public function __invoke(array $submittedData, array $formData, array|null $files, array $labels, Form $form): void
    {
        if (($form->etrackerFormName ?? '') !== '') {
            $formName = $form->etrackerFormName;
        } else {
            $formName = $form->title;
        }

        // Stores form name for conversion after redirect
        unset($_SESSION['ET_FORM_CONVERSION']);
        if (0 === $form->jumpTo) {
            $_SESSION['ET_FORM_CONVERSION'][$GLOBALS['objPage']->id] = $formName;
        } else {
            $_SESSION['ET_FORM_CONVERSION'][$form->jumpTo] = $formName;
        }
    }
}
