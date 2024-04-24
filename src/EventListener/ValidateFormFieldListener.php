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
use Contao\FrontendTemplate;
use Contao\Widget;

#[AsHook('validateFormField')]
class ValidateFormFieldListener
{
    /**
     * @param array<int, mixed> $formData
     */
    public function __invoke(Widget $widget, string $formId, array $formData, Form $form): Widget
    {
        $trackingEnabled = GeneratePageListener::isTrackingEnabled();

        // nur Script-Block erweitern, wenn Formular-Tracking aktiv ist
        if ($trackingEnabled && 1 === $form->{'etrackerFormTracking'}) {
            $objTemplate = new FrontendTemplate('analytics_etracker_events');

            $objTemplate->{'et_event_script'} = $this->getScript($widget, $form);

            $GLOBALS['TL_BODY'][] = $objTemplate->parse();
        }

        return $widget;
    }

    public function getScript(Widget $widget, Form $form): string
    {
        if (isset($_SESSION) && \is_array($_SESSION) && \array_key_exists('FORM_DATA', $_SESSION) && \is_array($_SESSION['FORM_DATA']) && \array_key_exists('ET_FORM_TRACKING_DATA', $_SESSION['FORM_DATA']) && !empty($_SESSION['FORM_DATA']['FORM_SUBMIT'])) {
            if ($form->id === $_SESSION['FORM_DATA']['ET_FORM_TRACKING_DATA']['FORMID']) {
                // @see
                // https://www.etracker.com/en/docs/integration-setup-2/tracking-code-sdks/tracking-code-integration/event-tracker/#measure-form-interactions
                return "etForm.sendEvent('formFieldError', '".$_SESSION['FORM_DATA']['ET_FORM_TRACKING_DATA']['NAME']."',
     {
           'sectionName': 'Standard',
           'sectionField': {'name': '".$this->getFieldName($widget)."','type': '".$widget->type."'}
     }
);";
            }
        }

        return '';
    }

    private function getFieldName(Widget $widget): string
    {
        return $widget->label ?: $widget->{'placeholder'} ?: $widget->name;
    }
}
