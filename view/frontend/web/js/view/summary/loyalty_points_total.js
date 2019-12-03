define([
    'Magento_Checkout/js/view/summary/abstract-total',
    'Magento_Checkout/js/model/quote',
    'Magento_Customer/js/model/customer'
], function (Component, quote, customer) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'PHP10E2_LoyaltyPoints/cart/totals/loyalty_points_total_template'
        },
        isLoggedIn: function() {
            return customer.isLoggedIn();
        },
        totals: quote.getTotals(),
        getPointsTotal: function() {
            var discountSegments;

            if (!this.totals()) {
                return null;
            }

            discountSegments = this.totals()['total_segments'].filter(function (segment) {
                return segment.code.indexOf('loyalty_points_total') !== -1;
            });
            return discountSegments.length ? discountSegments[0] : null;
        },
        getTitle: function () {
            let pointsTotal = this.getPointsTotal();
            return pointsTotal ? pointsTotal.title : null;
        },
        getPureValue: function () {
            let pointsTotal = this.getPointsTotal();
            return pointsTotal ? pointsTotal.value : null;
        },
        getValue: function () {
            return this.getFormattedPrice(this.getPureValue());
        },
        title: 'Loyalty'
    })
});