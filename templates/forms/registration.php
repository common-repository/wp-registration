<?php
/**
 * Registration form template
**/

// Prevent direct access
if( ! defined("ABSPATH" ) )
    die("Not Allowed");

?>

<!-- /.MultiStep Form -->
<form id="wpr-form-<?php echo esc_attr($form->form_id) ?>" class="wpr-forms">
    <div class="row">
        <input type="hidden" name="action" value="wpr_submit_form">
        <input type="hidden" name="wpr_form_id" value="<?php echo esc_attr($form->form_id) ?>">
        <?php wp_nonce_field( 'wpr_register_user', 'wpr_nonce' ) ?>

        <?php
            $form->render_form_fields();

            do_action('wpr_before_submit_button', $form);
        ?>
    </div>

    <?php
        // Display the submit button outside of the row div
        if (count($form->check_steps()) < 1) {
            echo $form->submit_btn();    		
        }
    ?>
</form>
