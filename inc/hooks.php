<?php
/**
** will handle all wp hooks callbacks
** actions & filters
**/

    // not run if accessed directly
    if( ! defined('ABSPATH' ) ){
  	    die("Not Allowed");
    }


function wpr_hooks_submit_form(){
    
    // check nonce for security
    if ( ! isset($_POST['wpr_nonce']) || ! wp_verify_nonce($_POST['wpr_nonce'], 'wpr_register_user') ) {
        wp_send_json( array('status' => 'error', 'message' => __('Security check failed. Invalid nonce.', 'wpr')) );
    }

    // If captcha is enabled
    $recaptcha_enable = wpr_recaptcha_enable_setting();
    if ($recaptcha_enable == true) {
        $recaptcha_response = wpr_verify_recaptcha();
        if( $recaptcha_response['status'] == 'error' ) {
            wp_send_json ( $recaptcha_response );
        }
    }

    // Get form fields and ID
    $fields = isset($_POST['wpr']) ? $_POST['wpr'] : null;
    $formd_id = isset($_POST['wpr_form_id']) ? $_POST['wpr_form_id'] : null;
    $form = new WPR_Form($formd_id);

    // Set success message
    $success_msg = $form->get_option('wpr_msg_on_reg') == '' ? 'Registration Done !' : $form->get_option('wpr_msg_on_reg');

    // Validate if username or email already exists
    if ( isset( $fields['wp_field']['user_login'] ) && username_exists( $fields['wp_field']['user_login'] ) ) {
        wp_send_json( array('status' => 'error', 'message' => __('Username already exists. Please choose a different one.', 'wpr')) );
    }

    if ( isset( $fields['wp_field']['user_email'] ) && email_exists( $fields['wp_field']['user_email'] ) ) {
        wp_send_json( array('status' => 'error', 'message' => __('Email already exists. Please use a different email address.', 'wpr')) );
    }

    // Proceed with user creation
    $wpr_register = new WPR_Register( $formd_id, $fields );
    $user_id = $wpr_register->create_user();

    if ( is_wp_error( $user_id ) ) {
        if ( $user_id->get_error_code() == 'existing_user_login' || $user_id->get_error_code() == 'existing_user_email' ) {
            $response = array('status'=>'error', 'message'=>sprintf(__("%s", "wpr"), $user_id->get_error_message()));
            wp_send_json( $response );
        }
    }

    // Check for registration errors and append to success message
    if( apply_filters('wpr_show_signup_error_message', true, $formd_id) ) {
        if( $wpr_register->errors ) {
            foreach($wpr_register->errors as $error) {
                $success_msg .= "\r\n" . $error;
            }
        }
    }

    // Create the new user
    $user = new WPR_User($user_id);
    $response = array(  
        'user_id'  => $user_id, 
        'status'   => 'success',
        'signup'   => 'signup',
        'message'  => $success_msg,
        'redirect_url_signup'  => $user->redirect_url_signup(),
    );

    // Send registration email if user creation is successful
    if($user_id){
        $wpr_register->send_registration_fields_in_email();
    }

    // Return JSON response
    wp_send_json( $response );
}


// Setting user password via hook
function wpr_hook_set_password( $signup_data, $wpr_register ) {
	
    // generating wp password by default
	$wpr_password = wp_generate_password( 10, false );

    // Checking if password is set via form
    if( !empty($signup_data['password']) ) {
        $wpr_password = $signup_data['password'];
    }    

	$signup_data['user_pass'] = $wpr_password;
	
	return $signup_data;
}

function wpr_add_loading_overlay() {
    ?>
    <!-- Loading Overlay -->
    <style>
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.3s ease;
        }
        #loading-overlay.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
    </style>
    <div id="loading-overlay">
        <div>Loading...</div>
    </div>
    <?php
}
add_action('wp_head', 'wpr_add_loading_overlay');

function wpr_hide_loading_overlay_script() {
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Wait until all content and styles are fully loaded
        window.onload = function() {
            const loadingOverlay = document.getElementById("loading-overlay");
            loadingOverlay.classList.add("hidden");

            // Optionally remove the overlay after transition
            setTimeout(() => {
                loadingOverlay.remove();
            }, 300); // Adjust timing to match CSS transition duration
        };
    });
    </script>
    <?php
}
add_action('wp_footer', 'wpr_hide_loading_overlay_script');
