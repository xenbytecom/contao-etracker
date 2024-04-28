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
            $objTemplate = new FrontendTemplate('analytics_etracker_events');

            $objTemplate->et_event_script = $this->getScript($fields, $form);
            $objTemplate->nonce = GeneratePageListener::getNonce();

            $GLOBALS['TL_BODY'][] = $objTemplate->parse();
        }

        foreach ($fields as $field) {
            // etracker field name as data attribute
            $field->{'data-et-name'} = $this->getFieldName($field);
        }

        return $fields;
    }

    /**
     * @param array<int, FormFieldModel> $fields
     */
    public function getScript(array $fields, Form $form): string
    {
        $script = '_etrackerOnReady.push(function() {'.PHP_EOL;
        $script .= 'let etFormObjects = [];'.PHP_EOL;
        $etFormFields = [];
        $formName = $form->etrackerFormName ?: $form->title;
        $sectionName = $form->etrackerSectionName ?: 'Standard';

        // Informationen zum Formular in die Session schreiben, um bei der Validierung
        // und nach dem erfolgreichen Abseden darauf zurückgreifen zu können
        $_SESSION['FORM_DATA']['ET_FORM_TRACKING_DATA'] = [
            'NAME' => $formName,
            'JUMPTO' => $form->jumpTo,
            'FORMID' => $form->id,
        ];

        foreach ($fields as $field) {
            if (1 === $field->etrackerIgnoreField || \in_array($field->type, ['hidden', 'captcha', 'fieldsetStart', 'fieldsetStop'], true)) {
                continue;
            }

            if ('' === $field->name) {
                continue;
            }

            $fieldName = $this->getFieldName($field);

            $etFormFields[] = [
                'name' => $fieldName,
                'type' => $field->type,
            ];

            $script .= "etFormObjects.push(document.getElementById('ctrl_".$field->id."'));";
        }

        $script .= "_etracker.sendEvent(new et_UserDefinedEvent('".$formName."', 'Formular', 'Formular aufgerufen'));";
        $script .= "etFormObjects.forEach(formField => formField.addEventListener('change', (evt) => {".
             "etForm.sendEvent('formFieldInteraction', '".$formName."', {'sectionName': '".$sectionName."',".
             "'sectionField': { 'name': evt.target.getAttribute(\"data-et-name\"), 'type': evt.target.type }".'});'.
                   '}));';
        $script .= "etForm.sendEvent('formFieldsView', '"
         .$formName."', {'sectionName': 'Standard','sectionFields': "
            .json_encode($etFormFields, JSON_THROW_ON_ERROR).'});';

        // HTML5-Validierungsfehler
        if (!$form->novalidate) {
            $script .= "etFormObjects.forEach(formField => formField.addEventListener('invalid', (evt) => {
                etForm.sendEvent('formFieldError', ".$formName.", {
                    'sectionName': 'Standard',
                    'sectionField': { 'name': evt.target.getAttribute(\"data-et-name\"), 'type': evt.target.type }
                });
            }));";
        }

        $script .= '});';

        return $script;
    }

    private function getFieldName(FormFieldModel $field): string
    {
        return $field->label ?: $field->placeholder ?: $field->name;
    }
}
