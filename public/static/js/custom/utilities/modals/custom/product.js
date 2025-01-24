// Define form element
const addProductForm = document.getElementById('add_new_product_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addProductValidator = FormValidation.formValidation(
    addProductForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'name is required'
                    }
                }
            },
            'web_thumbnail': {
                validators: {
                    notEmpty: {
                        message: 'web thumbnail is required'
                    }
                }
            },
            'app_thumbnail': {
                validators: {
                    notEmpty: {
                        message: 'app thumbnail is required'
                    }
                }
            },
            'price': {
                validators: {
                    notEmpty: {
                        message: 'price is required'
                    }
                }
            },

            'category_id': {
                validators: {
                    notEmpty: {
                        message: 'select at least one category'
                    }
                }
            },
            'allowed_order_types': {
                validators: {
                    notEmpty: {
                        message: 'select at least one order type'
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
const ProductSubmitButton = document.getElementById('add_new_product_form_submit');
ProductSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addProductValidator) {
        addProductValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                ProductSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                ProductSubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                addProductForm.submit();
            }
        });
    }
});


// Edit Product Code

//
// // Define form element
// const editProductForm = document.getElementById('edit_Product_modal_form');
//
// // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
// var editProductFormValidator = FormValidation.formValidation(
//     editProductForm,
//     {
//         fields: {
//             'name': {
//                 validators: {
//                     notEmpty: {
//                         message: 'Product name is required'
//                     }
//                 }
//             },
//
//
//
//         },
//
//         plugins: {
//             trigger: new FormValidation.plugins.Trigger(),
//             bootstrap: new FormValidation.plugins.Bootstrap5({
//                 rowSelector: '.fv-row',
//                 eleInvalidClass: '',
//                 eleValidClass: ''
//             })
//         }
//     }
// );
//
//
// // Submit button handler
// const editProductSubmitButton = document.getElementById('edit_Product_modal_submit');
// editProductSubmitButton.addEventListener('click', function (e) {
//     // Prevent default button action
//     e.preventDefault();
//
//     // Validate form before submit
//     if (editProductFormValidator) {
//         editProductFormValidator.validate().then(function (status) {
//             console.log('validated!');
//
//             if (status == 'Valid') {
//                 // Show loading indication
//                 editProductSubmitButton.setAttribute('data-kt-indicator', 'on');
//
//                 // Disable button to avoid multiple click
//                 editProductSubmitButton.disabled = true;
//                 editProductForm.submit();
//
//             }
//         });
//     }
// });
//
// var target = document.querySelector("#kt_body");
// var blockUI = new KTBlockUI(target, {
//     message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
// });
//
// function editProduct(id) {
//     blockUI.block();
//     // Send AJAX request to server
//     $.ajax({
//         url: '/menus/Product/edit/' + id,
//         type: 'GET',
//         dataType: 'json',
//         success: function(response) {
//             if(response.data){
//                 $('#edit_Product_modal_form input[name="name"]').val(response.data.name);
//                 $('#edit_Product_modal_form input[name="id"]').val(response.data.id);
//                 $('#edit_Product_modal_form input[name="description"]').val(response.data.description);
//                 $('#edit_Product_modal_form input[name="priority"]').val(response.data.priority);
//                 var webThumbnailUrl = response.data.web_thumbnail;
//                 var appThumbnailUrl = response.data.app_thumbnail;
//                 $('#web_thumbnail').closest('.image-input').find('.image-input-wrapper').css('background-image', 'url(' + webThumbnailUrl + ')');
//                 $('#app_thumbnail').closest('.image-input').find('.image-input-wrapper').css('background-image', 'url(' + appThumbnailUrl + ')');
//
//                 $('#edit_Product_modal_form input[name="is_active"]').prop('checked', response.data.is_active);
//                 blockUI.release();
//                 // Show the modal form
//                 $('#edit_Product_modal').modal('show');
//             }else{
//                 blockUI.release();
//                 Swal.fire({
//                     icon: 'error',
//                     title: 'Oops...',
//                     text: 'No Product data found!',
//                     buttonsStyling: !1,
//                     confirmButtonText: "Oh! ok :(",
//                     customClass: {confirmButton: "btn btn-primary"}
//                 });
//             }
//
//         },
//         error: function(xhr, status, error) {
//             blockUI.release();
//             console.error(error);
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Oops...',
//                 text: 'Something went wrong',
//             });
//         }
//     });
// }
//
//
// function deleteProduct(id) {
//     Swal.fire({
//         title: 'Are you sure?',
//         text: 'You will not be able to recover this Product!',
//         icon: 'warning',
//         confirmButtonText: 'Yes, delete it!',
//         showCancelButton: true,
//         buttonsStyling: !1,
//         cancelButtonText: "No, return",
//         customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
//     }).then((result) => {
//         if (result.isConfirmed) {
//             window.location.href = '/menus/Product/delete/' + id
//         }
//     });
// }
//
//
