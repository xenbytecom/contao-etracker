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
use Contao\Form;

#[AsHook('storeFormData')]
class StoreFormDataListener
{
    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    public function __invoke(array $data, Form $form): array
    {
        // et_form_name als hidden Feld wieder entfernen
        if (\array_key_exists('et_form_name', $data)) {
            unset($data['et_form_name']);
        }

        return $data;
    }
}
