<?php
    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2014 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */
    // meta tag robots
    osc_add_hook('header','osclasswizards_nofollow_construct');
    osclasswizards_add_body_class('user user-profile');
    osc_add_hook('before-main','sidebar');
    function sidebar(){
        osc_current_web_theme_path('user-sidebar.php');
    }
    osc_add_filter('meta_title_filter','custom_meta_title');
    function custom_meta_title($data){
        return __('Update account', 'osclasswizards');
    }
    osc_current_web_theme_path('header.php') ;
    $osc_user = osc_user();
?>
<div class="row">
    <?php
        osc_current_web_theme_path('user-sidebar.php');
    ?>
    <div class="col-sm-8 col-md-9">
        <h1 class="title">
            <?php _e('Update account', 'osclasswizards'); ?>
        </h1>
        <?php UserForm::location_javascript(); ?>
        <div class="dashboard_form">
            <ul id="error_list">
            </ul>
            <form action="<?php echo osc_base_url(true); ?>" method="post">
                <input type="hidden" name="page" value="user" />
                <input type="hidden" name="action" value="profile_post" />
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="control-label" for="name">
                            <?php _e('Name', 'osclasswizards'); ?>
                        </label>
                        <div class="controls">
                            <?php UserForm::name_text(osc_user()); ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="phoneLand">
                            <?php _e('Phone', 'osclasswizards'); ?>
                        </label>
                        <div class="controls">
                            <?php UserForm::phone_land_text(osc_user()); ?>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="control-label" for="country">
                            <?php _e('Country', 'osclasswizards'); ?>
                        </label>
                        <div class="controls">
                            <?php UserForm::country_select(osc_get_countries(), osc_user()); ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="region">
                            <?php _e('Region', 'osclasswizards'); ?>
                        </label>
                        <div class="controls">
                            <?php UserForm::region_select(osc_get_regions(), osc_user()); ?>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="form-group  col-md-6">
                        <label class="control-label" for="city">
                            <?php _e('City', 'osclasswizards'); ?>
                        </label>
                        <div class="controls">
                            <?php UserForm::city_select(osc_get_cities(), osc_user()); ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="address">
                            <?php _e('Address', 'osclasswizards'); ?>
                        </label>
                        <div class="controls">
                            <?php UserForm::address_text(osc_user()); ?>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="control-label" for="s_info">
                            <?php _e('Description', 'osclasswizards'); ?>
                        </label>
                        <div class="controls">
                            <?php UserForm::info_textarea('s_info', osc_locale_code(), @$osc_user['locale'][osc_locale_code()]['s_info']); ?>
                        </div>
                    </div>
                </div>
                <?php osc_run_hook('user_profile_form', osc_user()); ?>
                <div class="form-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-success">
                            <?php _e("Update", 'osclasswizards');?>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <?php osc_run_hook('user_form', osc_user()); ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>
