// Define form element
const addPopupForm = document.getElementById('add_new_popup_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addPopupValidator = FormValidation.formValidation(
    addPopupForm,
    {
        fields: {
            'popup': {
                validators: {
                    notEmpty: {
                        message: 'please select an image'
                    }
                }
            },
            'show_until': {
                validators: {
                    notEmpty: {
                        message: 'please select an expiry date'
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
const popupSubmitButton = document.getElementById('add_new_popup_modal_submit');
popupSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addPopupValidator) {
        addPopupValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                popupSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                popupSubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                setTimeout(function () {
                    // Remove loading indication
                    popupSubmitButton.removeAttribute('data-kt-indicator');

                    // Enable button
                    popupSubmitButton.disabled = false;

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

                    addPopupForm.submit(); // Submit form
                }, 1500);
            }
        });
    }
});


function deletePopupImage(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this Popup Image!',
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/media/popup/delete/' + id
        }
    });
}


function deactivatePopupImage(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers wont be able to see this Popup Image',
        icon: 'warning',
        confirmButtonText: 'Yes, deactivate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/media/popup/deactivate/' + id
        } else {
            // If user cancels, check the checkbox again
            $('#taxid_' + id).prop('checked', true);
        }
    });
}

function activatePopupImage(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers will be able to see this Popup Image',
        icon: 'warning',
        confirmButtonText: 'Yes, Activate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/media/popup/activate/' + id
        } else {
            // If user cancels, check the checkbox again
            $('#taxid_' + id).prop('checked', true);
        }
    });
}


$(document).ready(function () {

    $('[id^=popupid_]').change(function () {
        var id = $(this).attr('id').split('_')[1];
        if ($(this).is(':checked')) {
            activatePopupImage(id);

        } else {
            deactivatePopupImage(id);
        }
    });
});
