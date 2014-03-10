/**
 *-----------------------------------------------------------------------
 * Module: Polly
 * Version: 1.0
 *-------------------------------------------------------------------------
 *
 * Authors:
 *
 * Tapio Löytty, <tapsa@orange-media.fi>
 * Web: www.orange-media.fi
 *
 * Goran Ilic, <uniqu3e@gmail.com>
 * Web: www.ich-mach-das.at
 *
 *-------------------------------------------------------------------------
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 * Or read it online: http://www.gnu.org/licenses/licenses.html*GPL
 *
 *-------------------------------------------------------------------------
 **/
;
(function (global, $) {
    'use strict';

    var Polly = global.Polly = {};
    
    Polly.version = '1.0';
    
    /**
     * Initializes needed function 
     */
    Polly.runner = function () {
        var _this = this;
        
        // Initialize UI
        _this.UI.itemSortable();
        _this.UI.addNewItem();
        _this.UI.inlineEdit();
        // load existing items
        _this.dataHandler.renderExistingItems();
    };


    Polly.dataHandler = {
        
        /**
         * @description Build a unordered list from JSON Array
         * @function renderExistingItems() 
         */
        renderExistingItems: function () {
            
            var _this = this,
                $container = $('#polly-options'),
                $input = $('#polly-data-values'),
                data = JSON.parse(decodeURIComponent($input.val())),
                lang = $container.data('polly-lang'),
                actionid = $container.data('polly-actionid'),
                items = [];
            
            $(data).each(function (index, el) {
                
                // setup layout for items
                var $li = $('<li/>')
                        .addClass('cf polly-row')
                        .attr('data-polly-option-id', el.id)
                        .attr('data-polly-option-type', el.type)
                        .attr('data-polly-position', index),
                    $draggable = $('<span/>')
                        .addClass('polly-drag-handle')
                        .attr('title', lang.sort_drag)
                        .appendTo($li)
                        .append($('<span/>').addClass('visuallyhidden').text(lang.sort_drag)),
                    $a = $('<a/>')
                        .text(el.data)
                        .addClass('polly-editable editable-click polly-question-text')
                        .attr('data-type', 'text')
                        .attr('data-title', lang.sort_drag)
                        .appendTo($li),
                    $delete = $('<span/>')
                        .addClass('polly-remove')
                        .attr('title', lang.delete)
                        .appendTo($li)
                        .append($('<i/>').attr('aria-hidden', 'true').addClass('polly-ico-remove'));

                items.push($li);
            });

            // append all items to parent UL
            $container.append.apply($container, items);
            
            _this.deleteItem();
            _this.saveItemValues();
        },
        
        /**
         * @description Handles deleting of a item, fades out parent LI and updates JSON Array
         * @function deleteItem()
         *  
         */
        deleteItem: function () {
            
            var _this = this,
                $trigger = $('.polly-remove');
            
            $trigger.on('click', function () {
                $(this).parent('li').fadeOut('fast', function () {
                    
                    var $data = $(this).data(),
                        option_id = $data.pollyOptionId;

                    // TODO Add delete handling of item with ajax and pass option_id variable
                    console.log(option_id);
                    // remove element and update JSON Array
                    $(this).remove();
                    _this.updateJSONArray();
                });
            });
        },
        
        /**
         * @description Updates data-polly-position data attribute with new index number
         * @function updateItemsPosition() 
         */
        updateItemsPosition: function () {
            
            var _this = this,
                $container = $('#polly-options'),
                $items = $container.children();
                
                $items.each(function (index, el) {
                    $(el).attr('data-polly-position', index);
                });
            
        },
        
        /**
         * @description Updates JSON Array based on x-editable hidden Event, which is triggered each time a editable is saved or closed
         * @function saveItemValues() 
         * @requires x-Editable plugin
         */
        saveItemValues: function () {
            
            var _this = this;
            
            $('.polly-editable').on('click', function(event) {
                
                event.preventDefault();
                
                $(this).on('hidden', function (e, reason) {
                    _this.updateJSONArray();
                });
            });
        },
        
        /**
         * @description updates JSON Array and hidden input value for submission
         * @function updateJSONArray()
         * @requires jQuery JSON plugin 
         */
        updateJSONArray: function () {
            
            var $container = $('#polly-options'),
                $items = $container.children(),
                $input = $('#polly-data-values'),
                data = [];
                
                $items.each(function (index, el) {
                    var $this = $(el),
                        $data = $this.data(),
                        values = {};
                        
                    values.id = $data.pollyOptionId;
                    values.type = $data.pollyOptionType;
                    values.data = $this.find('a').text();
                    
                    if ((values.data !== 'Empty') && (values.data !== 'Insert question')) {
                        data.push(values);
                    }
                    
                });
            
            $input.val(encodeURIComponent(JSON.stringify(data)));
        }
    };

    Polly.UI = {
        
        /**
         * @description Initializes jQuery UI sortable function and updates items Position and JSON Array 
         * @function itemSortable()
         * @requires jQuery UI
         */
        itemSortable: function () {
            $('#polly-options').sortable({
                helper: function (e, el) {
                    // element while sorting
                    var $helper = $('<div class="polly-drag-helper">' + $(el).find('.polly-question-text').text() + '</div>');

                    $helper.appendTo('body');
                    return $helper;
                },
                update: function (event, ui) {
                    // update needed values
                    Polly.dataHandler.updateItemsPosition();
                    Polly.dataHandler.updateJSONArray();
                }
            });
        },
        
        /**
         * @description Handles adding new LI element for a new option item
         * @function addNewItem() 
         */
        addNewItem: function () {

            var $container = $('#polly-options'),
                lang = $container.data('polly-lang'),
                actionid = $container.data('polly-actionid');

            $('#polly-add-new').button({
                icons: {
                    primary: 'ui-icon-circle-plus'
                }
            }).click(function (e) {

                var $trigger = $(this),
                    $items = $container.children(),
                    count = $items.length,
                    $li = $('<li/>')
                        .addClass('cf polly-row')
                        .attr('data-polly-option-id', '')
                        .attr('data-polly-option-type', 'PreDefined')
                        .attr('data-polly-position', count + 1),
                    $draggable = $('<span/>')
                        .addClass('polly-drag-handle')
                        .attr('title', lang.sort_drag)
                        .appendTo($li)
                        .append($('<span/>').addClass('visuallyhidden').text(lang.sort_drag)),
                    $a = $('<a/>')
                        .addClass('polly-editable editable-click editable-empty polly-question-text')
                        .text(lang.insert_question)
                        .attr('data-type', 'text')
                        .attr('data-title', lang.sort_drag)
                        .appendTo($li),
                    $delete = $('<span/>')
                        .addClass('polly-remove')
                        .attr('title', lang.delete)
                        .appendTo($li)
                        .append($('<i/>').attr('aria-hidden', 'true').addClass('polly-ico-remove'));

                $container.append($li);
                
                Polly.dataHandler.deleteItem();
                Polly.dataHandler.saveItemValues();

                e.preventDefault();
            });
        },

        /**
         * @description Initializes x-editable jQuery plugin for inline editing of option values
         * @function inlineEdit()
         * @requires x-editable plugin 
         */
        inlineEdit: function () {

            $.fn.editable.defaults.mode = 'inline';
            $('#polly-options').editable({
                placement: 'right',
                selector: 'a'
            });
        }
    };

    $(document).ready(function () {
        Polly.runner();
    });

}(this, jQuery));