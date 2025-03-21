"use strict";
var KTSignupGeneral = function () {
    var e, t, a, s, r = function () {
        return 100 === s.getScore()
    };
    return {
        init: function () {
            e = document.querySelector("#ai_writer_signup_form"), t = document.querySelector("#ai_writer_signup_submit"), s = KTPasswordMeter.getInstance(e.querySelector('[data-kt-password-meter="true"]')), a = FormValidation.formValidation(e, {
                fields: {
                    name: {validators: {notEmpty: {message: "Please enter your name"}}},
                    email_address: {
                        validators: {
                            notEmpty: {message: "Email address is required"},
                            emailAddress: {message: "The value is not a valid email address"}
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {message: "The password is required"},
                            callback: {
                                message: "Please enter valid password", callback: function (e) {
                                    if (e.value.length > 0) return r()
                                }
                            }
                        }
                    },
                    "confirm-password": {
                        validators: {
                            notEmpty: {message: "The password confirmation is required"},
                            identical: {
                                compare: function () {
                                    return e.querySelector('[name="password"]').value
                                }, message: "The password and its confirm are not the same"
                            }
                        }
                    },
                    toc: {validators: {notEmpty: {message: "You must accept the terms and conditions"}}}
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger({event: {password: !1}}),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            }), t.addEventListener("click", (function (r) {
                r.preventDefault(), a.revalidateField("password"), a.validate().then((function (a) {
                    "Valid" == a ? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0, setTimeout((function () {
                        t.removeAttribute("data-kt-indicator"), t.disabled = !1, $("#ai_writer_signup_form").submit();
                    }), 1000)) : Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {confirmButton: "btn btn-dark"}
                    })
                }))
            })), e.querySelector('input[name="password"]').addEventListener("input", (function () {
                this.value.length > 0 && a.updateFieldStatus("password", "NotValidated")
            }))
        }
    }
}();
KTUtil.onDOMContentLoaded((function () {
    KTSignupGeneral.init()
}));
