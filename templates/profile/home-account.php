<?php 
// Prevent direct access
if( ! defined("ABSPATH" ) ) {
    die("Not Allowed");
}

$tab_control = $profile->profile_tabs();
$template_vars = array('profile' => $profile);
$user_id = $profile->user->id;
$img_url = wpr_upload_dir_url($user_id);
$profile_photo = wpr_files_setup_get_directory($user_id) . 'wpr_profile_photo.png';
$cover_photo = wpr_files_setup_get_directory($user_id) . 'wpr_cover_photo.png';
$first_letter = ucfirst(substr($profile->user->first_name, 0, 1));
$profile_url = $profile->user->profile_url ?? '';
?>

<div class="wpr-container">
    <div class="wpr-profile-header">
        <!-- Profile header and cover photo section -->
        <?php if ($profile->enable_photo_area == 'yes') { ?>
            <div class="wpr-pr-panel">
                <div class="wpr-pr-coverphoto" style="background-color: <?php echo esc_attr($profile->banner_clr); ?>;">
                    <div class="wpr-cv-uploader">
                        <img src="<?php echo $img_url ?>wpr_cover_photo.png" alt="Cover Photo" class="image img-responsive">
                    </div>
                </div>

                <!-- Profile photo and display name -->
                <div class="wpr-pr-userphoto wpr-profile-photo-render">
                    <div class="wpr-userphoto-render" style="<?php echo esc_attr($profile_style); ?>"><?php echo $html; ?></div>
                    <div class="wpr-display-name">
                        <h3 class="wpr-pr-username"><?php echo $profile->user->display_name; ?></h3>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="wpr-profile-layout">
        <!-- Profile navigation sidebar -->
        <?php if (is_user_logged_in()) { ?>
            <nav class="wpr-profile-adjust" id="main-nav">
                <ul class="wpr-pr-tab">
                    <?php foreach ($tab_control as $tab_id => $tab_val) { ?>
                        <li class="wpr_li_check">
                            <a href="#<?php echo esc_attr($tab_id); ?>" class="scroll-link" data-toggle="tab">
                                <i class="fa <?php echo esc_attr($tab_val['icon']); ?>" aria-hidden="true"></i>
                                <?php echo $tab_val['menu']; ?>
                            </a>
                        </li>
                    <?php } ?>
                    <!-- View Profile link -->
                    <li class="wpr_li_check view-profile">
                        <a href="<?php echo esc_url($profile_url); ?>" class="scroll-link">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                            <?php _e('View Profile', 'wp-registration'); ?>
                        </a>
                    </li>
                    <!-- Sign Out link -->
                    <li class="wpr_li_check signout">
                        <a href="<?php echo wp_logout_url(); ?>" class="scroll-link">
                            <i class="fa fa-sign-out"></i>
                            <?php _e('Sign Out', 'wp-registration'); ?>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php } ?>
        
        <!-- Main content area for tabs -->
        <div class="wpr-tab-body">
            <div class="tab-content wpr-tab">
                <?php foreach ($tab_control as $tab_id => $tab_val) {
                    wpr_load_templates($tab_val['template'], $template_vars);
                } ?>
            </div>
        </div>
    </div>
</div>
