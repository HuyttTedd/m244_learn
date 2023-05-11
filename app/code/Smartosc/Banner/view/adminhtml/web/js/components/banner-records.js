define([
    'jquery',
    'collapsable'
], function ($) {
    'use strict';

    $.widget('mage.bannerRecords', {
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
            labelImg: $('<label>', {
                'class': 'record-label record-field img-preview'
            }),
            input: $('<input>', {
                'name': '',
                'class': 'required-entry',
                'data-record-js': 'input',
                'type': 'file'
            }),
            inputFileName: $('<input>', {
                'name': '',
                'data-record-js': 'input',
                'type': 'hidden'
            }),
            dropdown: $('<select>', {
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
            imgPreview: $('<img alt="image preview banner" src="">', {
                'class': 'img-preview'
            })
        },

        _create: function () {
            var self = this,
                options = self.options;

            self.items = self.element.find(options.selectors.items);
            self.addButton = self.element.find(options.selectors.addButton);

            // add event for saved record before.
            self.options.img_upload_elem.each(function (item, index) {
                self.imageUploadedPreview(item, "#img-preview-" + index);
            });
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
            var item = button.closest(this.options.selectors.item),
                index = $(item).index();

            // this.options.itemCount--;

            item.remove();

            // if (index !== this.options.itemCount) {
            //     this._sorting();
            // }
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
                bannerFile = this.nodes.input.clone(),
                bannerFileName = this.nodes.inputFileName.clone(),
                removeButton = this.nodes.removeButton.clone(),
                imgPreview = this.nodes.imgPreview.clone(),
                trashIcon = this.nodes.trashIcon.clone();

            let nameAttr = this.options.namePrefix.replace(/#/g, + (this.options.itemCount - 1) + "][" +  "banner_file");
            this.imageUploadedPreview(nameAttr, imgPreview);

            bannerFile.attr({
                'name': nameAttr
            });

            let fileNameAttr = this.options.namePrefix.replace(/#/g, + (this.options.itemCount - 1) + "][" +  "banner_file_name");
            bannerFileName.attr({
                'name': fileNameAttr
            });

            item.append(
                this.nodes.label.clone().append(this._getDropdown('website_ids', this.options.website_ids)),
                this.nodes.label.clone().addClass('banner-file').append(bannerFile).append(bannerFileName),
                this.nodes.labelImg.clone().append(imgPreview),
                removeButton.append(trashIcon)
            );

            return item
        },

        imageUploadedPreview: function (name, imgPreview) {
            $(document).on('change', 'input[name="' + name + '"]', function() {
                let file = $('input[name="' + name + '"]').get(0).files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(){
                        $(imgPreview).attr("src", reader.result);
                    }

                    reader.readAsDataURL(file);
                }
            });
        },

        _getDropdown: function (name, values) {
            var item = this.nodes.dropdown.clone();

            item.attr({
                'name': this.options.namePrefix.replace(/#/g, + (this.options.itemCount - 1) + "][" +  name)
            });
            $.each(values, function(val, text) {
                item.append(new Option(text, val));
            });

            return item;
        }
    });

    return $.mage.bannerRecords
});
