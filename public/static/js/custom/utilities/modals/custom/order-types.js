// Define form element
const addtypeForm = document.getElementById('add_new_type_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addtypeValidator = FormValidation.formValidation(
    addtypeForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'type name is required'
                    },
                }
            },
            'type': {
                validators: {
                    notEmpty: {
                        message: 'type is required'
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
const typeSubmitButton = document.getElementById('add_new_type_modal_submit');
typeSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addtypeValidator) {
        addtypeValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                typeSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                typeSubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                addtypeForm.submit(); // Submit form
            }
        });
    }
});



$(document).ready(function () {
    $('#allowScheduling').change(function () {
        if ($(this).is(':checked')) {
            $('#schedule_before_div').removeClass('d-none');
        } else {
            $('#schedule_before_div').addClass('d-none');
        }
    });


    $('#allow_scheduling').change(function () {
        if ($(this).is(':checked')) {
            $('#schedule_before_div_edit').removeClass('d-none');
        } else {
            $('#schedule_before_div_edit').addClass('d-none');
        }
    });

    $('#type').change(function () {
        var selectedType = $(this).val();
        $('#name').val(selectedType);
    });
});



// Edit order type Code


// Define form element
const editOrderTypeForm = document.getElementById('edit_type_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var editOrderTypeFormValidator = FormValidation.formValidation(
    editOrderTypeForm,
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
const editOrderTypeSubmitButton = document.getElementById('edit_type_modal_submit');
editOrderTypeSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (editOrderTypeFormValidator) {
        editOrderTypeFormValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                editOrderTypeSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                editOrderTypeSubmitButton.disabled = true;
                editOrderTypeForm.submit();

            }
        });
    }
});

var target = document.querySelector("#kt_body");
var blockUI = new KTBlockUI(target, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
});

function editOrderType(id) {
    blockUI.block();
    // Send AJAX request to server
    $.ajax({
        url: '/order-type/edit/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.data){
                $('#edit_type_modal_form input[name="name"]').val(response.data.name);
                $('#edit_type_modal_form input[name="schedule_before"]').val(response.data.schedule_before);
                $('#edit_type_modal_form input[name="id"]').val(response.data.id);


                $('#type_edit').val(response.data.type).trigger('change');
                $('#edit_type_modal_form input[name="allow_scheduling"]').prop('checked', response.data.allow_scheduling);
                $('#edit_type_modal_form input[name="is_active"]').prop('checked', response.data.is_active);
                $('input[name="allowed_channels[]"]').each(function() {
                    var value = $(this).val();
                    if (response.data.allowed_channels.includes(value)) {
                        $(this).prop('checked', true);
                    }
                });
                if (response.data.allow_scheduling) {
                    $('#schedule_before_div_edit').removeClass('d-none');
                }
               blockUI.release();
                // Show the modal form
                $('#edit_type_modal').modal('show');
            }else{
                blockUI.release();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No OrderType data found!',
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


function deleteOrderType(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this OrderType!',
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/order-type/delete/' + id
        }
    });
}


function deactivateOrderType(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers wont be able to see this OrderType',
        icon: 'warning',
        confirmButtonText: 'Yes, deactivate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/order-type/deactivate/' + id
        }else {
            // If user cancels, check the checkbox again
            $('#ord_' + id).prop('checked', true);
        }
    });
}

function activateOrderType(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers will be able to see this OrderType',
        icon: 'warning',
        confirmButtonText: 'Yes, Activate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/order-type/activate/' + id
        }else{
            // If user cancels, check the checkbox again
            $('#ord' + id).prop('checked', true);
        }
    });
}


$(document).ready(function() {

    $('[id^=ord_]').change(function() {
        var id = $(this).attr('id').split('_')[1];
        if ($(this).is(':checked')) {
            activateOrderType(id);

        } else {
            deactivateOrderType(id);
        }
    });
});
