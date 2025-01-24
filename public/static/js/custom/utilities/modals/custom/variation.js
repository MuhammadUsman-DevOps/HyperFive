// Define form element
const addVariationForm = document.getElementById('add_variation_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addVariationValidator = FormValidation.formValidation(
    addVariationForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'variation name is required'
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
const variationSubmitButton = document.getElementById('add_variation_modal_submit');
variationSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addVariationValidator) {
        addVariationValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                variationSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                variationSubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                addVariationForm.submit(); // Submit form
            }
        });
    }
});





// Edit variation Code


// Define form element
const editVariationForm = document.getElementById('edit_variation_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var editVariationFormValidator = FormValidation.formValidation(
    editVariationForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'name is required'
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
const editVariationSubmitButton = document.getElementById('edit_variation_modal_submit');
editVariationSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (editVariationFormValidator) {
        editVariationFormValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                editVariationSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                editVariationSubmitButton.disabled = true;
                editVariationForm.submit();

            }
        });
    }
});
var target = document.querySelector("#kt_body");
var blockUI = new KTBlockUI(target, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
});


function editVariation(id) {
    blockUI.block();
    // Send AJAX request to server
    $.ajax({
        url: '/menus/variation/edit/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.data){
                $('#edit_variation_modal_form input[name="name"]').val(response.data.name);
                $('#edit_variation_modal_form input[name="id"]').val(response.data.id);
                $('#edit_variation_modal_form input[name="description"]').val(response.data.description);
                $('#edit_variation_modal_form input[name="priority"]').val(response.data.priority);
                var webThumbnailUrl = response.data.web_thumbnail;
                var appThumbnailUrl = response.data.app_thumbnail;
                $('#web_thumbnail').closest('.image-input').find('.image-input-wrapper').css('background-image', 'url(' + webThumbnailUrl + ')');
                $('#app_thumbnail').closest('.image-input').find('.image-input-wrapper').css('background-image', 'url(' + appThumbnailUrl + ')');

                $('#edit_variation_modal_form input[name="is_active"]').prop('checked', response.data.is_active);
                blockUI.release();
                // Show the modal form
                $('#edit_variation_modal').modal('show');
            }else{
                blockUI.release();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No Variation data found!',
                    buttonsStyling: !1,
                    confirmButtonText: "Oh! ok :(",
                    customClass: {confirmButton: "btn btn-primary"}
                });
            }

        },
        error: function(xhr, status, error) {
            blockUI.release();
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong',
            });
        }
    });
}


function deleteVariation(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this Variation!',
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/menus/variation/delete/' + id
        }
    });
}


function deactivateVariation(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers wont be able to see this Variation',
        icon: 'warning',
        confirmButtonText: 'Yes, deactivate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/menus/variation/deactivate/' + id
        }else {
            // If user cancels, check the checkbox again
            $('#var_' + id).prop('checked', true);
        }
    });
}

function activateVariation(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers will be able to see this Variation',
        icon: 'warning',
        confirmButtonText: 'Yes, Activate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/menus/variation/activate/' + id
        }else{
            // If user cancels, check the checkbox again
            $('#var_' + id).prop('checked', true);
        }
    });
}


$(document).ready(function() {

    $('[id^=var_]').change(function() {
        var id = $(this).attr('id').split('_')[1];
        if ($(this).is(':checked')) {
            activateVariation(id);

        } else {
            deactivateVariation(id);
        }
    });



});
function addVariationItem(variationId) {
    $("#add_variation_item_modal").modal('show');
    $("#variation_id").val(variationId);

}


