// Define form element
const addAddonItemForm = document.getElementById('add_addon_item_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addAddonItemValidator = FormValidation.formValidation(
    addAddonItemForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'item name is required'
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
const AddonItemSubmitButton = document.getElementById('add_addon_item_modal_submit');
AddonItemSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addAddonItemValidator) {
        addAddonItemValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                AddonItemSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                AddonItemSubmitButton.disabled = true;

                addAddonItemForm.submit(); // Submit form
            }
        });
    }
});




// Edit Addon Item Code


// Define form element
const editAddonItemForm = document.getElementById('edit_addon_item_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var editAddonItemFormValidator = FormValidation.formValidation(
    editAddonItemForm,
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
const editAddonItemSubmitButton = document.getElementById('edit_addon_item_modal_submit');
editAddonItemSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (editAddonItemFormValidator) {
        editAddonItemFormValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                editAddonItemSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                editAddonItemSubmitButton.disabled = true;
                editAddonItemForm.submit();

            }
        });
    }
});
// var target = document.querySelector("#kt_body");
// var blockUI = new KTBlockUI(target, {
//     message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
// });


function editAddonItem(id) {

    blockUI.block();
    // Send AJAX request to server
    $.ajax({
        url: '/menus/addon/item/edit/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.data){
                $('#edit_addon_item_modal_form input[name="name"]').val(response.data.name);
                $('#edit_addon_item_modal_form input[name="id"]').val(response.data.id);
                $('#edit_addon_item_modal_form input[name="price"]').val(response.data.price);
                $('#edit_addon_item_modal_form input[name="discount_amount"]').val(response.data.discount_amount);

                $('#edit_addon_item_modal_form input[name="is_active"]').prop('checked', response.data.is_active);
                $('#variation_item_id_edit').val(response.data.variation_item_id).trigger('change');
                blockUI.release();
                console.log(response.data);
                // Show the modal form
                $('#edit_addon_item_modal').modal('show');
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


function deleteAddonItem(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this Addon item!',
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/menus/addon/item/delete/' + id
        }
    });
}


