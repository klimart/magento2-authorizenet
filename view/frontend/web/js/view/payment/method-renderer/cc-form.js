define([
    'Magento_Payment/js/view/payment/cc-form'
], function (Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'CodiLuck_Authorizenet/payment/cc-form',
            code: 'codiluck_authorizenet'
        },

        getCode: function() {
            return this.code;
        },

        isActive: function() {
            return this.getCode() === this.isChecked();
        }
    });
});