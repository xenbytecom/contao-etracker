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
use Contao\Form;
use function array_key_exists;

#[AsHook('storeFormData')]
class StoreFormDataListener
{
    public function __invoke(array $data, Form $form): array
    {
        // et_form_name als hidden Feld wieder entfernen
        if(array_key_exists('et_form_name', $data)){
            unset($data['et_form_name']);
        }

        return $data;
    }
}
