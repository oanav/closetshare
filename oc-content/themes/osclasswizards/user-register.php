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

    osclasswizards_add_body_class('register');
    osc_enqueue_script('jquery-validate');
    osc_current_web_theme_path('header.php') ;
?>

<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <div class="wraps">
    <div class="title">
      <h1>
        <?php _e('Register an account for free', 'osclasswizards'); ?>
      </h1>
    </div>
      <form name="register" action="<?php echo osc_base_url(true); ?>" method="post" >
        <input type="hidden" name="page" value="register" />
        <input type="hidden" name="action" value="register_post" />
        <ul id="error_list">
        </ul>
        <div class="form-group">
          <label class="control-label" for="name">
            <?php _e('Name', 'osclasswizards'); ?> <sup>*</sup>
          </label>
          <div class="controls">
            <?php UserForm::name_text(); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label" for="email">
            <?php _e('E-mail', 'osclasswizards'); ?> <sup>*</sup>
          </label>
          <div class="controls">
            <?php UserForm::email_text(); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label" for="password">
            <?php _e('Password', 'osclasswizards'); ?> <sup>*</sup>
          </label>
          <div class="controls">
            <?php UserForm::password_text(); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label" for="password-2">
            <?php _e('Repeat password', 'osclasswizards'); ?> <sup>*</sup>
          </label>
          <div class="controls">
            <?php UserForm::check_password_text(); ?>
            <p id="password-error" style="display:none;">
              <?php _e("Passwords don't match", 'osclasswizards'); ?>
            </p>
          </div>
        </div>
        <?php osc_run_hook('user_register_form'); ?>
        <div class="form-group">
          <div class="controls">
            <?php osc_show_recaptcha('register'); ?>
          </div>
        </div>
        <div class="form-group">
          <div class="controls">
            <button type="submit" class="btn btn-success">
            <?php _e("Create An Account", 'osclasswizards'); ?>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  </div>
<?php UserForm::js_validation(); ?>
<?php osc_current_web_theme_path('footer.php') ; ?>
