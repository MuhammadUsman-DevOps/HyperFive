// Define form element
const editAreaForm = document.getElementById('edit_area_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var editAreaValidator = FormValidation.formValidation(
    editAreaForm,
    {
        fields: {
            'area_name': {
                validators: {
                    notEmpty: {
                        message: 'name is required'
                    }
                }
            },
            'approx_delivery_time': {
                validators: {
                    notEmpty: {
                        message: 'enter approx delivery time'
                    }
                }
            },


        },

        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: '.fv-row',
                eleInvalidClass: '',
                eleValidClass: ''
            })
        }
    }
);


// Submit button handler
const AreaSubmitButton = document.getElementById('edit_area_form_submit');
AreaSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (editAreaValidator) {
        editAreaValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                AreaSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                AreaSubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                editAreaForm.submit(); // Submit form
            }
        });
    }
});
