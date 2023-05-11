define([
    'jquery'
], function ($) {
    'use strict';

    return function (target) {
        $.validator.addMethod(
            'validate-not-empty-field-redirect',
            function (value) {
                return value.length !== 0;

            },
            $.mage.__('Please make sure you have chosen options for this select.')
        );
        return target;
    };
});
