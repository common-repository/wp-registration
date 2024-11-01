<?php
/**
 * Core Password Reset Template
 */

// Prevent direct access
if (!defined("ABSPATH")) {
    die("Not Allowed");
}

$error_types = array('invalidcombo', 'empty_username');
?>
<div class="wpr-pass-reset-wrapper">
    <?php wpr_show_errors($error_types); ?>
    <div class="wpr-pass-reset-content">
        <div class="wpr-pass-reset-heading">
            <h2><?php _e('Password Reset', 'wp-registration'); ?></h2>
        </div>
        <form name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url(wp_lostpassword_url()); ?>" method="post">
            
            <div class="wpr-pass-reset-field">
                <label for="user_login"><i class="fa fa-key"></i></label>
                <input type="text" name="user_login" id="user_login" placeholder="<?php _e('Username or Email Address', 'wp-registration'); ?>" required>
            </div>
            
            <input type="hidden" name="redirect_to" value="">

            <button type="submit" name="wp-submit" id="wp-submit" class="wpr-pass-reset-btn"><?php _e('Get new password', 'wp-registration'); ?></button>
        </form>
    </div>
</div>
