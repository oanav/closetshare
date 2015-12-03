<?php
// meta tag robots
osc_add_hook('header', 'pop_nofollow_construct');

pop_add_body_class('user user-profile');
osc_add_filter('meta_title_filter', 'custom_meta_title');

function custom_meta_title($data) {
    return __('Update account', 'pop');
}

osc_current_web_theme_path('header.php');
$osc_user = osc_user();
?>

<div class="container">
    <?php osc_current_web_theme_path('user-sidebar.php'); ?>
    <div class="user-content box col-sm-8 col-md-9">
        <div class="header">
            <h1><?php _e('Update account', 'pop'); ?></h1>
        </div>
        <?php UserForm::location_javascript(); ?>
        <div class="form-container form-horizontal">
            <div class="resp-wrapper">
                <ul id="error_list"></ul>
                <form action="<?php echo osc_base_url(true); ?>" method="post">
                    <input type="hidden" name="page" value="user" />
                    <input type="hidden" name="action" value="profile_post" />
                    <div class="control-group">
                        <label class="control-label" for="name"><?php _e('Name', 'pop'); ?></label>
                        <div class="controls">
                            <?php UserForm::name_text(osc_user()); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="user_type"><?php _e('User type', 'pop'); ?></label>
                        <div class="controls">
                            <?php UserForm::is_company_select(osc_user()); ?>
                        </div>
                    </div>

                    <!--   <div class="control-group">
                    <label class="control-label" for="phoneMobile"><?php _e('Cell phone', 'pop'); ?></label>
                    <div class="controls">
<?php UserForm::mobile_text(osc_user()); ?>
                    </div>
                </div> -->
                    <div class="control-group">
                        <label class="control-label" for="phoneLand"><?php _e('Phone', 'pop'); ?></label>
                        <div class="controls">
                            <?php UserForm::phone_land_text(osc_user()); ?>
                        </div>
                    </div>
                    <?php if(count(osc_get_countries()) > 1) { ?>
                    <div class="control-group">
                        <label class="control-label" for=""><?php _e('Country', 'pop'); ?></label>
                        <div class="controls">
                            <?php UserForm::country_select(osc_get_countries(), osc_user()); //array('fk_c_country_code' => osc_user_field('fk_c_country_code'))); ?>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="control-group">
                        <label class="control-label" for="region"><?php _e('Region', 'pop'); ?></label>
                        <div class="controls">
                            <?php UserForm::region_select(osc_get_regions(), osc_user()); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="city"><?php _e('City', 'pop'); ?></label>
                        <div class="controls">
                            <?php UserForm::city_select(osc_get_cities(), osc_user()); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="city_area"><?php _e('City area', 'pop'); ?></label>
                        <div class="controls">
                            <?php UserForm::city_area_text(osc_user()); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" l for="address"><?php _e('Address', 'pop'); ?></label>
                        <div class="controls">
                            <?php UserForm::address_text(osc_user()); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="webSite"><?php _e('Website', 'pop'); ?></label>
                        <div class="controls">
                            <?php UserForm::website_text(osc_user()); ?>
                        </div>
                    </div>
                    <!--     <div class="control-group">
                        <label class="control-label" for="s_info">////<?php _e('Description', 'pop'); ?></label>
                        <div class="controls">
                            <?php UserForm::info_textarea('s_info', osc_locale_code(), @$osc_user['locale'][osc_locale_code()]['s_info']); ?>
                        </div>
                    </div>-->
                    <?php osc_run_hook('user_profile_form', osc_user()); ?>
                    <div class="control-group text-center">
                        <div class="controls">
                            <button type="submit" class="btn-black"><?php _e("Update", 'pop'); ?></button>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <?php osc_run_hook('user_form', osc_user()); ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php'); ?>