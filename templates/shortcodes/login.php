<?php 
/**
 * Core Login Template
 */

// Prevent direct access
if( ! defined("ABSPATH" ) ) die("Not Allowed");

$error_types = array('invalid_login');
$form_id  = WPR_Settings()->get_option('social_form_id');
$form = new WPR_Form($form_id);
?>

<div class="wpr-login-wrapper">
    <?php wpr_show_errors($error_types); ?>
    <div class="wpr-login-content">
        <div class="wpr-login-heading">
            <h2><?php _e('Login', 'wp-registration'); ?></h2>
        </div>
        <?php do_action('wpr_after_form_start', $form); ?>
        <form id="wpr-login-form" action="<?php echo esc_url(wp_login_url()); ?>" method="post">
            <input type="hidden" name="action" value="wpfm_login">
            
            <div class="wpr-login-field">
                <label for="username"><i class="fa fa-user"></i></label>
                <input type="text" name="log" id="username" placeholder="<?php _e('Username or Email', 'wp-registration'); ?>" required>
            </div>

            <div class="wpr-login-field">
                <label for="password"><i class="fa fa-key"></i></label>
                <input type="password" name="pwd" id="password" placeholder="<?php _e('Password', 'wp-registration'); ?>" required>
            </div>

            <div class="wpr-login-remember">
                <label for="rememberme">
                    <input type="checkbox" name="rememberme" id="rememberme" value="forever">
                    <?php _e('Remember me', 'wp-registration'); ?>
                </label>
            </div>

            <button type="submit" class="wpr-login-submit"><?php _e('Login', 'wp-registration'); ?></button>
            
            <?php do_action('wpr_before_form_end', $form); ?>

            <?php if ($wpr_reset_password_url = WPRLOGIN()->wpr_get_core_page_for_redirect('password_reset')): ?>
                <div class="wpr-login-links">
                    <a href="<?php echo esc_url($wpr_reset_password_url); ?>"><?php _e('Lost your password?', 'wp-registration'); ?></a>
                </div>
            <?php endif; ?>

            <?php if ($wpr_register_url = WPRLOGIN()->wpr_get_core_page_for_redirect('register')): ?>
			    <p class="wpr-signup">
			        <?php _e("Don't have an account?", "wp-registration"); ?> 
			        <a href="<?php echo esc_url($wpr_register_url); ?>" class="wpr-signup-link"><?php _e('Sign up here.', 'wp-registration'); ?></a>
			    </p>
			<?php endif; ?>

        </form>
    </div>
</div>
