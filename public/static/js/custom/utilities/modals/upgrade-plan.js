"use strict";
var KTModalUpgradePlan = function () {
    var t, n, a, e = function (n) {
        [].slice.call(t.querySelectorAll("[data-kt-plan-price-month]")).map((function (t) {
            var a = t.getAttribute("data-kt-plan-price-month"), e = t.getAttribute("data-kt-plan-price-annual");
            "month" === n ? t.innerHTML = a : "annual" === n && (t.innerHTML = e)
        }))
    };
    return {
        init: function () {
            (t = document.querySelector("#kt_modal_upgrade_plan")) && (n = t.querySelector('[data-kt-plan="month"]'), a = t.querySelector('[data-kt-plan="annual"]'), n.addEventListener("click", (function (t) {
                e("month")
            })), a.addEventListener("click", (function (t) {
                e("annual")
            })), KTUtil.on(t, '[data-bs-toggle="tab"]', "click", (function (t) {
                this.querySelector('[type="radio"]').checked = !0
            })))
        }
    }
}();
KTUtil.onDOMContentLoaded((function () {
    KTModalUpgradePlan.init()
}));
