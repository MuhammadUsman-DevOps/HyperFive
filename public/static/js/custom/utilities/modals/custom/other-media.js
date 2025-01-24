// Define form element
const addotherForm = document.getElementById('add_new_other_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addotherValidator = FormValidation.formValidation(
    addotherForm,
    {
        fields: {
            'images': {
                validators: {
                    notEmpty: {
                        message: 'please select images'
                    }
                }
            },
            'type': {
                validators: {
                    // Conditional validator function
                    callback: {
                        message: 'Media type is required',
                        callback: function (input) {
                            // Get the value of the "media_type" field
                            var mediaType = addotherForm.querySelector('[name="media_type"]:checked').value;
                            // Check if the "media_type" is "other" and the "type" field is not empty
                            if (mediaType === 'other' && input.value.trim() === '') {
                                return {
                                    valid: false
                                };
                            }
                            return true;
                        }
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
const otherSubmitButton = document.getElementById('add_new_other_modal_submit');
otherSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addotherValidator) {
        addotherValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                otherSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                otherSubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                setTimeout(function () {
                    // Remove loading indication
                    otherSubmitButton.removeAttribute('data-kt-indicator');

                    // Enable button
                    otherSubmitButton.disabled = false;
                    addotherForm.submit(); // Submit form
                }, 1500);
            }
        });
    }
});


$('[name="media_type"]').change(function () {
    var selectedValue = $(this).val();
    if (selectedValue === "other") {
        $('#typeDiv').removeClass('d-none');
    } else {

        $('#typeDiv').addClass('d-none');
    }
});

var myDropzone = new Dropzone("#media_images", {
    url: "/", // Set the url for your upload script location
    paramName: "file", // The name that will be used to transfer the file
    maxFiles: 10,
    maxFilesize: 10, // MB
    addRemoveLinks: true,
    autoProcessQueue: false,
    accept: function (file, done) {
        if (file.name == "wow.jpg") {
            done("Naha, you don't.");
        } else {
            done();
        }
    }
});


function deleteOtherMedia(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this Media!',
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/media/other/delete/' + id
        }
    });
}

