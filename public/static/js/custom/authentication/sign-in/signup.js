"use strict";

var KTSignupGeneral = function () {
    var signupForm, signupSubmitButton, signupValidator;

    return {
        init: function () {
            signupForm = document.querySelector("#signup_form");
            signupSubmitButton = document.querySelector("#signup_submit");
            signupValidator = FormValidation.formValidation(signupForm, {
                fields: {
                    email: {
                        validators: {
                            notEmpty: {message: "Email address is required"},
                            emailAddress: {message: "The value is not a valid email address"}
                        }
                    },
                    phone_number: {
                        validators: {
                            notEmpty: {message: "Phone number is required"},
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {message: "The password is required"}
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({rowSelector: ".fv-row"})
                }
            });

            // Listen to the change event of the radio buttons
            $('input[name="method"]').on('change', function () {
                if ($(this).val() === 'email') {
                    signupValidator.enableValidator('email').disableValidator('phone_number');
                } else {
                    signupValidator.enableValidator('phone_number').disableValidator('email');
                }
            });
// Trigger the change event to set up the initial state
            $('input[name="method"]:checked').trigger('change');

            signupSubmitButton.addEventListener("click", function (event) {
                event.preventDefault();
                signupValidator.validate().then(function (status) {
                    if (status === "Valid") {
                        signupSubmitButton.setAttribute("data-kt-indicator", "on");
                        signupSubmitButton.disabled = true;

                        // AJAX request
                        $.ajax({
                            url: '/cx/signup',
                            method: 'POST',
                            data: $(signupForm).serialize(),
                            success: function (response) {
                                if (response.success) {
                                    var method = $('input[name="method"]:checked').val();
                                    if (method === "phone" && response.verify_phone) {
                                        var phoneNumber = response.phone_number;
                                        phoneNumber = phoneNumber.replace(/^\+92/, '');
                                        var userId = response.user_id;
                                        var customerId = response.customer_id;
                                        sendPhoneOTP(userId, phoneNumber, customerId);
                                    } else {
                                        window.location.href = response.redirect_url;
                                    }

                                    // signupSubmitButton.removeAttribute("data-kt-indicator");
                                    // signupSubmitButton.disabled = false;
                                    // Swal.fire({
                                    //     text: "Login successful!",
                                    //     icon: "success",
                                    //     buttonsStyling: false,
                                    //     confirmButtonText: "Ok, got it!",
                                    //     customClass: { confirmButton: "btn btn-primary" }
                                    // }).then(function() {
                                    //     // Redirect to another page or reload
                                    //     window.location.href = response.redirect_url;
                                    // });
                                } else {
                                    Swal.fire({
                                        text: response.message || "Sorry, looks like there are some errors detected, please try again.",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {confirmButton: "btn btn-primary"}
                                    });
                                }
                            },
                            error: function (xhr, status, error) {
                                signupSubmitButton.removeAttribute("data-kt-indicator");
                                signupSubmitButton.disabled = false;

                                // Handle error response
                                Swal.fire({
                                    text: xhr.responseJSON.message || "An error occurred, please try again.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {confirmButton: "btn btn-primary"}
                                });
                            }
                        });

                    } else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {confirmButton: "btn btn-primary"}
                        });
                    }
                });
            });
        }
    };


}();

function handleAfterOTP() {
    var signupSubmitButton = document.querySelector("#signup_submit");
    signupSubmitButton.removeAttribute("data-kt-indicator");
    signupSubmitButton.disabled = false;


}

function sendPhoneOTP(userId, phoneNumber, customerId) {
    $.ajax({
        url: 'api/v1/send-phone-otp',
        method: 'POST',
        data: {
            user_id: userId,
            phone_number: phoneNumber,
            customer_id: customerId
        },
        success: function (response) {
            handleAfterOTP();
            if (response.status == "success") {
                Swal.fire({
                    text: "OTP sent successfully to " + phoneNumber + "!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {confirmButton: "btn btn-primary"}
                }).then(function () {
                    // Show the OTP input modal

                    $('#signupModal').modal('hide');
                    $('#otpModal').modal('show');
                    $("#otp_user").val(userId)
                    $("#otp_customer").val(customerId)
                    $("#otp_phone").val(phoneNumber)
                });
            } else {
                Swal.fire({
                    text: response.message || "Failed to send OTP. Please try again.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {confirmButton: "btn btn-primary"}
                });
            }
        },
        error: function (xhr, status, error) {
            handleAfterOTP();
            Swal.fire({
                text: xhr.responseJSON.message || "An error occurred while sending OTP. Please try again.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {confirmButton: "btn btn-primary"}
            });

        }
    });
}


// When DOM is fully loaded
KTUtil.onDOMContentLoaded(function () {
    KTSignupGeneral.init();
});

$("#resendOTPBtn").click(function () {
    var userId = $("#otp_user").val();
    var customerId = $("#otp_customer").val();
    var phoneNumber = $("#otp_phone").val();

    var OTPSubmitButton = document.querySelector("#submitOtpBtn");
    OTPSubmitButton.removeAttribute("data-kt-indicator");
    OTPSubmitButton.disabled = false;
    sendPhoneOTP(userId, phoneNumber, customerId)
});

$('#submitOtpBtn').click(function () {
    var otp = $('#otpInput').val();
    var userId = $("#otp_user").val();
    var customerId = $("#otp_customer").val();
    var phoneNumber = $("#otp_phone").val();

    var OTPSubmitButton = document.querySelector("#submitOtpBtn");
    OTPSubmitButton.setAttribute("data-kt-indicator", "on");
    OTPSubmitButton.disabled = true;


    $.ajax({
        url: 'api/v1/verify-phone-otp',
        method: 'POST',
        data: {
            verification_code: otp,
            user_id: userId,
            customer_id: customerId,
            phone_number: phoneNumber
        },
        success: function (response) {
            OTPSubmitButton.removeAttribute("data-kt-indicator");
            OTPSubmitButton.disabled = false;
            if (response.status == "success") {
                Swal.fire({
                    text: response.message,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {confirmButton: "btn btn-primary"}
                }).then(function () {
                    // Close the modal and proceed to the next step
                    $('#otpModal').modal('hide');
                    window.location.href = "/bx/checkout"
                });
            } else {
                Swal.fire({
                    text: response.message || "Invalid OTP. Please try again.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {confirmButton: "btn btn-primary"}
                });
            }
        },
        error: function (xhr, status, error) {
            OTPSubmitButton.removeAttribute("data-kt-indicator");
            OTPSubmitButton.disabled = false;
            Swal.fire({
                text: xhr.responseJSON.message || "An error occurred while verifying OTP. Please try again.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {confirmButton: "btn btn-primary"}
            });
        }
    });
});
