define([
    'Amasty_ImportCore/js/form',
    'underscore',
    'jquery',
    'Amasty_ImportPro/js/action/notification'
], function (Form, _, $, notification) {
    'use strict';

    return Form.extend({
        defaults: {
            listens: {
                'responseData': 'processResponse'
            },
            modules: {
                run: 'index = run'
            }
        },

        processResponse: function () {
            var responseData = this.responseData();

            this._super();

            this.source.remove('data.save_and_run');
            this.source.remove('data.save_and_validate');

            if (!_.isUndefined(responseData.messages)) {
                $.each(responseData.messages, function (key, message) {
                    notification.add(message, responseData.error);
                });
            }

            if (!_.isUndefined(responseData.redirect)) {
                window.location.href = responseData.redirect;
            }

            if (!_.isUndefined(responseData.validate) && responseData.validate) {
                this.run().execute(this.source.data[this.run().idField], 'validate');
            }
            if (!_.isUndefined(responseData.import) && responseData.import) {
                this.run().execute(this.source.data[this.run().idField], 'validate_and_import');
            }
        },

        saveAndRun: function () {
            this._setSaveUrl();

            this.validate();
            if (!this.source.get('params.invalid')) {
                this.source.set('data.save_and_run', 1);
                this.submit();
            } else {
                this.focusInvalid();
            }
        },

        saveAndValidate: function () {
            this._setSaveUrl();

            this.validate();
            if (!this.source.get('params.invalid')) {
                this.source.set('data.save_and_validate', 1);
                this.submit();
            } else {
                this.focusInvalid();
            }
        }
    });
});
