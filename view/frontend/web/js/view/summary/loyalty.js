define([
    'Magento_Checkout/js/view/summary/abstract-total',
    'Magento_Checkout/js/model/totals'
], function (Component, totals) {
    return Component.extend({
        defaults: {
            template: 'PHP10E2_LoyaltyPoints/summary/loyalty'
        },
    });
});