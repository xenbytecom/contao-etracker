/* global etForm */
document.addEventListener('DOMContentLoaded', () => {
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

    let pendingVisibleFields = {};
    let debounceTimer;
    const DEBOUNCE_DELAY = 150; // ms

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
      let newFieldsFound = false;
      entries.forEach(entry => {
        const field = entry.target;
        const fieldId = field.getAttribute('id');

        if (entry.intersectionRatio === 1 && !visibleFields.has(fieldId)) {
          newFieldsFound = true;
          const formName = field.form.getAttribute('data-et-form');
          const formSection = field.getAttribute('data-et-section');
          const fieldName = field.getAttribute('data-et-name');
          visibleFields.add(fieldId);

          // --- Optimierung: Feld zur Bündelung hinzufügen statt sofort zu senden ---
          if (!pendingVisibleFields[formName]) {
            pendingVisibleFields[formName] = {};
          }
          if (!pendingVisibleFields[formName][formSection]) {
            pendingVisibleFields[formName][formSection] = [];
          }
          pendingVisibleFields[formName][formSection].push({'name': fieldName, 'type': field.type});

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

      if (newFieldsFound) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
          // Iteriere durch die gesammelten Felder und sende sie gebündelt
          for (const formName in pendingVisibleFields) {
            for (const sectionName in pendingVisibleFields[formName]) {
              const sectionFields = pendingVisibleFields[formName][sectionName];
              if (sectionFields.length > 0) {
                etForm.sendEvent('formFieldsView', formName, {
                  'sectionName': sectionName,
                  'sectionFields': sectionFields,
                });
              }
            }
          }
          // Setze das Sammelobjekt für den nächsten Stapel zurück
          pendingVisibleFields = {};
        }, DEBOUNCE_DELAY);
      }
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

    const formFields = document.querySelectorAll('[data-et-name]');
    formFields.forEach(field => fieldObserver.observe(field));

    const forms = document.querySelectorAll('form[data-et-form]');
    forms.forEach(form => formObserver.observe(form));
  });
});
