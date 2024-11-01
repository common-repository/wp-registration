<?php 
// Main Template Home Page

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
?>

<div class="wpr-profile-wrapper container">
    <header class="wpr-profile-header">
        <div class="wpr-banner">
            <div class="wpr-cover-photo" style="background-color: <?php echo esc_attr($profile->banner_clr ?? '#007bff'); ?>;">
                <?php if (file_exists($cover_photo)) : ?>
                    <img src="<?php echo esc_url($img_url . 'wpr_cover_photo.png'); ?>" alt="Cover Photo" class="wpr-cover-photo-img">
                <?php else : ?>
                    <div class="wpr-cover-initial">
                        <span class="wpr-cover-initial-text"><?php echo esc_html($first_letter); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="wpr-user-info">
                <div class="wpr-profile-photo">
                    <?php if (file_exists($profile_photo)) : ?>
                        <img src="<?php echo esc_url($img_url . 'wpr_profile_photo.png'); ?>" alt="Profile Photo" class="wpr-profile-img">
                    <?php else : ?>
                        <span class="wpr-initial"><?php echo esc_html($first_letter); ?></span>
                    <?php endif; ?>
                </div>
                <h2 class="wpr-username"><?php echo esc_html($profile->user->display_name); ?></h2>
            </div>
            
            <?php if (is_user_logged_in()) : ?>
                <div class="wpr-account-options">
                    <a href="<?php echo esc_url(WPRLOGIN()->wpr_get_core_page_for_redirect('account')); ?>" class="wpr-account-link"><?php _e('My Account', 'wp-registration'); ?></a>
                    <a href="<?php echo esc_url(wp_logout_url()); ?>" class="wpr-logout-link"><?php _e('Logout', 'wp-registration'); ?></a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <section class="wpr-profile-body">
        <div class="tab-content wpr-tab">
            <?php foreach ($tab_control as $tab_id => $tab_val) : ?>
                <div id="<?php echo esc_attr($tab_id); ?>" class="tab-pane fade">
                    <?php wpr_load_templates($tab_val['template'], $template_vars); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>
