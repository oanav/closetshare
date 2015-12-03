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
?>

<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('admin/css/jquery.switchButton.css');?>">
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('admin/css/admin.main.css');?>">
<script src="<?php echo osc_current_web_theme_url('admin/js/jquery.switchButton.js');?>"></script>	
<script>
  $(function() {
    $( "#tabs" ).tabs();
	$("input[type=checkbox]").switchButton();	
  });
</script>
<div class="credit-osclasswizards">
<div class="follow">

<ul>
<li>Follow us:</li>
<li><a href="https://www.facebook.com/osclasswizards" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a></li>
<li><a href="https://twitter.com/osclasswizards" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a></li>
<li><a href="https://plus.google.com/112391938966018193484" target="_blank" title="google plus"><i class="fa fa-google-plus"></i></a></li>
</ul>
</div>
<div class="donate">
<form name="_xclick" action="https://www.paypal.com/in/cgi-bin/webscr" method="post" class="nocsrf">
    <input type="hidden" name="cmd" value="_donations">
    <input type="hidden" name="business" value="webgig.sagar@gmail.com">
    <input type="hidden" name="item_name" value="OsclassWizards Theme">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="lc" value="US" />
    <div id="flashmessage" >
        <p><select name="amount" class="select-box-medium">
            <option value="10" selected>10$</option>
            <option value="5">5$</option>
            <option value=""><?php _e('Custom', 'osclasswizards'); ?></option>
        </select><input type="submit" class="btn btn-mini" name="submit" value="<?php echo osc_esc_html(__('Donate', 'osclasswizards')); ?>"></p>
    </div>
</form>
</div>
</div>
<div id="tabs">
<ul>
    <li><a href="#general">General</a></li>
    <li><a href="#ads">Ads Management</a></li>
    <li><a href="#logo">Header Logo</a></li>
    <li><a href="#favicon">Favicon</a></li>
    <li><a href="#banner">Banner</a></li>
</ul>
<div id="general">
<h2 class="render-title"><?php _e('Theme settings', 'osclasswizards'); ?></h2>
<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/osclasswizards/admin/settings.php'); ?>" method="post" class="nocsrf">
    <input type="hidden" name="action_specific" value="settings" />
    <fieldset>
        <div class="form-horizontal">
		    <div class="form-row">
                <div class="form-label"><?php _e('Welcome message', 'osclasswizards'); ?></div>
                   <div class="form-controls">
				    <textarea style="height: 50px; width: 500px;" name="welcome_message"><?php echo osc_esc_html( osc_get_preference('welcome_message', 'osclasswizards_theme') ); ?></textarea>
				   </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Search placeholder', 'osclasswizards'); ?></div>
                <div class="form-controls"><input type="text" class="xlarge" name="keyword_placeholder" value="<?php echo osc_esc_html( osc_get_preference('keyword_placeholder', 'osclasswizards_theme') ); ?>"></div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Show lists as:', 'osclasswizards'); ?></div>
                <div class="form-controls">
                    <select name="defaultShowAs@all">
                        <option value="gallery" <?php if(osc_esc_html(osclasswizards_default_show_as()) == "gallery"){ echo "selected=selected"; } ?>><?php _e('Grid','osclasswizards'); ?></option>
                        <option value="list" <?php if(osc_esc_html(osclasswizards_default_show_as()) == "list"){ echo "selected=selected"; } ?>><?php _e('List','osclasswizards'); ?></option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('RTL view', 'osclasswizards'); ?></div>
                <div class="form-controls">
					<div class="form-label-checkbox">
						<input type="checkbox" name="rtl_view" value="1" <?php echo (osc_esc_html( osc_get_preference('rtl_view', 'osclasswizards_theme') ) == "1")? "checked": ""; ?>>
					</div>
				</div> 
			</div>
			</div>
    </fieldset>

	<div class="form-actions">
		<input type="submit" value="<?php _e('Save changes', 'osclasswizards'); ?>" class="btn btn-submit">
	</div>
</form>
</div>

<div id="ads"><?php include 'ads.php'; ?></div>

<div id="logo"><?php include 'header.php'; ?></div>

<div id="favicon"><?php include 'favicon.php'; ?></div>

<div id="banner"><?php include 'homeimage.php'; ?></div>

</div>