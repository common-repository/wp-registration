"use strict";
jQuery(function($) {
    // Check if WooCommerce order details are present
    if ($(document).find('.wpr-woocomerce-order-detail').length != 0) {
        $('.wpr_li_check').each(function(index, val) {
            if ($(val).hasClass('signout') || $(val).hasClass('view-profile')) return;
            $(val).find('a').attr("aria-expanded", "false");
        });
        
        $('.wpr-tab-pane:first').removeClass('active');
        $('.wpr_li_check:nth-child(2)').addClass('active');
        $('.wpr_li_check:nth-child(2) a').attr("aria-expanded", "true");
        $('#woocommerce').addClass('active');
    }

    // Handle tab navigation
    $('#main-nav a').click(function(e) {
        // Skip handling for signout links
        if ($(this).closest('li').hasClass('signout')) {
            return; // Allows logout to function normally
        }
        
        if ($(this).closest('li').hasClass('view-profile')) {
            return; // Allows logout to function normally
        }
        
        e.preventDefault();

        // Deactivate all tabs and content panes
        $('#main-nav a').removeClass('active').attr("aria-expanded", "false");
        $('.wpr-tab-pane').removeClass('active');

        // Activate the clicked tab and corresponding pane
        $(this).addClass('active').attr("aria-expanded", "true");
        const targetPane = $(this).attr("href");
        $(targetPane).addClass('active');
    });

    // Billing address redirection
    $(".u-column1 a").click(function(e) {
        e.preventDefault();
        var permalink_account = $(".wpr-edit-url").val();
        var edit_url_billing = $(".u-column1 a").attr('href');
        var last_bill = edit_url_billing.split('/');
        var lastSegmentBill = last_bill.pop() || last_bill.pop();  // handle potential trailing slash
        
        if (edit_url_billing.indexOf(lastSegmentBill) > -1) {
            window.location = permalink_account + 'edit-address/' + lastSegmentBill;
        }
    });

    // Shipping address redirection
    $(".u-column2 a").click(function(e) {
        e.preventDefault();
        var permalink_account = $(".wpr-edit-url").val();
        var edit_url_shipping = $(".u-column2 a").attr('href');
        var last_ship = edit_url_shipping.split('/');
        var lastSegmentShip = last_ship.pop() || last_ship.pop();  // handle potential trailing slash    
        if (edit_url_shipping.indexOf(lastSegmentShip) > -1) {
            window.location = permalink_account + 'edit-address/' + lastSegmentShip;
        }    
    });

    // Profile photo interactions
    $('.wpr-pr-change-photo').hide();
    $('.wpr-pr-coverupload').hide();
    $(".wpr-pr-userphotp").mouseenter(function() {
        $('.wpr-pr-change-photo').show();
    }).mouseleave(function() {
        $('.wpr-pr-change-photo').hide();
    });

    $(".wpr-pr-coverphoto").mouseenter(function() {
        $('.wpr-pr-coverupload').show();
    }).mouseleave(function() {
        $('.wpr-pr-coverupload').hide();
    });

    // User delete account
    $(document).on('click', '.wpr_user_delete_account', function(e) {
        e.preventDefault();
        var user_id = $('#wpr_delete_account').val();
        var wpr_nonce = $('#wpr_nonce').val();
        var data = {    
            'action': 'delete_user_account', 
            'wpr_nonce': wpr_nonce, 
            'user_id': user_id
        };
        $.post(wpr_vars.ajax_url, data, function(resp) {
            WPR.alert(resp.message, resp.status, function() { 
                location.reload();
            });
        }, 'json');
    });

    // Password change
    $('.wpr-pr-pass-wrapper').find('.wpr-pass-alert').hide();
    $(document).on('click', '.wpr-change-pass', function(e) {
        e.preventDefault();
        $(".wpr-pass-alert").html('<img src="' + wpr_vars.loading + '">').css('border-left', 'none').show();

        var has_error = false;        
        var oldpassword = $('#old_password').val();
        var newpassword = $('#new_password').val();
        var renewpassword = $('#re_new_password').val();
        var wpr_nonce = $('#wpr_change_pass_nonce').val();

        if (oldpassword == '') {
            $(".wpr-pass-alert").html(wpr_vars.strings.old_password_empty).css('border-left', '7px solid red').show();
            has_error = true;
        } else if (newpassword == '') {
            $(".wpr-pass-alert").html(wpr_vars.strings.new_password_empty).css('border-left', '7px solid red').show();
            has_error = true;
        } else if (newpassword != renewpassword) {
            $(".wpr-pass-alert").html(wpr_vars.strings.new_password_not_match).css('border-left', '7px solid red').show();
            has_error = true;
        }

        if (!has_error) {
            var data = {    
                'action': 'profile_change_password', 
                'wpr_nonce': wpr_nonce, 
                'old_password': oldpassword,
                'new_password': newpassword
            };
            $.post(wpr_vars.ajax_url, data, function(data) {
                WPR.alert(data.message, data.status, function() { 
                    if (data.status == 'error') {
                        $('.wpr-pr-pass-wrapper').find('.wpr-pass-alert').hide();
                    } else {
                       location.reload();
                    }
                });
            }, 'json');
        }
    });
});
