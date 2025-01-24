// Define form element
const addVariationItemForm = document.getElementById('add_variation_item_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addVariationItemValidator = FormValidation.formValidation(
    addVariationItemForm,
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
const variationItemSubmitButton = document.getElementById('add_variation_item_modal_submit');
variationItemSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addVariationItemValidator) {
        addVariationItemValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                variationItemSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                variationItemSubmitButton.disabled = true;

                addVariationItemForm.submit(); // Submit form
            }
        });
    }
});




// Edit variation Item Code


// Define form element
const editVariationItemForm = document.getElementById('edit_variation_item_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var editVariationItemFormValidator = FormValidation.formValidation(
    editVariationItemForm,
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
const editVariationItemSubmitButton = document.getElementById('edit_variation_item_modal_submit');
editVariationItemSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (editVariationItemFormValidator) {
        editVariationItemFormValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                editVariationItemSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                editVariationItemSubmitButton.disabled = true;
                editVariationItemForm.submit();

            }
        });
    }
});
// var target = document.querySelector("#kt_body");
// var blockUI = new KTBlockUI(target, {
//     message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
// });


function editVariationItem(id) {

    blockUI.block();
    // Send AJAX request to server
    $.ajax({
        url: '/menus/variation/item/edit/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.data){
                $('#edit_variation_item_modal_form input[name="name"]').val(response.data.name);
                $('#edit_variation_item_modal_form input[name="id"]').val(response.data.id);
                $('#edit_variation_item_modal_form input[name="price"]').val(response.data.price);
                $('#edit_variation_item_modal_form input[name="discount_amount"]').val(response.data.discount_amount);

                $('#edit_variation_item_modal_form input[name="is_active"]').prop('checked', response.data.is_active);
                blockUI.release();
                console.log(response.data);
                // Show the modal form
                $('#edit_variation_item_modal').modal('show');
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


function deleteVariationItem(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this variation item!',
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/menus/variation/item/delete/' + id
        }
    });
}


