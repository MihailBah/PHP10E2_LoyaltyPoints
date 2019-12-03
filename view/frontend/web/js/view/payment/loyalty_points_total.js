define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Checkout/js/model/quote',
    'PHP10E2_LoyaltyPoints/js/view/summary/loyalty_points_total',
    'Magento_Customer/js/model/customer'
], function ($, ko, Component, quote, LpTotal, customer) {
    'use strict';
    console.log('test');

    return Component.extend({
        defaults: {
            template: 'PHP10E2_LoyaltyPoints/payment/loyalty_points_total_template'
        },
        getValue: function () {
            return 444;
        },
        getTitle: function () {
            return "tit";
        }
    })
});