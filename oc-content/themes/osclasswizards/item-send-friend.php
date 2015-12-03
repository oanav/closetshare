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

    osc_enqueue_script('jquery-validate');
    osclasswizards_add_body_class('contact');
    osc_current_web_theme_path('header.php');
?>

<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <div class="wraps">
      <div class="title">
        <h1>
          <?php _e('Send to a friend', 'osclasswizards'); ?>
        </h1>
      </div>
      <div class="resp-wrapper">
        <ul id="error_list">
        </ul>
        <form name="sendfriend" action="<?php echo osc_base_url(true); ?>" method="post" >
          <input type="hidden" name="action" value="send_friend_post" />
          <input type="hidden" name="page" value="item" />
          <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
          <?php if(osc_is_web_user_logged_in()) { ?>
          <input type="hidden" name="yourName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
          <input type="hidden" name="yourEmail" value="<?php echo osc_logged_user_email();?>" />
          <?php } else { ?>
          <div class="form-group">
            <label class="control-label" for="yourName">
              <?php _e("Your name",'osclasswizards'); ?>
            </label>
            <div class="controls ">
              <?php SendFriendForm::your_name(); ?>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label" for="yourEmail">
              <?php _e("Your e-mail",'osclasswizards'); ?>
            </label>
            <div class="controls ">
              <?php SendFriendForm::your_email(); ?>
            </div>
          </div>
          <?php } ?>
          <div class="form-group">
            <label class="control-label" for="friendName">
              <?php _e("Your friend's name",'osclasswizards'); ?>
            </label>
            <div class="controls">
              <?php SendFriendForm::friend_name(); ?>
            </div>
          </div>
          <div class="form-group">
            <label for="friendEmail">
              <?php _e("Your friend's e-mail address", 'osclasswizards'); ?>
            </label>
            </label>
            <div class="controls">
              <?php SendFriendForm::friend_email(); ?>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label" for="subject">
              <?php _e('Subject (optional)', 'osclasswizards'); ?>
            </label>
            <div class="controls">
              <?php ContactForm::the_subject(); ?>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label" for="message">
              <?php _e('Message', 'osclasswizards'); ?>
            </label>
            <div class="controls textarea">
              <?php SendFriendForm::your_message(); ?>
            </div>
          </div>
          <div class="form-group">
            <div class="controls">
              <?php osc_run_hook('contact_form'); ?>
              <?php osc_show_recaptcha(); ?>
              <button type="submit" class="btn btn-success">
              <?php _e("Send", 'osclasswizards');?>
              </button>
              <?php osc_run_hook('admin_contact_form'); ?>
            </div>
          </div>
        </form>
        <?php SendFriendForm::js_validation(); ?>
      </div>
    </div>
  </div>
</div>
<?php osc_current_web_theme_path('footer.php'); ?>
