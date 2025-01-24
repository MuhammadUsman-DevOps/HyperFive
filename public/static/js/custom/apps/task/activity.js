// Define form element
const addActivityForm = document.getElementById('user_filter_leads');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addActivityValidator = FormValidation.formValidation(
    addActivityForm,
    {
        fields: {
            'start_date': {
                validators: {
                    notEmpty: {
                        message: 'Start date is required'
                    }
                }
            },
            'end_date': {
                validators: {
                    notEmpty: {
                        message: 'End date is required '
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
const ActivitySubmitButton = document.getElementById('user_filter_leads_submit');
ActivitySubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addActivityValidator) {
        addActivityValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                ActivitySubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                ActivitySubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                setTimeout(function () {
                    // Remove loading indication
                    ActivitySubmitButton.removeAttribute('data-kt-indicator');

                    // Enable button
                    ActivitySubmitButton.disabled = false;

                    // Show popup confirmation
                    // Swal.fire({
                    //     text: "Form has been successfully submitted!",
                    //     icon: "success",
                    //     buttonsStyling: false,
                    //     confirmButtonText: "Ok, got it!",
                    //     customClass: {
                    //         confirmButton: "btn btn-primary"
                    //     }
                    // });

                    addActivityForm.submit(); // Submit form
                }, 1500);
            }
        });
    }
});
