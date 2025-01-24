"use strict";
var KTModalTrackOrder = function () {
    var e, t, o;
    return {
        init: function () {
            e = document.querySelector("#kt_modal_track_order_stepper"), o = document.querySelector("#kt_modal_track_order_form"), t = new KTStepper(e)
        }, getStepper: function () {

            return e
        }, getStepperObj: function () {
            return t
        }, getForm: function () {
            return o
        }
    }
}();
KTUtil.onDOMContentLoaded((function () {
    document.querySelector("#kt_modal_track_order") && (KTModalTrackOrder.init(), KTModalTrackOrderNumber.init(), KTModalTrackOrderDetails.init())
})), "undefined" != typeof module && void 0 !== module.exports && (window.KTModalTrackOrder = module.exports = KTModalTrackOrder);
