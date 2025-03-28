"use strict";
var KTPricingGeneral = function () {
    var n, t, e, a = function (t) {
        [].slice.call(n.querySelectorAll("[data-kt-plan-price-month]")).map((function (n) {
            var e = n.getAttribute("data-kt-plan-price-month"), a = n.getAttribute("data-kt-plan-price-annual");
            "month" === t ? n.innerHTML = e : "annual" === t && (n.innerHTML = a)
        }))
    };
    return {
        init: function () {
            n = document.querySelector("#kt_pricing"), t = n.querySelector('[data-kt-plan="month"]'), e = n.querySelector('[data-kt-plan="annual"]'), t.addEventListener("click", (function (n) {
                n.preventDefault(), a("month")
            })), e.addEventListener("click", (function (n) {
                n.preventDefault(), a("annual")
            }))
        }
    }
}();
KTUtil.onDOMContentLoaded((function () {
    KTPricingGeneral.init()
}));
