define([
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list'
], function(Component, rendererList) {
        'use strict';

        rendererList.push({
            type: 'codiluck_authorizenet',
            component: 'CodiLuck_Authorizenet/js/view/payment/method-renderer/cc-form'
        });

        return Component.extend({});
    }
);