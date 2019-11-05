define(['PHP10E2_LoyaltyPoints/js/view/summary/loyalty'], function (Component) {
    'use strict';

    return Component.extend({
        loyaltyPointsRemoveUrl: '',

        /**
         * @override
         */
        isAvailable: function () {
            return this.getPureValue() !== 0;
        }
    });
});