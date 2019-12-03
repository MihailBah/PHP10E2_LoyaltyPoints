define([
    'PHP10E2_LoyaltyPoints/js/view/summary/loyalty_points_total'
], function (Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'PHP10E2_LoyaltyPoints/cart/totals/loyalty_points_total_template'
        },

        /**
         * @override
         *
         * @returns {Boolean}
         */
        isLoggedIn: function () {
            return this.getPureValue() != 0;
        }
    });
});