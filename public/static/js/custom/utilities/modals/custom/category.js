// Define form element
const addCategoryForm = document.getElementById('add_new_category_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addCategoryValidator = FormValidation.formValidation(
    addCategoryForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Category name is required'
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
const categorySubmitButton = document.getElementById('add_new_category_modal_submit');
categorySubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addCategoryValidator) {
        addCategoryValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                categorySubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                categorySubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                setTimeout(function () {
                    // Remove loading indication
                    categorySubmitButton.removeAttribute('data-kt-indicator');

                    // Enable button
                    categorySubmitButton.disabled = false;

                    // Show category confirmation
                    // Swal.fire({
                    //     text: "Form has been successfully submitted!",
                    //     icon: "success",
                    //     buttonsStyling: false,
                    //     confirmButtonText: "Ok, got it!",
                    //     customClass: {
                    //         confirmButton: "btn btn-primary"
                    //     }
                    // });

                    addCategoryForm.submit(); // Submit form
                }, 1500);
            }
        });
    }
});


// Edit Category Code


// Define form element
const editCategoryForm = document.getElementById('edit_category_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var editCategoryFormValidator = FormValidation.formValidation(
    editCategoryForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Category name is required'
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
const editCategorySubmitButton = document.getElementById('edit_category_modal_submit');
editCategorySubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (editCategoryFormValidator) {
        editCategoryFormValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                editCategorySubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                editCategorySubmitButton.disabled = true;
                editCategoryForm.submit();

            }
        });
    }
});

var target = document.querySelector("#kt_body");
var blockUI = new KTBlockUI(target, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
});

function editCategory(id) {
    blockUI.block();
    // Send AJAX request to server
    $.ajax({
        url: '/menus/category/edit/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.data){
                $('#edit_category_modal_form input[name="name"]').val(response.data.name);
                $('#edit_category_modal_form input[name="id"]').val(response.data.id);
                $('#edit_category_modal_form input[name="description"]').val(response.data.description);
                $('#edit_category_modal_form input[name="priority"]').val(response.data.priority);
                var webThumbnailUrl = response.data.web_thumbnail;
                var appThumbnailUrl = response.data.app_thumbnail;
                $('#web_thumbnail').closest('.image-input').find('.image-input-wrapper').css('background-image', 'url(' + webThumbnailUrl + ')');
                $('#app_thumbnail').closest('.image-input').find('.image-input-wrapper').css('background-image', 'url(' + appThumbnailUrl + ')');

                $('#edit_category_modal_form input[name="is_active"]').prop('checked', response.data.is_active);
                blockUI.release();
                // Show the modal form
                $('#edit_category_modal').modal('show');
            }else{
                blockUI.release();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No Category data found!',
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


function deleteCategory(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this Category!',
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/menus/category/delete/' + id
        }
    });
}


function deactivateCategory(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers wont be able to see this Category',
        icon: 'warning',
        confirmButtonText: 'Yes, deactivate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/menus/category/deactivate/' + id
        }else {
            // If user cancels, check the checkbox again
            $('#cat_' + id).prop('checked', true);
        }
    });
}

function activateCategory(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers will be able to see this Category',
        icon: 'warning',
        confirmButtonText: 'Yes, Activate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/menus/category/activate/' + id
        }else{
            // If user cancels, check the checkbox again
            $('#Category_' + id).prop('checked', true);
        }
    });
}


$(document).ready(function() {

    $('[id^=cat_]').change(function() {
        var id = $(this).attr('id').split('_')[1];
        if ($(this).is(':checked')) {
            activateCategory(id);

        } else {
            deactivateCategory(id);
        }
    });
});
