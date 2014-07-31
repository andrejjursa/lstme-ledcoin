$(document).ready(function() {
    var hide_all = function(selector, animated) {
        $(selector).each(function() {
            if (animated) {
                $(this).fadeOut('normal');
            } else {
                $(this).css('display', 'none');
            }
            $(this).find('select[name], input[name], textarea[name]').each(function() {
                $(this).attr('hide-name', $(this).attr('name'));
                $(this).removeAttr('name');
            });
        });
    };
    
    var show_all = function(selector, animated) {
        $(selector).each(function() {
            if (animated) {
                $(this).fadeIn('normal');
            } else {
                $(this).css('display', '');
            }
            $(this).find('select[hide-name], input[hide-name], textarea[hide-name]').each(function() {
                $(this).attr('name', $(this).attr('hide-name'));
                $(this).removeAttr('hide-name');
            });
        });
    };
    
    var show_hide_toggle = function(selector_switch, selector_controlls) {
        $(selector_switch).change(function(){
            var value = $(this).val();
            if (value === '0') {
                hide_all(selector_controlls, true);
            } else {
                show_all(selector_controlls, true);
            }
        });
    };
    
    var start_state = function(selector_switch, selector_controlls) {
        var value = $(selector_switch).val();
        if (value === '0') {
            hide_all(selector_controlls, false);
        } else {
            show_all(selector_controlls, false);
        }
    };
    
    show_hide_toggle('#services_enable', '.controlls-services');
    start_state('#services_enable', '.controlls-services');
    
    show_hide_toggle('#products_enable', '.controlls-products');
    start_state('#products_enable', '.controlls-products');
});
