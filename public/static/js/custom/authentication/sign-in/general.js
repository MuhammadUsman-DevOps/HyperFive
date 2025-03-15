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
                            notEmpty: { message: "Username is required" },

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

            submitButton.addEventListener("click", function(event) {
                event.preventDefault();
                validator.validate().then(function(status) {
                    if (status === "Valid") {
                        submitButton.setAttribute("data-kt-indicator", "on");
                        submitButton.disabled = true;
                            $("#sign_in_form").submit();

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
