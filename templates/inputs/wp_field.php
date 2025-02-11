<?php
/**
** WPR Template to render WordPress input
**/

// Prevent direct access
if( ! defined("ABSPATH" ) ) {
    die("Not Allowed");
}

$fm = new WPR_InputMeta($field_meta, 'wp_field');
$field_type = $fm->data_name;
$confirm_password_setting = $fm->confirm_password;
$accept_weak_pass = $fm->accept_weak_password;

if ($field_type == 'password') {
    $input_type = 'password';
    $html = '<span id="password_result"></span>';
} else {
    $input_type = 'text';
    $html = '';
}

$class = '';
$htmls = '';

if (!empty($fm->icon)) { 
    $class = "input-group";
    $htmls .= '<span class="input-group-addon">';
    $htmls .= '<i class=" '.$fm->icon.'" aria-hidden="true"></i>';
    $htmls .= '</span>';
} 
?>

<div class="col-md-<?php echo esc_attr($fm->width); ?> wpr_field_wrapper">
    <div class="form-group <?php echo $class; ?>">
        <label class="wpr-field-title">
            <?php echo $fm->title; ?>
            <span class="wpr_field_icon" data-desc="<?php echo esc_attr($fm->desc); ?>"> *</span>
        </label>
        <?php echo $htmls; ?>
        <p 
            class="wpr_field_selector" 
            data-key="<?php echo esc_attr($fm->data_name); ?>" 
            data-type="<?php echo esc_attr($input_type); ?>"
        >
            <input 
                type="<?php echo esc_attr($input_type); ?>" 
                name="<?php echo esc_attr($fm->input_name); ?>" 
                id="<?php echo esc_attr($fm->data_name); ?>" 
                class="<?php echo esc_attr($fm->classes_fm); ?>" 
                placeholder="<?php echo esc_attr($fm->placeholder); ?>" 
                data-req="<?php echo esc_attr($fm->required); ?>" 
                data-message="<?php echo esc_attr($fm->error_msg); ?>" 
                data-pass="<?php echo esc_attr($fm->accept_weak_password); ?>"
                value="<?php echo esc_attr($fm->value); ?>" 
            > 
        </p>
        <span class="wpr-field-desc"><?php echo esc_attr($fm->desc); ?></span>
    </div>
    <?php echo $html; ?>

    <?php if ($confirm_password_setting == 'on') { ?>
        <div class="form-group <?php echo $class; ?> col-md-<?php echo esc_attr($fm->width); ?> mt-3">
            <label class="wpr-field-title"><?php _e('Confirm Password', 'wp-registration'); ?></label>
            <?php echo $htmls; ?>
            <p 
                class="wpr_field_selector" 
                data-key="<?php echo esc_attr($fm->data_name); ?>" 
                data-type="password"
            >
                <input 
                    type="password"  
                    class="<?php echo esc_attr($fm->classes_fm); ?>" 
                    name="<?php echo esc_attr($fm->confirm_pass_name); ?>" 
                    id="wpr_confirm_password" 
                    data-req="on" 
                    data-message="Confirm password must be required"
                />
            </p>
        </div>
    <?php } ?>
    <span class="wpr_field_error"></span>
</div>
