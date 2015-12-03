<?php
// meta tag robots
osc_add_hook('header', 'pop_nofollow_construct');

pop_add_body_class('user user-profile');
osc_add_filter('meta_title_filter', 'custom_meta_title');

function custom_meta_title($data) {
    return __('Change password', 'pop');
    ;
}

osc_current_web_theme_path('header.php');
$osc_user = osc_user();
?>
<div class="container">
    <?php osc_current_web_theme_path('user-sidebar.php'); ?>
    <div class="user-content box col-sm-8 col-md-9">
        <div class="header">
            <h1><?php _e('Change password', 'pop'); ?></h1>
        </div>
        <div class="form-container form-horizontal">
            <div class="resp-wrapper">
                <ul id="error_list"></ul>
                <form action="<?php echo osc_base_url(true); ?>" method="post">
                    <input type="hidden" name="page" value="user" />
                    <input type="hidden" name="action" value="change_password_post" />
                    <div class="control-group">
                        <label class="control-label" for="password"><?php _e('Current password', 'pop'); ?> *</label>
                        <div class="controls">
                            <input type="password" name="password" id="password" value="" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="new_password"><?php _e('New password', 'pop'); ?> *</label>
                        <div class="controls">
                            <input type="password" name="new_password" id="new_password" value="" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="new_password2"><?php _e('Repeat new password', 'pop'); ?> *</label>
                        <div class="controls">
                            <input type="password" name="new_password2" id="new_password2" value="" />
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls text-center">
                            <button type="submit" class="btn-black"><?php _e("Update", 'pop'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php'); ?>