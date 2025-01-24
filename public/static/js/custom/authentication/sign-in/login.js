"use strict";

var KTSigninGeneral = function() {
    var form, submitButton, validator;

    return {
        init: function() {
            form = document.querySelector("#sign_in_form");
            submitButton = document.querySelector("#sign_in_submit");
            validator = FormValidation.formValidation(form, {
                fields: {
                    email: {
                        validators: {
                            notEmpty: { message: "Email address is required" },
                            emailAddress: { message: "The value is not a valid email address" }
                        }
                    },
                    phone_number: {
                        validators: {
                            notEmpty: { message: "Phone number is required" },
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: { message: "The password is required" }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row" })
                }
            });

            // Listen to the change event of the radio buttons
            $('input[name="method"]').on('change', function () {
                if ($(this).val() === 'email') {
                    validator.enableValidator('email').disableValidator('phone_number');
                } else {
                    validator.enableValidator('phone_number').disableValidator('email');
                }
            });

            // Trigger the change event to set up the initial state
            $('input[name="method"]:checked').trigger('change');

            submitButton.addEventListener("click", function(event) {
                event.preventDefault();
                validator.validate().then(function(status) {
                    if (status === "Valid") {
                        submitButton.setAttribute("data-kt-indicator", "on");
                        submitButton.disabled = true;

                        // AJAX request
                        $.ajax({
                            url: '/cx/login',
                            method: 'POST',
                            data: $(form).serialize(),
                            success: function(response) {
                                if (response.success) {
                                    window.location.href = response.redirect_url;
                                    submitButton.removeAttribute("data-kt-indicator");
                                    submitButton.disabled = false;
                                } else {
                                    Swal.fire({
                                        text: response.message || "Sorry, looks like there are some errors detected, please try again.",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: { confirmButton: "btn btn-primary" }
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                submitButton.removeAttribute("data-kt-indicator");
                                submitButton.disabled = false;

                                // Handle error response
                                Swal.fire({
                                    text: xhr.responseJSON.message || "An error occurred, please try again.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: { confirmButton: "btn btn-primary" }
                                });
                            }
                        });

                    } else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: { confirmButton: "btn btn-primary" }
                        });
                    }
                });
            });
        }
    };
}();

// When DOM is fully loaded
KTUtil.onDOMContentLoaded(function() {
    KTSigninGeneral.init();
});



// "use strict";
//
// var KTSigninGeneral = function() {
//     var form, submitButton, validator;
//
//     return {
//         init: function() {
//             form = document.querySelector("#sign_in_form");
//             submitButton = document.querySelector("#sign_in_submit");
//             validator = FormValidation.formValidation(form, {
//                 fields: {
//                     email: {
//                         validators: {
//                             notEmpty: { message: "Email address is required" },
//                             emailAddress: { message: "The value is not a valid email address" }
//                         }
//                     },
//                     phone_number: {
//                         validators: {
//                             notEmpty: { message: "Phone number is required" },
//                         }
//                     },
//                     password: {
//                         validators: {
//                             notEmpty: { message: "The password is required" }
//                         }
//                     }
//                 },
//                 plugins: {
//                     trigger: new FormValidation.plugins.Trigger(),
//                     bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row" })
//                 }
//             });
//
//             // Listen to the change event of the radio buttons
//             $('input[name="method"]').on('change', function () {
//                 if ($(this).val() === 'email') {
//                     validator.enableValidator('email').disableValidator('phone_number');
//                 } else {
//                     validator.enableValidator('phone_number').disableValidator('email');
//                 }
//             });
//
//             // Trigger the change event to set up the initial state
//             $('input[name="method"]:checked').trigger('change');
//
//             submitButton.addEventListener("click", function(event) {
//                 event.preventDefault();
//                 validator.validate().then(function(status) {
//                     if (status === "Valid") {
//                         submitButton.setAttribute("data-kt-indicator", "on");
//                         submitButton.disabled = true;
//
//                         // AJAX request
//                         $.ajax({
//                             url: '/cx/login',
//                             method: 'POST',
//                             data: $(form).serialize(),
//                             success: function(response) {
//                                 if (response.success) {
//                                     window.location.href = response.redirect_url;
//                                     submitButton.removeAttribute("data-kt-indicator");
//                                     submitButton.disabled = false;
//                                 } else {
//                                     Swal.fire({
//                                         text: response.message || "Sorry, looks like there are some errors detected, please try again.",
//                                         icon: "error",
//                                         buttonsStyling: false,
//                                         confirmButtonText: "Ok, got it!",
//                                         customClass: { confirmButton: "btn btn-primary" }
//                                     });
//                                 }
//                             },
//                             error: function(xhr, status, error) {
//                                 submitButton.removeAttribute("data-kt-indicator");
//                                 submitButton.disabled = false;
//
//                                 // Handle error response
//                                 Swal.fire({
//                                     text: xhr.responseJSON.message || "An error occurred, please try again.",
//                                     icon: "error",
//                                     buttonsStyling: false,
//                                     confirmButtonText: "Ok, got it!",
//                                     customClass: { confirmButton: "btn btn-primary" }
//                                 });
//                             }
//                         });
//
//                     } else {
//                         Swal.fire({
//                             text: "Sorry, looks like there are some errors detected, please try again.",
//                             icon: "error",
//                             buttonsStyling: false,
//                             confirmButtonText: "Ok, got it!",
//                             customClass: { confirmButton: "btn btn-primary" }
//                         });
//                     }
//                 });
//             });
//         }
//     };
// }();
//
// // When DOM is fully loaded
// KTUtil.onDOMContentLoaded(function() {
//     KTSigninGeneral.init();
// });
