<div id="contact" class="" title="<?php echo _e('Contact seller','pop') ?>">
    
    <?php if (osc_item_is_expired()) { ?>
        <p>
            <?php _e("The listing is expired. You can't contact the publisher.", 'pop'); ?>
        </p>
    <?php } else if (( osc_logged_user_id() == osc_item_user_id() ) && osc_logged_user_id() != 0) { ?>
        <p>
            <?php _e("It's your own listing, you can't contact the publisher.", 'pop'); ?>
        </p>
    <?php } else if (osc_reg_user_can_contact() && !osc_is_web_user_logged_in()) { ?>
        <p>
            <?php _e("You must log in or register a new account in order to contact the advertiser", 'pop'); ?>
        </p>
        <p class="contact_button">
            <strong><a href="<?php echo osc_user_login_url(); ?>"><?php _e('Login', 'pop'); ?></a></strong>
            <strong><a href="<?php echo osc_register_account_url(); ?>"><?php _e('Register for a free account', 'pop'); ?></a></strong>
        </p>
    <?php } else { ?>
       <!-- <?php if (osc_item_user_id() != null) { ?>
           

            <p class="name"><?php _e('Name', 'pop') ?>: <a href="<?php echo osc_user_public_profile_url(osc_item_user_id()); ?>" ><?php echo osc_item_contact_name(); ?></a></p>
        <?php } else { ?>
            <p class="name"><?php printf(__('Name: %s', 'pop'), osc_item_contact_name()); ?></p>
        <?php } ?>
        <?php if (osc_item_show_email()) { ?>
            <p class="email"><?php printf(__('E-mail: %s', 'pop'), osc_item_contact_email()); ?></p>
        <?php } ?>
        <?php if (osc_user_phone() != '') { ?>
            <p class="phone"><?php printf(__("Phone: %s", 'pop'), osc_user_phone()); ?></p>
        <?php } ?>-->
    <p class="text-center"><?php _e('Your message for','pop')?> 
        <b><?php echo osc_item_contact_name(); ?></b></p>
        <ul id="error_list"></ul>
        <form action="<?php echo osc_base_url(true); ?>" method="post" name="contact_form" class="form-horizontal" id="contact_form" <?php if(osc_item_attachment()) { echo 'enctype="multipart/form-data"'; };?>>
                <?php osc_prepare_user_info(); ?>
                <input type="hidden" name="action" value="contact_post" />
                <input type="hidden" name="page" value="item" />
                <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                    <div class="form-group">
                        <label class="control-label " for="yourName"><?php _e('Name', 'pop'); ?>:</label>
                        <div class="controls"><?php ContactForm::your_name(); ?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label " for="yourEmail"><?php _e('E-mail', 'pop'); ?>:</label>
                        <div class="controls"><?php ContactForm::your_email(); ?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label " for="phoneNumber"><?php _e('Phone', 'pop'); ?> (<?php _e('optional', 'pop'); ?>):</label>
                        <div class="controls"><?php ContactForm::your_phone_number(); ?></div>
                    </div>
                <div class="form-group ">
                    <label class="control-label " for="message"><?php _e('Message', 'pop'); ?>:</label>
                    <div class="controls textarea"><?php ContactForm::your_message(); ?></div>
                </div>
                <?php if(osc_item_attachment()) { ?>
                <div class="form-group ">
                    <label class="control-label " for="attachment"><?php _e('Attachment', 'pop'); ?>:</label>
                    <div class="controls"><?php ContactForm::your_attachment(); ?></div>
                </div>
                <?php }; ?>
                <div class="form-group ">
                   
                    <div class="control-label">&nbsp;</div>
                    <div class="controls">
                        <?php osc_run_hook('item_contact_form', osc_item_id()); ?>
                       
                        <button type="submit" class="btn btn-primary"><?php _e("Send message", 'pop');?></button>
                    </div>
                </div>
            </form>
    <?php ContactForm::js_validation(); ?>
<?php } ?>
</div>