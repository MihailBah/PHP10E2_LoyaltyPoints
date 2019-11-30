define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Checkout/js/model/quote',
    'PHP10E2_LoyaltyPoints/js/action/set-coupon-code',
    'PHP10E2_LoyaltyPoints/js/action/cancel-coupon'
], function ($, ko, Component, quote, setCouponCodeAction, cancelCouponAction) {
    'use strict';

    var totals = quote.getTotals(),
        couponCode = ko.observable("test"),
        isApplied;

    if (totals()) {
        couponCode(totals()['coupon_code']);
    }
    isApplied = ko.observable('1');

    return Component.extend({
        defaults: {
            template: 'PHP10E2_LoyaltyPoints/loyalty_points_apply_template'
        },
        couponCode: couponCode,

        /**
         * Applied flag
         */
        isApplied: isApplied,

        /**
         * Coupon code application procedure
         */
        apply: function () {
            if (this.validate()) {
                setCouponCodeAction(couponCode(), isApplied);
            }
        },

        /**
         * Cancel using coupon
         */
        cancel: function () {
            if (this.validate()) {
                couponCode('');
                cancelCouponAction(isApplied);
            }
        },

        /**
         * Coupon form validation
         *
         * @returns {Boolean}
         */
        validate: function () {
            var form = '#discount-form';

            return $(form).validation() && $(form).validation('isValid');
        }
    });
});