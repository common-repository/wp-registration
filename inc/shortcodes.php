<?php
/**
 * Shortcode Callbacks for WPR
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    die("Not Allowed");
}

/**
 * Load and enqueue styles and scripts common to all forms
 */
function wpr_enqueue_common_assets() {
    // Register common CSS files
    wp_register_style('wpr-login', WPR_URL . "/css/wpr-login.css");
    wp_register_style('wpr-font', WPR_URL . "/css/font-awesome/css/font-awesome.css");
    wp_register_style('wpr-sweetalert-style', WPR_URL . "/css/sweetalert.css");
    // Enqueue common CSS files
    wp_enqueue_style('wpr-login');
    wp_enqueue_style('wpr-font');
    wp_enqueue_style('wpr-sweetalert-style');
    
    // Register common JS files
    wp_register_script('wpr-sweetalert-js', WPR_URL . "/js/sweetalert.js", array('jquery'), WPR_VERSION, true);
    wp_register_script('wpr-script', WPR_URL . "/js/wpr-frontend.js", array('jquery'), WPR_VERSION, true);
    // Enqueue common JS files
    wp_enqueue_script('wpr-sweetalert-js');
    wp_enqueue_script('wpr-script');
    
    // Localize AJAX URL
    wp_localize_script('wpr-script', 'wpr_vars', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}

/**
 * Render login form shortcode
 */
function wpr_shortcodes_render_login($attr) {
    wpr_enqueue_common_assets();

    ob_start();
    wpr_load_templates("shortcodes/login.php");
    return ob_get_clean();
}

/**
 * Render password reset form shortcode
 */
function wpr_shortcodes_render_password_reset($attr) {
    wpr_enqueue_common_assets();

    ob_start();
    wpr_load_templates("shortcodes/password-reset.php");
    return ob_get_clean();
}

/**
 * Render signup form shortcode
 */
function wpr_shortcodes_render_signup($atts) {
    $wpr_params = shortcode_atts(array('id' => null), $atts);
    $form_id = $wpr_params['id'];

    if ($form_id === null) {
        die(__("No form ID found", "wp-registration"));
    }

    // Register additional CSS for signup
    wp_register_style('wpr-register', WPR_URL . "/css/wpr-register.css");
    wp_enqueue_style('wpr-register');

    // Load additional JS for signup
    wp_register_script('wpr-lib', WPR_URL . "/js/wpr-lib.js", array('jquery'), WPR_VERSION, true);
    wp_enqueue_script('wpr-lib');

    $form = new WPR_Form($form_id);
    $form_title = $form->get_option('wpr_form_heading');
    $form_css = $form->get_option('wpr_form_css');
    
    // Inline style if custom CSS exists
    if (!empty($form_css)) {
        wp_add_inline_style('wpr-register', $form_css);
    }

    $error_msg = $form->get_option('wpr_error_msg') ?: 'Check all error messages';
    $form_width = $form->get_option('wpr_form_width') ?: '100%';
    $form_bg_color = $form->get_option('wpr_form_bg_clr') ?: '#ffffff';
    $form_header_color = $form->get_option('wpr_form_header_color') ?: '#ffffff';

    // Localize AJAX URL and error message
    wp_localize_script('wpr-script', 'wpr_vars', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'error_msg' => $error_msg,
    ));

    ob_start();
    ?>
    <div id="wpr-wrapper">
        <div class="wpr-field-model" style="width:<?php echo esc_attr($form_width); ?>; background:<?php echo esc_attr($form_bg_color); ?>;">
            <h2 class="wpr-form-title" style="background:<?php echo esc_attr($form_header_color); ?>;"><?php echo sprintf(__("%s", "wp-registration"), $form_title); ?></h2>
            <div class="wpr_model_selector">
                <?php
                $template_vars = array('form' => $form);
                wpr_load_templates("forms/registration.php", $template_vars);
                ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}