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
use Contao\FormFieldModel;
use Contao\FrontendTemplate;

#[AsHook('compileFormFields')]
class CompileFormFieldsListener
{
    /**
     * @param array<int, FormFieldModel> $fields
     *
     * @return array<int, FormFieldModel>
     *
     * @throws \JsonException
     */
    public function __invoke(array $fields, string $formId, Form $form): array
    {
        $trackingEnabled = GeneratePageListener::isTrackingEnabled();

        // TODO: Am besten wäre es, wenn die Events nicht erzeugt werden, wenn das
        // Formular schon ohne HTML5 validiert wurde. Sonst doppelte Read-Ereignisse
        $formTracking = (bool) $form->etrackerFormTracking;

        // nur Script-Block erweitern, wenn Formular-Tracking aktiv ist
        if ($trackingEnabled && $formTracking) {
            $GLOBALS['TL_BODY'][] = FrontendTemplate::generateScriptTag('bundles/contaoetracker/formevents.js');

            $this->setFieldAttributes($fields);

            // Formular-Name als temporäres Hidden-Feld hinzufügen
            $fname = new FormFieldModel();
            $fname->type = 'hidden';
            $fname->name = 'et_form_name';
            if (($form->etrackerFormName ?? '') !== '') {
                $fname->value = $form->etrackerFormName;
            } else {
                $fname->value = $form->title;
            }
            $fields[] = $fname;
        }

        return $fields;
    }

    /**
     * @param array<int, FormFieldModel> $fields
     */
    public function setFieldAttributes(array $fields): void
    {
        $section = 'Standard';
        $previousSection = [];

        foreach ($fields as $field) {
            if (1 === (int) $field->etrackerIgnoreField || true === $field->invisible || 'hidden' === $field->type) {
                continue;
            }

            if ('fieldsetStart' === $field->type && '' !== $field->label) {
                $previousSection[] = $section;
                $section = $field->label;
                continue;
            }

            if ('fieldsetStop' === $field->type) {
                $section = array_pop($previousSection);
                continue;
            }

            $field->{'data-et-name'} = $this->getFieldName($field);
            $field->{'data-et-section'} = $section;
            if (($field->etrackerFormSection ?? '') !== '') {
                $field->{'data-et-section'} = $field->etrackerFormSection;
            }

            // etracker field name as data attribute
            $field->{'data-et-name'} = $this->getFieldName($field);
        }
    }

    private function getFieldName(FormFieldModel $field): string
    {
        // TODO: Check, if label is always set. If so, this method is unnecessary.
        return $field->label;
        //
        //        if ($field->label) {            return $field->label ?: $field->name;  
        //      }         return $field->placeholder ?: $field->name;
    }
}
