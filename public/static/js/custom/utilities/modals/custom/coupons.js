// Define form element
const addCouponForm = document.getElementById('add_new_coupon_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addCouponFormValidator = FormValidation.formValidation(
    addCouponForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'name is required'
                    }
                }
            },
            'code': {
                validators: {
                    notEmpty: {
                        message: 'code is required'
                    }
                }
            },
            'description': {
                validators: {
                    notEmpty: {
                        message: 'description is required'
                    }
                }
            },
            'discount_type': {
                validators: {
                    notEmpty: {
                        message: 'discount type is required'
                    }
                }
            },
            'discount_value': {
                validators: {
                    notEmpty: {
                        message: 'discount value is required'
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
            'expiry_date': {
                validators: {
                    notEmpty: {
                        message: 'expiry date is required'
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
const CouponSubmitButton = document.getElementById('add_new_coupon_modal_submit');
CouponSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addCouponFormValidator) {
        addCouponFormValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                CouponSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                CouponSubmitButton.disabled = true;
                addCouponForm.submit();


            }
        });
    }
});


// Edit Coupon Code


// Define form element
const editCouponForm = document.getElementById('edit_coupon_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var editCouponFormValidator = FormValidation.formValidation(
    editCouponForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'name is required'
                    }
                }
            },
            'code': {
                validators: {
                    notEmpty: {
                        message: 'code is required'
                    }
                }
            },
            'description': {
                validators: {
                    notEmpty: {
                        message: 'description is required'
                    }
                }
            },
            'discount_type': {
                validators: {
                    notEmpty: {
                        message: 'discount type is required'
                    }
                }
            },
            'discount_value': {
                validators: {
                    notEmpty: {
                        message: 'discount value is required'
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
            'expiry_date': {
                validators: {
                    notEmpty: {
                        message: 'expiry date is required'
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
const editCouponSubmitButton = document.getElementById('edit_coupon_modal_submit');
editCouponSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (editCouponFormValidator) {
        editCouponFormValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                editCouponSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                editCouponSubmitButton.disabled = true;
                editCouponForm.submit();

            }
        });
    }
});

var target = document.querySelector("#kt_body");
var blockUI = new KTBlockUI(target, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
});

function editCoupon(id) {
    blockUI.block();
    // Send AJAX request to server
    $.ajax({
        url: 'coupons/edit/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.data) {
                $('#edit_coupon_modal_form input[name="name"]').val(response.data.name);
                $('#edit_coupon_modal_form input[name="id"]').val(response.data.id);
                $('#edit_coupon_modal_form input[name="description"]').val(response.data.description);
                $('#edit_coupon_modal_form input[name="code"]').val(response.data.code);
                $('#edit_coupon_modal_form select[name="discount_type"]').val(response.data.discount_type).change();
                $('#edit_coupon_modal_form input[name="discount_value"]').val(response.data.discount_value);
                $('#edit_coupon_modal_form input[name="minimum_order_amount"]').val(response.data.minimum_order_amount);
                $('#edit_coupon_modal_form input[name="expiry_date"]').val(new Date(response.data.expiry_date).toISOString().substring(0, 10));
                blockUI.release();
                // Show the modal form
                $('#edit_coupon_modal').modal('show');
            } else {
                blockUI.release();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No coupon data found!',
                    buttonsStyling: !1,
                    confirmButtonText: "Oh! ok :(",
                    customClass: {confirmButton: "btn btn-primary"}
                });
            }

        },
        error: function (xhr, status, error) {
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


function deleteCoupon(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this coupon!',
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/coupons/delete/' + id
        }
    });
}
