(function($) {
    $.fn.getAttributes = function() {
        var attributes = []; 

        if( this.length ) {
            $.each( this[0].attributes, function( index, attr ) {
                attributes.push({
                    name: attr.name,
                    value: attr.value
                });
            } ); 
        }

        return attributes;
    };
})(jQuery);

$.mobile.switchPopup = function(sourceElement, destinationElement, onswitched) {
    var afterClose = function() {
        destinationElement.popup("open");
        sourceElement.off("popupafterclose", afterClose);

        if (onswitched && typeof onswitched === "function"){
            onswitched();
        }
    };

    sourceElement.on("popupafterclose", afterClose);
    sourceElement.popup("close");
};

var make_gridtable_active = function(gridtable_selector) {
    var gridtables = $(gridtable_selector);
    
    gridtables.each(function(index, gridtable) {
        var $gridtable = $(gridtable);
        if ($gridtable.is('table')) {
            var operations = $(gridtable).attr('data-gridtable-operations').split(',');
            var operations_template = [];
            for (var i in operations) {
                var operation_data = operations[i].split(':');
                if (operation_data.length >= 2) {
                    var operation_tmpl = {};
                    operation_tmpl.action = operation_data[0];
                    operation_tmpl.text = operation_data[1];
                    operation_tmpl.is_prompt = $(gridtable).attr('data-gridtable-operation-' + operation_tmpl.action + '-prompt') === 'true';
                    if (operation_tmpl.is_prompt === true) {
                        operation_tmpl.cancel_button_text = $(gridtable).attr('data-gridtable-operation-' + operation_tmpl.action + '-prompt-cancel');
                        operation_tmpl.ok_button_text = $(gridtable).attr('data-gridtable-operation-' + operation_tmpl.action + '-prompt-ok');
                        operation_tmpl.ok_button_url = $(gridtable).attr('data-gridtable-operation-' + operation_tmpl.action + '-prompt-ok-url');
                        operation_tmpl.prompt_title = $(gridtable).attr('data-gridtable-operation-' + operation_tmpl.action + '-prompt-title');
                        operation_tmpl.prompt_text = $(gridtable).attr('data-gridtable-operation-' + operation_tmpl.action + '-prompt-text');
                    } else {
                        operation_tmpl.url = $(gridtable).attr('data-gridtable-operation-' + operation_tmpl.action + '-url');
                    }
                    operations_template.push(operation_tmpl);
                }
            }
            $gridtable.find('tbody tr').css({
                'cursor': 'pointer'
            }).each(function(tr_index, tr_element) {
                var $tr = $(tr_element);
                var attributes = $tr.getAttributes();
                var replacements = [];
                for (var i in attributes) {
                    var attribute = attributes[i];
                    if (attribute.name.substr(0, 15) === 'data-gridtable-') {
                        replacements.push({
                            marker: '--' + attribute.name.substr(15).toUpperCase() + '--',
                            value: attribute.value
                        });
                    }
                }
                var replaceMarkers = function(text) {
                    var output = String(text);
                    
                    for(var i in replacements) {
                        var find = replacements[i].marker;
                        var re = new RegExp(find, 'g');
                        output = output.replace(re, replacements[i].value);
                    }
                    
                    return output;
                };
                var unique = $tr.attr('data-gridtable-unique');
                if (typeof(unique) === 'string') {
                    var popup = '<div data-role="popup" id="popup-' + unique + '" data-short="' + unique + '" data-theme="c" data-position-to="origin" style="max-width:400px;">';
                    popup += '<ul data-role="listview" data-inset="true" style="min-width: 200px;"><li data-role="list-divider">Akcia</li></ul>';
                    popup += '</div>';
                    var popup_element = $(popup);
                    var popup_element_listview = popup_element.find('ul[data-role=listview]');
                    for (var i in operations_template) {
                        var operation_tmpl = operations_template[i];
                        var button_li = $('<li></li>');
                        var button = $('<a href="#"></a>').text(operation_tmpl.text);
                        button.appendTo(button_li);
                        button_li.appendTo(popup_element_listview);
                        if (operation_tmpl.is_prompt === false) {
                            var url = replaceMarkers(operation_tmpl.url);
                            button.attr('href', url);
                            button.attr('data-ajax', 'false');
                        } else {
                            var dialogPopup = '<div data-role="popup" id="dialog_popup_' + unique + '_' + operation_tmpl.action + '" data-short="' + unique + '_' + operation_tmpl.action + '" data-overlay-theme="d" data-theme="d" data-dismissible="false" style="max-width:400px;">';
                            dialogPopup += '<div data-role="header" data-theme="d"><h1>' + operation_tmpl.prompt_title + '</h1></div>';
                            dialogPopup += '<div role="main" class="ui-content">';
                            dialogPopup += '<p>' + replaceMarkers(operation_tmpl.prompt_text) + '</p>';
                            dialogPopup += '<a href="' + replaceMarkers(operation_tmpl.ok_button_url) + '" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-ajax="false">' + operation_tmpl.ok_button_text + '</a>';
                            dialogPopup += '<a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-c" data-rel="back" data-transition="flip">' + operation_tmpl.cancel_button_text + '</a>';
                            dialogPopup += '</div></div>';
                            var dialogPopupElement = $(dialogPopup);
                            $('#strojak-main-page').append( dialogPopupElement ).trigger( "create" );
                            button.click(function() {
                                $.mobile.switchPopup(popup_element, dialogPopupElement);
                            });
                        }
                    }
                    $('#strojak-main-page').append( popup_element ).trigger( "create" );
                    $tr.click(function(e) {
                        popup_element.popup('open', {
                            positionTo: 'origin',
                            transition: 'pop',
                            x: e.pageX,
                            y: e.pageY
                        } );
                    });
                }
            });
        }
    });
};