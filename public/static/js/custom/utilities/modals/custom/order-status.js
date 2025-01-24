// Define form element
const addStatusForm = document.getElementById('add_new_status_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addStatusValidator = FormValidation.formValidation(
    addStatusForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Status name is required'
                    },
                }
            },
            'description': {
                validators: {
                    notEmpty: {
                        message: 'Description is required'
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
const StatusSubmitButton = document.getElementById('add_new_status_modal_submit');
StatusSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addStatusValidator) {
        addStatusValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                StatusSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                StatusSubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                addStatusForm.submit(); // Submit form
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

    $('#Status').change(function () {
        var selectedStatus = $(this).val();
        $('#name').val(selectedStatus);
    });
});



// Edit order Status Code


// Define form element
const editOrderStatusForm = document.getElementById('edit_status_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var editOrderStatusFormValidator = FormValidation.formValidation(
    editOrderStatusForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Status name is required'
                    },
                }
            },
            'description': {
                validators: {
                    notEmpty: {
                        message: 'Description is required'
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
const editOrderStatusSubmitButton = document.getElementById('edit_status_modal_submit');
editOrderStatusSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (editOrderStatusFormValidator) {
        editOrderStatusFormValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                editOrderStatusSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                editOrderStatusSubmitButton.disabled = true;
                editOrderStatusForm.submit();

            }
        });
    }
});

var target = document.querySelector("#kt_body");
var blockUI = new KTBlockUI(target, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
});

function editOrderStatus(id) {
    // blockUI.block();
    // Send AJAX request to server
    console.log("called")
    $.ajax({
        url: '/status/edit/' + id,
        Status: 'GET',
        dataStatus: 'json',
        success: function(response) {
            if(response.data){
                $('#edit_status_modal_form input[name="name"]').val(response.data.name);
                $('#edit_status_modal_form input[name="description"]').val(response.data.description);
                $('#edit_status_modal_form input[name="color"]').val(response.data.color);
                $('#edit_status_modal_form input[name="id"]').val(response.data.id);

                //
                // $('#Status_edit').val(response.data.Status).trigger('change');
                //
                $('#edit_status_modal_form input[name="notify_customer"]').prop('checked', response.data.notify_customer);

               // blockUI.release();
                // Show the modal form
                $('#edit_status_modal').modal('show');
            }else{
                // blockUI.release();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No status data found!',
                    buttonsStyling: !1,
                    confirmButtonText: "Oh! ok :(",
                    customClass: {confirmButton: "btn btn-primary"}
                });
            }

        },
        error: function(xhr, status, error) {
            // blockUI.release();
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong',
            });
        }
    });
}


function deleteOrderStatus(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this status!',
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/status/delete/' + id
        }
    });
}


function deactivateOrderStatus(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers wont be able to see this OrderStatus',
        icon: 'warning',
        confirmButtonText: 'Yes, deactivate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/status/deactivate/' + id
        }else {
            // If user cancels, check the checkbox again
            $('#ord_' + id).prop('checked', true);
        }
    });
}

function activateOrderStatus(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers will be able to see this OrderStatus',
        icon: 'warning',
        confirmButtonText: 'Yes, Activate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/status/activate/' + id
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
            activateOrderStatus(id);

        } else {
            deactivateOrderStatus(id);
        }
    });
});
