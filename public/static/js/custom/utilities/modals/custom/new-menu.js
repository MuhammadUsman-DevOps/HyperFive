"use strict";
var KTModalNewAddress = function () {
    var t, e, n, o, i, r;
    return {
        init: function () {
            (r = document.querySelector("#add_new_menu_modal")) && (i = new bootstrap.Modal(r), o = document.querySelector("#add_new_menu_modal_form"), t = document.getElementById("add_new_menu_modal_submit"), e = document.getElementById("add_new_menu_modal_cancel"), $(o.querySelector('[name="country"]')).select2().on("change", (function () {
                n.revalidateField("country")
            })), n = FormValidation.formValidation(o, {
                fields: {
                    "menu_name": {validators: {notEmpty: {message: "Name is required"}}},
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            }), t.addEventListener("click", (function (e) {
                e.preventDefault(), n && n.validate().then((function (e) {
                    console.log("validated!"), "Valid" == e ? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0, setTimeout((function () {
                        t.removeAttribute("data-kt-indicator"), t.disabled = !1, $("#add_new_menu_modal_form").submit();
                    }), 2e3)) : console.log("");
                }))
            })),(() => {
                const t = e.querySelectorAll('[data-kt-modal-bidding="option"]'),
                    n = e.querySelector('[name="difference"]');
                t.forEach((t => {
                    t.addEventListener("click", (t => {
                        t.preventDefault(), n.value = t.target.innerText
                    }))
                }))
            })(), e.addEventListener("click", (function (t) {
                t.preventDefault(), Swal.fire({
                    text: "Are you sure you would like to cancel?",
                    icon: "warning",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "Yes, cancel it!",
                    cancelButtonText: "No, return",
                    customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
                }).then((function (t) {
                    t.value ? (o.reset(), i.hide()) : "cancel" === t.dismiss && Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {confirmButton: "btn btn-primary"}
                    })
                }))
            })))
        }
    }
}();
KTUtil.onDOMContentLoaded((function () {
    KTModalNewAddress.init()
}));
