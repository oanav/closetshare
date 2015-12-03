<?php
// meta tag robots
osc_add_hook('header', 'pop_nofollow_construct');

pop_add_body_class('recover');
osc_current_web_theme_path('header.php');
?>
<div class="form-container box">
    <div class="header">
        <h1><?php _e('Recover your password', 'pop'); ?></h1>
    </div>
    <div class="form-content">

        <form action="<?php echo osc_base_url(true); ?>" method="post" >
            <input type="hidden" name="page" value="login" />
            <input type="hidden" name="action" value="recover_post" />
            <div class="control-group">
                <label class="control-label" for="email"><?php _e('E-mail', 'pop'); ?></label>
                <div class="controls">
                    <?php UserForm::email_text(); ?>
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
                    <?php osc_show_recaptcha(); ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class=" btn-gray"><?php _e("Send me a new password", 'pop'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php'); ?>