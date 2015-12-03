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
    if( osc_item_is_spam() || osc_premium_is_spam() ) {
        osc_add_hook('header','osclasswizards_nofollow_construct');
    } else {
        osc_add_hook('header','osclasswizards_follow_construct');
    }
    osc_enqueue_script('fancybox');
    osc_enqueue_style('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.css'));
    osc_enqueue_script('jquery-validate');
    osclasswizards_add_body_class('item');
    
    
    //osc_add_hook('after-main','sidebar');
    
    if(osclasswizards_show_as() == 'gallery'){
        $loop_template	=	'loop-search-grid.php';
        $buttonClass = 'active';
    }else{
        $loop_template	=	'loop-search-list.php';
        $buttonClass = '';
    }
    
    function sidebar(){
        osc_current_web_theme_path('item-sidebar.php');
    }
    
    
    osc_current_web_theme_path('header.php');
    
?>
<div class="row">
    <div class="col-sm-6 col-md-7">
        <div id="item-content">

            <?php if( osc_images_enabled_at_items() ) { ?>
            <?php
                if( osc_count_item_resources() > 0 ) {
                    $i = 0;
            ?>
            <div class="item-photos">
                <a href="<?php echo osc_resource_url(); ?>" class="main-photo" title="<?php _e('Image', 'osclasswizards'); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>"> <img src="<?php echo osc_resource_url(); ?>" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" /> </a>
                <div class="thumbs">
                    <?php for ( $i = 0; osc_has_item_resources() ; $i++ ) { ?>
                    <a href="<?php echo osc_resource_url(); ?>" class="fancybox" data-fancybox-group="group" title="<?php _e('Image', 'osclasswizards'); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>"> <img src="<?php echo osc_resource_thumbnail_url(); ?>" width="75" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" class="img-responsive" /> </a>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            <?php } ?>

            <?php osc_run_hook('location'); ?>

            <!-- plugins -->
        </div>

        <!--<h2 class="title"><?php _e("Contact seller", 'osclasswizards'); ?></h2>-->
        <div id="contact" class="widget-box form-container form-vertical" title="<?php _e("Contact seller", 'osclasswizards'); ?>">
            <?php if( osc_item_is_expired () ) { ?>
            <p>
                <?php _e("The listing is expired. You can't contact the publisher.", 'osclasswizards'); ?>
            </p>
            <?php } else if( ( osc_logged_user_id() == osc_item_user_id() ) && osc_logged_user_id() != 0 ) { ?>
            <p>
                <?php _e("It's your own listing, you can't contact the publisher.", 'osclasswizards'); ?>
            </p>
            <?php } else if( osc_reg_user_can_contact() && !osc_is_web_user_logged_in() ) { ?>
            <p>
                <?php _e("You must log in or register a new account in order to contact the advertiser", 'osclasswizards'); ?>
            </p>
            <p class="contact_button">
                <strong><a href="<?php echo osc_user_login_url(); ?>"><?php _e('Log in', 'osclasswizards'); ?></a></strong>
                <strong><a href="<?php echo osc_register_account_url(); ?>"><?php _e('Register for a free account', 'osclasswizards'); ?></a></strong>
            </p>
            <?php } else { ?>
            <div class="user-info">
                <?php if( osc_item_user_id() != null ) { ?>
                <div class="name"><?php _e('Name', 'osclasswizards') ?>: <a href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>"><?php echo osc_item_contact_name(); ?></a></div>
                <?php } else { ?>
                <div class="name"><?php printf(__('Name: %s', 'osclasswizards'), osc_item_contact_name()); ?></div>
                <?php } ?>
                <?php if( osc_item_show_email() ) { ?>
                <div class="email"><?php printf(__('E-mail: %s', 'osclasswizards'), osc_item_contact_email()); ?></div>
                <?php } ?>
                <?php if ( osc_user_phone() != '' ) { ?>
                <div class="phone"><?php printf(__("Phone: %s", 'osclasswizards'), osc_user_phone()); ?></div>
                <?php } ?>
            </div>
            <ul id="error_list"></ul>
            <form action="<?php echo osc_base_url(true); ?>" method="post" name="contact_form" id="contact_form" <?php if(osc_item_attachment()) { echo 'enctype="multipart/form-data"'; };?>>
                <?php osc_prepare_user_info(); ?>
                <input type="hidden" name="action" value="contact_post" />
                <input type="hidden" name="page" value="item" />
                <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="control-label" for="yourName"><?php _e('Your name', 'osclasswizards'); ?>:</label>
                        <div class="controls"><?php ContactForm::your_name(); ?></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="yourEmail"><?php _e('Your e-mail address', 'osclasswizards'); ?>:</label>
                        <div class="controls"><?php ContactForm::your_email(); ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="control-label" for="phoneNumber"><?php _e('Phone number', 'osclasswizards'); ?> (<?php _e('optional', 'osclasswizards'); ?>):</label>
                        <div class="controls"><?php ContactForm::your_phone_number(); ?></div>
                    </div>
                    <div class="form-group col-md-6"></div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="message"><?php _e('Message', 'osclasswizards'); ?>:</label>
                    <div class="controls textarea"><?php ContactForm::your_message(); ?></div>
                </div>
                <?php if(osc_item_attachment()) { ?>
                <div class="form-group">
                    <label class="control-label" for="attachment"><?php _e('Attachment', 'osclasswizards'); ?>:</label>
                    <div class="controls"><?php ContactForm::your_attachment(); ?></div>
                </div>
                <?php }; ?>
                <div class="form-group">
                    <div class="controls">
                        <?php osc_run_hook('item_contact_form', osc_item_id()); ?>
                        <?php if( osc_recaptcha_public_key() ) { ?>
                        <script type="text/javascript">
                            var RecaptchaOptions = {
                                theme : 'custom',
                                custom_theme_widget: 'recaptcha_widget'
                            };
                        </script>
                        <style type="text/css">
                            div#recaptcha_widget, div#recaptcha_image > img { width:280px; }
                        </style>
                        <div id="recaptcha_widget">
                            <div id="recaptcha_image"><img /></div>
                            <span class="recaptcha_only_if_image"><?php _e('Enter the words above','osclasswizards'); ?>:</span>
                            <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
                            <div><a href="javascript:Recaptcha.showhelp()"><?php _e('Help', 'osclasswizards'); ?></a></div>
                        </div>
                        <?php } ?>
                        <?php osc_show_recaptcha(); ?>
                        <button type="submit" class="btn btn-success"><?php _e("Send message", 'osclasswizards');?></button>
                    </div>
                </div>
            </form>
            <?php ContactForm::js_validation(); ?>
            <?php } ?>
        </div>

        <?php if( osc_comments_enabled() ) { ?>
        <?php if( osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments() ) { ?>
        <div id="comments">
            <?php if( osc_count_item_comments() >= 1 ) { ?>
            <h2 class="title">
                <?php _e('Comments', 'osclasswizards'); ?>
            </h2>
            <?php
                }
                
            ?>
            <ul id="comment_error_list">
            </ul>
            <?php CommentForm::js_validation(); ?>
            <?php if( osc_count_item_comments() >= 1 ) { ?>
            <div class="comments_list">
                <?php while ( osc_has_item_comments() ) { ?>
                <div class="comment">
                    <h4><?php echo osc_comment_title(); ?> <em>
                            <?php _e("by", 'osclasswizards'); ?>
                            <?php echo osc_comment_author_name(); ?>:</em></h4>
                    <p><?php echo nl2br( osc_comment_body() ); ?> </p>
                    <?php if ( osc_comment_user_id() && (osc_comment_user_id() == osc_logged_user_id()) ) { ?>
                    <p> <a rel="nofollow" href="<?php echo osc_delete_comment_url(); ?>" title="<?php _e('Delete your comment', 'osclasswizards'); ?>">
                            <?php _e('Delete', 'osclasswizards'); ?>
                        </a> </p>
                    <?php } ?>
                </div>
                <?php } ?>
                <div class="pagination">
                    <?php echo osc_comments_pagination(); ?>
                </div>
            </div>
            <?php } ?>
            <div class="comment_form">
                <h2 class="title">
                    <?php _e('Leave your comment', 'osclasswizards'); ?>
                </h2>
                <div class="resp-wrapper">
                    <form action="<?php echo osc_base_url(true); ?>" method="post" name="comment_form" id="comment_form">
                        <fieldset>
                            <input type="hidden" name="action" value="add_comment" />
                            <input type="hidden" name="page" value="item" />
                            <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                            <?php if(osc_is_web_user_logged_in()) { ?>
                            <input type="hidden" name="authorName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
                            <input type="hidden" name="authorEmail" value="<?php echo osc_logged_user_email();?>" />
                            <?php } else { ?>
                            <div class="form-group col-md-6">
                                <label class="control-label" for="authorName">
                                    <?php _e('Your name', 'osclasswizards'); ?>
                                </label>
                                <div class="controls">
                                    <?php CommentForm::author_input_text(); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label" for="authorEmail">
                                    <?php _e('Your e-mail', 'osclasswizards'); ?>
                                </label>
                                <div class="controls">
                                    <?php CommentForm::email_input_text(); ?>
                                </div>
                            </div>
                            <?php }; ?>

                            <div class="form-group col-md-12">
                                <label class="control-label" for="body">
                                    <?php _e('Comment', 'osclasswizards'); ?>
                                </label>
                                <div class="controls textarea">
                                    <?php CommentForm::body_input_textarea(); ?>
                                </div>
                            </div>
                            <div class="actions col-md-12">
                                <button type="submit" class="btn btn-success">
                                    <?php _e('Send', 'osclasswizards'); ?>
                                </button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php } ?>

        <?php related_listings(); ?>
        <?php if( osc_count_items() > 0 ) { ?>
        <div class="similar_ads">
            <h2 class="title">
                <?php _e('Related items', 'osclasswizards'); ?>
            </h2>
            <?php
                View::newInstance()->_exportVariableToView("listType", 'items');
                osc_current_web_theme_path('loop-grid.php');
            ?>
        </div>
        <?php } ?>
    </div>
    <div class="col-sm-6 col-md-5">
        <?php
            osc_current_web_theme_path('item-sidebar.php');
        ?>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>
