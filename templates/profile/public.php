<?php 
/*
** Overview Tab view show the information
*/

	// not run if accessed directly
    if( ! defined("ABSPATH" ) )
    	die("Not Allewed");
    	
  $profile_id           = isset($profile->user->id) ? $profile->user->id : '';
  $last_login     	    = get_user_meta( $profile_id,  'wpr_last_login', true );
  $last_page_visit      = get_user_meta( $profile_id,  'wpr_last_page_visit', true );
  $user_last_page_visit = get_the_title($last_page_visit);

  	if ( $last_login != '') {
  		$the_login_date      = date_i18n(get_option( 'date_format' ).' '.get_option( 'time_format' ), $last_login );
  	}else {
 
  		$the_login_date = 'user not login';
  	}

  $template_vars   = array();
  $template_vars   = array('profile' => $profile);
  $msg_from_admin  = get_option('wpr_user_msg');

?>
<div class="wpr-tab-pane tab-pane fade in active" id="overview_tab" style="height: 400px;">
    <?php if ($msg_from_admin) {  		
        foreach ($msg_from_admin as $index => $role_msg) {
            foreach ($role_msg as $key => $value) {
                $profile_role = isset($profile->user->role) ? $profile->user->role : '';		 
                if (($key == $profile_role || $key == 'all') && !empty($role_msg[$key]) && is_user_logged_in()) { ?>
                    <div class="wpr_msg_box">
                        <p><?php echo $role_msg[$key]; ?></p>
                    </div>
                <?php }
            }
        } 
    } ?>


    <div class="modal-body wpr-pr-overview">
        <div class="wpr-data-view">
            <?php if (is_user_logged_in()) {
                foreach ($profile->user->overview_fields() as $data_name => $meta) {
                    $profile_title = isset($meta['label']) ? $meta['label'] : '';
                    $profile_value = isset($meta['value']) ? $meta['value'] : ''; ?>
                    <div class="wpr-data-item">
                        <div class="wpr-pr-title"><?php echo $profile_title; ?></div>
                        <div class="wpr-pr-value"><?php echo $profile_value; ?></div>
                    </div>
                <?php }
            } ?>
        </div>
    </div>

</div>