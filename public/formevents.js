/* global etForm */
document.addEventListener('DOMContentLoaded', () => {
  var _etrackerOnReady = typeof _etrackerOnReady === 'undefined' ? [] : _etrackerOnReady;
  _etrackerOnReady.push(function () {
    // Copy temporary et_form_name element to form and remove the field
    document.querySelectorAll('input[type="hidden"][name="et_form_name"]').forEach(fname => {
      const form = fname.form;
      form.setAttribute('data-et-form', fname.value);
      fname.remove();
    });

    const visibleForms = new Set();
    const visibleFields = new Set();
    const changedFields = new Set();
    const errorFields = new Set();

    // Form visible
    function handleFormVisibilityChange(entries, observer) {
      entries.forEach(entry => {
        const form = entry.target;
        const formName = form.getAttribute('data-et-form');
        if (entry.intersectionRatio >= 0.01 && !visibleForms.has(formName)) {
          _etracker.sendEvent(new et_UserDefinedEvent(formName, 'Formular', 'Formular aufgerufen'));
          visibleForms.add(formName);
        }
      });
    }

    // Form field visible
    function handleFieldVisibilityChange(entries, observer) {
      entries.forEach(entry => {
        const field = entry.target;
        const fieldId = field.getAttribute('id');

        if (entry.intersectionRatio === 1 && !visibleFields.has(fieldId)) {
          const formName = field.form.getAttribute('data-et-form');
          const formSection = field.getAttribute('data-et-section');
          const fieldName = field.getAttribute('data-et-name');
          visibleFields.add(fieldId);

          etForm.sendEvent('formFieldsView', formName,
            {
              'sectionName': formSection,
              'sectionFields':
                [
                  {'name': fieldName, 'type': field.type}
                ]
            }
          );

          field.addEventListener('change', (evt) => {
            if (!changedFields.has(fieldId)) {
              changedFields.add(fieldId);

              etForm.sendEvent('formFieldInteraction', formName, {
                'sectionName': formSection,
                'sectionField': {'name': fieldName, 'type': field.type}
              });
            }
          });

          field.addEventListener('invalid', (evt) => {
            if (!errorFields.has(fieldId)) {
              errorFields.add(fieldId);

              etForm.sendEvent('formFieldError', formName, {
                'sectionName': formSection,
                'sectionField': {'name': fieldName, 'type': field.type}
              });
            }
          });
        }
      });
    }

    // Erstelle einen IntersectionObserver
    const fieldObserver = new IntersectionObserver(handleFieldVisibilityChange, {
      threshold: 1
    });

    const formObserver = new IntersectionObserver(handleFormVisibilityChange, {
      threshold: 0.01
    });

    const errFields = document.querySelectorAll('[data-et-name].error');
    errFields.forEach(errField => {
      const fieldId = errField.getAttribute('id');

      if (!errorFields.has(fieldId)) {
        errorFields.add(fieldId);
        const formName = errField.form.getAttribute('data-et-form');
        const formSection = errField.getAttribute('data-et-section');
        const fieldName = errField.getAttribute('data-et-name');

        etForm.sendEvent('formFieldError', formName, {
          'sectionName': formSection,
          'sectionField': {'name': fieldName, 'type': errField.type}
        });
      }
    });

    // Wähle alle Felder aus, die ein data-name Attribut haben und beobachte sie
    const formFields = document.querySelectorAll('[data-et-name]');
    formFields.forEach(field => fieldObserver.observe(field));

    const forms = document.querySelectorAll('form[data-et-form]');
    forms.forEach(form => formObserver.observe(form));
  });
});
