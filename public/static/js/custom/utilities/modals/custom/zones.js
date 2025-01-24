// Define form element
const addZoneForm = document.getElementById('add_new_zone_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addZoneValidator = FormValidation.formValidation(
    addZoneForm,
    {
        fields: {
            'zone_name': {
                validators: {
                    notEmpty: {
                        message: 'Zone name is required'
                    }
                }
            },
            'delivery_fee': {
                validators: {
                    notEmpty: {
                        message: 'Fee is required'
                    }
                }
            },
            'minimum_order_amount': {
                validators: {
                    notEmpty: {
                        message: 'min order amount is required'
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
const ZoneSubmitButton = document.getElementById('add_new_zone_modal_submit');
ZoneSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addZoneValidator) {
        addZoneValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                ZoneSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                ZoneSubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                addZoneForm.submit();
            }
        });
    }
});


// Edit Zone Code


// Define form element
const editZoneForm = document.getElementById('edit_zone_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var editZoneFormValidator = FormValidation.formValidation(
    editZoneForm,
    {
        fields: {
            'zone_name': {
                validators: {
                    notEmpty: {
                        message: 'Zone name is required'
                    }
                }
            },
            'delivery_fee': {
                validators: {
                    notEmpty: {
                        message: 'Fee is required'
                    }
                }
            },
            'minimum_order_amount': {
                validators: {
                    notEmpty: {
                        message: 'min order amount is required'
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
const editZoneSubmitButton = document.getElementById('edit_zone_modal_submit');
editZoneSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (editZoneFormValidator) {
        editZoneFormValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                editZoneSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                editZoneSubmitButton.disabled = true;
                editZoneForm.submit();

            }
        });
    }
});

var target = document.querySelector("#kt_body");
var blockUI = new KTBlockUI(target, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
});

function editZone(id) {
    blockUI.block();
    // Send AJAX request to server
    $.ajax({
        url: '/zone/edit/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.data){
                console.log(response.data)
                $('#edit_zone_modal_form input[name="zone_name"]').val(response.data.zone_name);
                $('#edit_zone_modal_form input[name="id"]').val(response.data.id);
                $('#edit_zone_modal_form input[name="delivery_fee"]').val(response.data.delivery_fee);
                $('#edit_zone_modal_form input[name="minimum_order_amount"]').val(response.data.minimum_order_amount);

                $('#edit_zone_modal_form input[name="is_active"]').prop('checked', response.data.is_active);
                // Get the delivery fee type value from the response
                var deliveryFeeType = response.data.delivery_fee_type;

                // Check the radio button with the matching value and add active class
                $('#edit_zone_modal_form input[name="delivery_fee_type"]').each(function() {
                    if ($(this).val() === deliveryFeeType) {
                        $(this).prop('checked', true);
                        $(this).closest('label').addClass('active');
                    } else {
                        $(this).closest('label').removeClass('active');
                    }
                });
                blockUI.release();
                // Show the modal form
                $('#edit_zone_modal').modal('show');
            }else{
                blockUI.release();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No Zone data found!',
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


function deleteZone(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this Zone!',
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/zone/delete/' + id
        }
    });
}


function deactivateZone(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers wont be able to see this Zone',
        icon: 'warning',
        confirmButtonText: 'Yes, deactivate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/zone/deactivate/' + id
        }else {
            // If user cancels, check the checkbox again
            $('#zid_' + id).prop('checked', true);
        }
    });
}

function activateZone(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers will be able to see this Zone',
        icon: 'warning',
        confirmButtonText: 'Yes, Activate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/zone/activate/' + id
        }else{
            // If user cancels, check the checkbox again
            $('#zid_' + id).prop('checked', true);
        }
    });
}


$(document).ready(function() {

    $('[id^=zid_]').change(function() {
        var id = $(this).attr('id').split('_')[1];
        if ($(this).is(':checked')) {
            activateZone(id);

        } else {
            deactivateZone(id);
        }
    });
});

function deleteDeliveryZoneArea(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this zone area!',
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/zone/area/'+id+'/delete'
        }
    });
}
