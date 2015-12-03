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

    osclasswizards_add_body_class('contact');
	
	
    osc_enqueue_script('jquery-validate');
    osc_current_web_theme_path('header.php');
?>

<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <div class="wraps">
      <div class="title">
        <h1>
          <?php _e('Contact us', 'osclasswizards'); ?>
        </h1>
      </div>
      <div class="resp-wrapper">
        <ul id="error_list">
        </ul>
        <form name="contact_form" action="<?php echo osc_base_url(true); ?>" method="post" >
          <input type="hidden" name="page" value="contact" />
          <input type="hidden" name="action" value="contact_post" />
          <div class="form-group">
            <label class="control-label" for="yourName">
              <?php _e('Your name', 'osclasswizards'); ?>
              (
              <?php _e('optional', 'osclasswizards'); ?>
              )</label>
            <div class="controls">
              <?php ContactForm::your_name(); ?>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label" for="yourEmail">
              <?php _e('Your email address', 'osclasswizards'); ?>
            </label>
            <div class="controls">
              <?php ContactForm::your_email(); ?>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label" for="subject">
              <?php _e('Subject', 'osclasswizards'); ?>
              (
              <?php _e('optional', 'osclasswizards'); ?>
              )</label>
            <div class="controls">
              <?php ContactForm::the_subject(); ?>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label" for="message">
              <?php _e('Message', 'osclasswizards'); ?>
            </label>
            <div class="controls textarea">
              <?php ContactForm::your_message(); ?>
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
        <?php ContactForm::js_validation(); ?>
      </div>
    </div>
  </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>
