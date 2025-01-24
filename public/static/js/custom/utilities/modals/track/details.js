"use strict";
var KTModalTrackOrderDetails = function () {
    var e, t, a, i, o;
    return {
        init: function () {
            i = KTModalTrackOrder.getForm(), o = KTModalTrackOrder.getStepperObj(), e = KTModalTrackOrder.getStepper().querySelector('[data-kt-element="details-next"]'), t = KTModalTrackOrder.getStepper().querySelector('[data-kt-element="details-previous"]'), $(i.querySelector('[name="details_activation_date"]')).flatpickr({
                enableTime: !0,
                dateFormat: "d, M Y, H:i"
            }), $(i.querySelector('[name="details_customer"]')).on("change", (function () {
                a.revalidateField("details_customer")
            })), a = FormValidation.formValidation(i, {
                fields: {
                    details_customer: {validators: {notEmpty: {message: "Customer is required"}}},
                    details_title: {validators: {notEmpty: {message: "Deal title is required"}}},
                    details_activation_date: {validators: {notEmpty: {message: "Activation date is required"}}},
                    "details_notifications[]": {validators: {notEmpty: {message: "Notifications are required"}}}
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            })
        }
    }
}();
"undefined" != typeof module && void 0 !== module.exports && (window.KTModalTrackOrderDetails = module.exports = KTModalTrackOrderDetails);
