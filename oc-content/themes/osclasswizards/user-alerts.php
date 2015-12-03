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

    osclasswizards_add_body_class('user user-alerts');
    osc_add_hook('before-main','sidebar');
    function sidebar(){
        osc_current_web_theme_path('user-sidebar.php');
    }
    osc_add_filter('meta_title_filter','custom_meta_title');
    function custom_meta_title($data){
        return __('Alerts', 'osclasswizards');;
    }
	
	if(osclasswizards_show_as() == 'gallery'){
        $loop_template	=	'loop-user-grid.php';
    }else{
		$loop_template	=	'loop-user-list.php';
	}
	
    osc_current_web_theme_path('header.php') ;
    $osc_user = osc_user();
?>

<div class="row">
  <?php
	        osc_current_web_theme_path('user-sidebar.php');

   ?>
  <div class="col-sm-8 col-md-9">
    <h1 class="title">
      <?php _e('Alerts', 'osclasswizards'); ?>
    </h1>
    <?php if(osc_count_alerts() == 0) { ?>
    <h3>
      <?php _e('You do not have any alerts yet', 'osclasswizards'); ?>
      .</h3>
    <?php } else { ?>
    <?php
    $i = 1;
    while(osc_has_alerts()) { ?>
    <div class="userItem" >
      <div class="alert_delete">
        <h3>
          <?php _e('Alert', 'osclasswizards'); ?>
          <?php echo $i; ?>
          <a class="alert_delete" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can\'t be undone. Are you sure you want to continue?', 'osclasswizardsw')); ?>');" href="<?php echo osc_user_unsubscribe_alert_url(); ?>">
        <?php _e('Delete this alert', 'osclasswizards'); ?>
        </a>
          
          </h3>
          
          
          
        
        
      </div>
      <div>
        <?php osc_current_web_theme_path($loop_template) ; ?>
        <?php if(osc_count_items() == 0) { ?>
        <br />
        0
        <?php _e('Listings', 'osclasswizards'); ?>
        <?php } ?>
      </div>
    </div>
    <br />
    <?php
    $i++;
    }
    ?>
    <?php  } ?>
  </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>
