define([
    'Magento_Checkout/js/view/summary/abstract-total',
    'Magento_Checkout/js/model/quote'
], function (Component, quote) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'PHP10E2_LoyaltyPoints/loyalty_points_total_template'
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