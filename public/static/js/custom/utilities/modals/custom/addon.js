// Define form element
const addAddonForm = document.getElementById('add_addon_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addAddonValidator = FormValidation.formValidation(
    addAddonForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Addon name is required'
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
const AddonSubmitButton = document.getElementById('add_addon_modal_submit');
AddonSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addAddonValidator) {
        addAddonValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                AddonSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                AddonSubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                addAddonForm.submit(); // Submit form
            }
        });
    }
});





// Edit Addon Code


// Define form element
const editAddonForm = document.getElementById('edit_addon_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var editAddonFormValidator = FormValidation.formValidation(
    editAddonForm,
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
const editAddonSubmitButton = document.getElementById('edit_addon_modal_submit');
editAddonSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (editAddonFormValidator) {
        editAddonFormValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                editAddonSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                editAddonSubmitButton.disabled = true;
                editAddonForm.submit();

            }
        });
    }
});
var target = document.querySelector("#kt_body");
var blockUI = new KTBlockUI(target, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
});


function editAddon(id) {
    blockUI.block();
    // Send AJAX request to server
    $.ajax({
        url: '/menus/addon/edit/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.data){
                $('#edit_addon_modal_form input[name="name"]').val(response.data.name);
                $('#edit_addon_modal_form input[name="id"]').val(response.data.id);
                $('#edit_addon_modal_form input[name="description"]').val(response.data.description);
                $('#edit_addon_modal_form input[name="priority"]').val(response.data.priority);
                $('#edit_addon_modal_form input[name="max_quantity"]').val(response.data.max_quantity);
                var webThumbnailUrl = response.data.web_thumbnail;
                var appThumbnailUrl = response.data.app_thumbnail;
                $('#web_thumbnail').closest('.image-input').find('.image-input-wrapper').css('background-image', 'url(' + webThumbnailUrl + ')');
                $('#app_thumbnail').closest('.image-input').find('.image-input-wrapper').css('background-image', 'url(' + appThumbnailUrl + ')');

                $('#edit_addon_modal_form input[name="is_active"]').prop('checked', response.data.is_active);
                $('#edit_addon_modal_form input[name="is_required"]').prop('checked', response.data.is_required);
                $('#edit_addon_modal_form input[name="is_multiple"]').prop('checked', response.data.is_required);
                blockUI.release();
                // Show the modal form
                $('#edit_addon_modal').modal('show');
            }else{
                blockUI.release();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No Addon data found!',
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


function deleteAddon(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this Addon!',
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/menus/addon/delete/' + id
        }
    });
}


function deactivateAddon(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers wont be able to see this Addon',
        icon: 'warning',
        confirmButtonText: 'Yes, deactivate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/menus/addon/deactivate/' + id
        }else {
            // If user cancels, check the checkbox again
            $('#add_id_' + id).prop('checked', true);
        }
    });
}

function activateAddon(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers will be able to see this Addon',
        icon: 'warning',
        confirmButtonText: 'Yes, Activate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/menus/addon/activate/' + id
        }else{
            // If user cancels, check the checkbox again
            $('#add_id_' + id).prop('checked', true);
        }
    });
}


$(document).ready(function() {

    $('[id^=add_id_]').change(function() {
        var id = $(this).attr('id').split('_')[2];
        if ($(this).is(':checked')) {
            activateAddon(id);

        } else {
            deactivateAddon(id);
        }
    });



});
function addAddonItem(addonId) {
    $("#add_addon_item_modal").modal('show');
    $("#addon_id").val(addonId);

}


