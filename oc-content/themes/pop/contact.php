<?php
// meta tag robots
osc_add_hook('header', 'pop_nofollow_construct');

pop_add_body_class('contact');
osc_enqueue_script('jquery-validate');
osc_current_web_theme_path('header.php');
?>
<div class="form-container box">
    <div class="header">
        <h1><?php _e('Contact', 'pop'); ?></h1>
    </div>
    <div class="form-content">
        <ul id="error_list"></ul>
        <form class="form-horizontal" name="contact_form" action="<?php echo osc_base_url(true); ?>" method="post" >
            <input type="hidden" name="page" value="contact" />
            <input type="hidden" name="action" value="contact_post" />
            <div class="control-group">
                <label class="control-label" for="yourName">
                    <?php _e('Name', 'pop'); ?></label>
                <div class="controls">
                    <?php ContactForm::your_name(); ?></div>
            </div>
            <div class="control-group">
                <label class="control-label" for="yourEmail">
                    <?php _e('Email', 'pop'); ?></label>
                <div class="controls">
                    <?php ContactForm::your_email(); ?></div>
            </div>
            <div class="control-group">
                <label class="control-label" for="subject">
                    <?php _e('Subject', 'pop'); ?></label>
                <div class="controls">
                    <?php ContactForm::the_subject(); ?></div>
            </div>
            <div class="control-group">
                <label class="control-label" for="message">
                    <?php _e('Message', 'pop'); ?></label>
                <div class="controls textarea">
                    <?php ContactForm::your_message(); ?></div>
            </div>
            <div class="control-group">
                <div class="controls text-center">
                    <?php osc_run_hook('contact_form'); ?>

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
                    <button type="submit" class="btn-black"><?php _e("Send", 'pop'); ?></button>
                    <?php osc_run_hook('admin_contact_form'); ?>
                </div>
            </div>
        </form>
        <?php ContactForm::js_validation(); ?>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php'); ?>