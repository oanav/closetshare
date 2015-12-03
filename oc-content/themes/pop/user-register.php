<?php
    include 'frm.class/PopUserForm.php';
    // meta tag robots
    osc_add_hook('header','pop_nofollow_construct');

    pop_add_body_class('register');
    osc_enqueue_script('jquery-validate');
    osc_enqueue_script('jquery-metadata');
    osc_current_web_theme_path('header.php') ;
?>

<div class="form-container box">
    <div class="header">
        <h1><?php _e('Register', 'pop'); ?></h1>
    </div>
    <div class="form-content form-horizontal">
        <form name="register" action="<?php echo osc_base_url(true); ?>" method="post" >
            <input type="hidden" name="page" value="register" />
            <input type="hidden" name="action" value="register_post" />
            <ul id="error_list"></ul>
            <div class="control-group">
                <label class="control-label" for="name"><?php _e('Name', 'pop'); ?></label>
                <div class="controls">
                    <?php UserForm::name_text(); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="email"><?php _e('E-mail', 'pop'); ?></label>
                <div class="controls">
                    <?php UserForm::email_text(); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="password"><?php _e('Password', 'pop'); ?></label>
                <div class="controls">
                    <?php UserForm::password_text(); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="password-2"><?php _e('Repeat password', 'pop'); ?></label>
                <div class="controls">
                    <?php UserForm::check_password_text(); ?>
                    <p id="password-error" style="display:none;">
                        <?php _e("Passwords don't match", 'pop'); ?>
                    </p>
                </div>
            </div>
            <?php if(count(osc_get_countries())>1) { ?>
            <div class="control-group">
                <label class="control-label" for=""><?php _e('Country', 'pop'); ?></label>
                <div class="controls">
                    <?php UserForm::country_select(osc_get_countries()); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="regionId"><?php _e('Region', 'pop'); ?></label>
                <div class="controls">
                    <?php UserForm::region_select(array()); ?>
                </div>
            </div>
            <?php } else {
                $aCountries = osc_get_countries();
                $aRegions = osc_get_regions($aCountries[0]['pk_c_code']);
                ?>
            <input type="hidden" id="countryId" name="countryId" value="<?php echo osc_esc_html($aCountries[0]['pk_c_code']); ?>"/>
            <div class="control-group">
                <label class="control-label" for="regionId"><?php _e('Region', 'pop'); ?></label>
                <div class="controls">
                    <?php UserForm::region_select($aRegions); ?>
                </div>
            </div>
            <?php } ?>
            <div class="control-group">
                <label class="control-label" for="cityId"><?php _e('City', 'pop'); ?></label>
                <div class="controls">
                    <?php UserForm::city_select(array()); ?>
                </div>
            </div>
            <?php osc_run_hook('user_register_form'); ?>
            <div class="control-group">
                <div class="controls">
                    <?php if (osc_recaptcha_public_key()) { ?>
                        <script type="text/javascript">
                            var RecaptchaOptions = {
                                theme: 'custom',
                                custom_theme_widget: 'recaptcha_widget'
                            };
                        </script>
                        <style type="text/css"> div#recaptcha_widget, div#recaptcha_image > img { width:280px; } </style>
                        <div id="recaptcha_widget">
                            <div id="recaptcha_image"><img /></div>
                            <span class="recaptcha_only_if_image"><?php _e('Enter the words above', 'pop'); ?>:</span>
                            <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
                        </div>
                    <?php } ?>
                    <?php osc_show_recaptcha('register'); ?>
                </div>
            </div>
            <div class="control-group">
                <div class="center">
                    <button type="submit" class="btn-primary"><?php _e("Create account", 'pop'); ?></button>
                     <div id="facebook-login">
                 <?php fbc_button(); ?>
                </div>
                </div>

            </div>
        </form>
    </div>
</div>
<?php PopUserForm::location_javascript(); ?>
<?php UserForm::js_validation(); ?>
<?php if(count(osc_get_countries())==1) { ?>
<script type="text/javascript">
    $(document).ready(function() {

        $('select[id="countryId"]').addClass("{required: true, messages: { required: '<?php _e("Country is required", "pop"); ?>'}}") ;
        $('select[id="regionId"]').addClass("{required: true, messages: { required: '<?php _e("Region is required", "pop"); ?>'}}") ;
        $('select[id="cityId"]').addClass("{required: true, messages: { required: '<?php _e("City is required", "pop"); ?>'}}") ;

        $(document).on('DOMNodeInserted', function(e) {
            if (e.target.id == 'cityId') {
               $('select[id="cityId"]').addClass("{required: true, messages: { required: '<?php _e("City is required", "pop"); ?>'}}") ;
            }
            if (e.target.id == 'regionId') {
                $('select[id="regionId"]').addClass("{required: true, messages: { required: '<?php _e("Region is required", "pop"); ?>'}}") ;
            }
        });
    });
</script>
<?php } ?>
<?php osc_current_web_theme_path('footer.php') ; ?>