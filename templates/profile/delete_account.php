<?php 
/*
** Delete User Account
*/
// Exit if accessed directly
if( ! defined("ABSPATH" ) )
    die("Not Allowed");

?>
<div class="wpr-tab-pane tab-pane fade in" id="delete_account">
    <div class="wpr-delete-container">
        <input type="hidden" id="wpr_delete_account" name="wpr_delete_account" value="<?php echo esc_attr($profile->user->id); ?>" >
        
        <div class="wpr-delete-warning">
            <i class="fa fa-exclamation-triangle wpr-warning-icon" aria-hidden="true"></i>
            <h4><?php _e('Warning!', 'wp-registration'); ?></h4>
            <p class="wpr-confirm-text">
                <?php _e('Are you sure you want to permanently delete your account? This action cannot be undone.', 'wp-registration'); ?>
            </p>
        </div>
        
        <div class="wpr-delete-action">
            <a href="#" class="btn wpr-delete-btn wpr_user_delete_account"><?php _e('Yes, Delete My Account', 'wp-registration'); ?></a>
        </div>
    </div>
</div>
