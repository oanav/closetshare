<?php

    // meta tag robots
    osc_add_hook('header','pop_nofollow_construct');

    pop_add_body_class('login');
    osc_current_web_theme_path('header.php');
?>
<div class="form-container box">
    <div class="header">
        <h1><?php _e('Access to your account', 'pop'); ?></h1>
    </div>
    <div class="form-content form-horizontal">
        <form action="<?php echo osc_base_url(true); ?>" method="post" >
            <input type="hidden" name="page" value="login" />
            <input type="hidden" name="action" value="login_post" />

            <div class="control-group">
                <label class="control-label" for="email"><?php _e('E-mail', 'pop'); ?></label>
                <div class="controls">
                    <?php UserForm::email_login_text(); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="password"><?php _e('Password', 'pop'); ?></label>
                <div class="controls">
                    <?php UserForm::password_login_text(); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php UserForm::rememberme_login_checkbox();?> <label for="remember"><?php _e('Remember me', 'pop'); ?></label>
                </div>
                </div>
            <div class="control-group login">
                <button type="submit" class="btn-primary"><?php _e("Log in", 'pop');?></button>
                <div id="facebook-login">
                 <?php fbc_button(); ?>
                </div>
            </div>
            <div class="control-group actions">
                <a class="register pull-left" href="<?php echo osc_register_account_url(); ?>"><?php _e("Create a new account", 'pop'); ?></a>
                <a class="pull-right" href="<?php echo osc_recover_user_password_url(); ?>"><?php _e("Forgot password?", 'pop'); ?></a>
            </div>
        </form>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>