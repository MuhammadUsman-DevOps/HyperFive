// Define form element
const addBannerForm = document.getElementById('add_new_banner_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addBannerValidator = FormValidation.formValidation(
    addBannerForm,
    {
        fields: {
            'banner': {
                validators: {
                    notEmpty: {
                        message: 'please select an image'
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
const BannerSubmitButton = document.getElementById('add_new_banner_modal_submit');
BannerSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addBannerValidator) {
        addBannerValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                BannerSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                BannerSubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                setTimeout(function () {
                    // Remove loading indication
                    BannerSubmitButton.removeAttribute('data-kt-indicator');

                    // Enable button
                    BannerSubmitButton.disabled = false;

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

                    addBannerForm.submit(); // Submit form
                }, 1500);
            }
        });
    }
});


function deleteBannerImage(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this Banner Image!',
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/media/banner/delete/' + id
        }
    });
}


function deactivateBannerImage(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers wont be able to see this Banner Image',
        icon: 'warning',
        confirmButtonText: 'Yes, deactivate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/media/banner/deactivate/' + id
        } else {
            // If user cancels, check the checkbox again
            $('#taxid_' + id).prop('checked', true);
        }
    });
}

function activateBannerImage(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers will be able to see this Banner Image',
        icon: 'warning',
        confirmButtonText: 'Yes, Activate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/media/banner/activate/' + id
        } else {
            // If user cancels, check the checkbox again
            $('#taxid_' + id).prop('checked', true);
        }
    });
}


$(document).ready(function () {

    $('[id^=bannerid_]').change(function () {
        var id = $(this).attr('id').split('_')[1];
        if ($(this).is(':checked')) {
            activateBannerImage(id);

        } else {
            deactivateBannerImage(id);
        }
    });
});
