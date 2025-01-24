// Define form element
const addMenuForm = document.getElementById('add_new_menu_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addMenuFormValidator = FormValidation.formValidation(
    addMenuForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'menu name is required'
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
const menuSubmitButton = document.getElementById('add_new_menu_modal_submit');
menuSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addMenuFormValidator) {
        addMenuFormValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                menuSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                menuSubmitButton.disabled = true;
                addMenuForm.submit();


            }
        });
    }
});


// Edit Menu Code


// Define form element
const editMenuForm = document.getElementById('edit_menu_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var editMenuFormValidator = FormValidation.formValidation(
    editMenuForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'menu name is required'
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
const editMenuSubmitButton = document.getElementById('edit_menu_modal_submit');
editMenuSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (editMenuFormValidator) {
        editMenuFormValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                editMenuSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                editMenuSubmitButton.disabled = true;
                editMenuForm.submit();

            }
        });
    }
});

var target = document.querySelector("#kt_body");
var blockUI = new KTBlockUI(target, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
});

function editMenu(id) {
    blockUI.block();
    // Send AJAX request to server
    $.ajax({
        url: 'menus/edit/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.data){
                $('#edit_menu_modal_form input[name="name"]').val(response.data.name);
                $('#edit_menu_modal_form input[name="id"]').val(response.data.id);
                $('#edit_menu_modal_form input[name="start_time"]').val(response.data.start_time);
                $('#edit_menu_modal_form input[name="end_time"]').val(response.data.end_time);
                $('#edit_menu_modal_form input[name="is_active"]').prop('checked', response.data.is_active);
                blockUI.release();
                // Show the modal form
                $('#edit_menu_modal').modal('show');
            }else{
                blockUI.release();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No menu data found!',
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


function deleteMenu(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this menu!',
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/menus/delete/' + id
        }
    });
}


function deactivateMenu(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers wont be able to see this menu',
        icon: 'warning',
        confirmButtonText: 'Yes, deactivate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/menus/deactivate/' + id
        }else {
            // If user cancels, check the checkbox again
            $('#menu_' + id).prop('checked', true);
        }
    });
}

function activateMenu(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers will be able to see this menu',
        icon: 'warning',
        confirmButtonText: 'Yes, Activate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/menus/activate/' + id
        }else{
            // If user cancels, check the checkbox again
            $('#menu_' + id).prop('checked', true);
        }
    });
}


$(document).ready(function() {

    $('[id^=menu_id_]').change(function() {
        var id = $(this).attr('id').split('_')[2];

        if ($(this).is(':checked')) {
            activateMenu(id);

        } else {
            deactivateMenu(id);
        }
    });
});
