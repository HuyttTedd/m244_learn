define([
    'jquery',
    'collapsable'
], function ($) {
    'use strict';

    $.widget('mage.redirectRecords', {
        options: {
            classes: {
                mageError: 'mage-error'
            },
            selectors: {
                items: '[data-record-js="items"]',
                item: '[data-record-js="item"]',
                input: '[data-record-js="input"]',
                errorLabel: 'label.mage-error',
                addButton: '[data-record-js="add"]',
                removeButton: '[data-record-js="remove"]'
            },
            namePrefix: '',
            payment_methods: '',
            itemCount: null,
            img_upload_elem: {}
        },
        nodes: {
            item: $('<li>', {
                'class': 'record-item',
                'data-record-js': 'item'
            }),
            label: $('<label>', {
                'class': 'record-label record-field'
            }),
            dropdown: $('<select>', {
                'name': ''
            }),
            dropdownMultiple: $('<select multiple>', {
                'name': ''
            }),
            removeButton: $('<button>', {
                'type': 'button',
                'class': 'record-button -clear -delete',
                'data-record-js': 'remove'
            }),
            trashIcon: $('<i>', {
                'class': 'fa fa-trash',
                'style': 'font-size: 23px'
            }),
            imgInput: $('<input>', {
                'data-record-js': 'input',
                'type': 'text'
            }),
            title: $('<div>', {})
        },

        _create: function () {
            var self = this,
                options = self.options;

            self.items = self.element.find(options.selectors.items);
            self.addButton = self.element.find(options.selectors.addButton);

            // add event for saved record before.
            options.itemCount = self.items.children().length;

            self.addButton.click(function () {
                self.addItem();
            });

            self.items.on('click', options.selectors.removeButton, function () {
                self.removeItem(this);
            });
        },


        /**
         * Removing target item from list
         *
         */
        removeItem: function (button) {
            var item = button.closest(this.options.selectors.item);
            item.remove();
        },

        /**
         * Adding new item to the bottom of the list
         *
         */
        addItem: function () {
            this.options.itemCount++;
            this.items.append(this._getItemNode());
        },

        /**
         * Setting all items names by self positions in the list
         *
         */
        _sorting: function () {
            var options = this.options;

            this.items.children().each(function (index, item) {
                var $item = $(item),
                    $input = $item.find(options.selectors.input);

                $item.find(options.selectors.errorLabel).remove();
                $input.removeClass(options.classes.mageError);

            });
        },

        /**
         *  Generate new item node with name of the position
         *
         *  @return {obj}
         */
        _getItemNode: function () {
            let item = this.nodes.item.clone(),
                removeButton = this.nodes.removeButton.clone(),
                linkInput = this.nodes.imgInput.clone(),
                trashIcon = this.nodes.trashIcon.clone();

            let nameOfLinkInput = this.options.namePrefix.replace(/#/g, + (this.options.itemCount - 1) + "][" +  "redirect_url");

            linkInput.attr({
                'name': nameOfLinkInput,
                'class': 'validate-url'
            });
            item.append(
                this.nodes.label.clone().addClass('website-row').append(this._getDropdownMultiSelectWebsites('website_ids', this.options.website_ids)),
                this.nodes.label.clone().addClass('type-row').append(this._getDropdown('type', this.options.type)),
                this.nodes.label.clone().append(linkInput),
                removeButton.append(trashIcon)
            );

            return item
        },

        _getDropdown: function (name, values) {
            let item = this.nodes.dropdown.clone();

            item.attr({
                'name': this.options.namePrefix.replace(/#/g, + (this.options.itemCount - 1) + "][" +  name)
            });
            $.each(values, function(index, object) {
                item.append(new Option(object['label'], object['value']));
            });
            return item;
        },

        _getDropdownMultiSelectWebsites: function (name, values) {
            var self = this;
            var item = this.nodes.dropdownMultiple.clone();

            item.attr({
                'name': this.options.namePrefix.replace(/#/g, + (this.options.itemCount - 1) + "][" +  name) + '[]'
            });
            $.each(values, function(index, object) {
                self.appendOption(item, object['value'], object['label'], 'sm-option-store', false);
            });
            //sm-option-store
            return item;
        },

        appendOption: function (item, value, text, classOption, isDisable = false) {
            let option;
            option = new Option(text, value);
            if (isDisable) {
                option.disabled = true;
            }
            if (classOption) {
                option.className = classOption;
            }
            item.append(option);
        }
    });

    return $.mage.redirectRecords
});
