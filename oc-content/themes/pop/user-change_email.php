<?php
// meta tag robots
osc_add_hook('header', 'pop_nofollow_construct');

osc_enqueue_script('jquery-validate');
pop_add_body_class('user user-profile');

osc_add_filter('meta_title_filter', 'custom_meta_title');

function custom_meta_title($data) {
    return __('Change e-mail', 'pop');
    ;
}

osc_current_web_theme_path('header.php');
$osc_user = osc_user();
?>
<?php osc_current_web_theme_path('user-sidebar.php'); ?>
<div class="user-content box col-sm-8 col-md-9">
    <div class="header">
        <h1><?php _e('Change e-mail', 'pop'); ?></h1>
    </div>
    <div class="form-container form-horizontal">
        <div class="resp-wrapper">
            <ul id="error_list"></ul>
            <form id="change-email" action="<?php echo osc_base_url(true); ?>" method="post">
                <input type="hidden" name="page" value="user" />
                <input type="hidden" name="action" value="change_email_post" />
                <div class="control-group">
                    <label for="email"><?php _e('Current e-mail', 'pop'); ?></label>
                    <div class="controls">
<?php echo osc_logged_user_email(); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="new_email"><?php _e('New e-mail', 'pop'); ?> *</label>
                    <div class="controls">
                        <input type="text" name="new_email" id="new_email" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn-black"><?php _e("Update", 'pop'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('form#change-email').validate({
            rules: {
                new_email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                new_email: {
                    required: '<?php echo osc_esc_js(__("Email: this field is required", "pop")); ?>.',
                    email: '<?php echo osc_esc_js(__("Invalid email address", "pop")); ?>.'
                }
            },
            errorLabelContainer: "#error_list",
            wrapper: "li",
            invalidHandler: function (form, validator) {
                $('html,body').animate({scrollTop: $('h1').offset().top}, {duration: 250, easing: 'swing'});
            },
            submitHandler: function (form) {
                $('button[type=submit], input[type=submit]').attr('disabled', 'disabled');
                form.submit();
            }
        });
    });
</script>
<?php osc_current_web_theme_path('footer.php'); ?>