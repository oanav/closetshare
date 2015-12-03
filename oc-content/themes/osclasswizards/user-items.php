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

    osclasswizards_add_body_class('user user-items');
	
	
    //osc_add_hook('before-main','sidebar');
	
    function sidebar(){
        osc_current_web_theme_path('user-sidebar.php');
    }
	
	
    osc_current_web_theme_path('header.php') ;
	
	if(osclasswizards_show_as() == 'gallery'){
        $loop_template	=	'loop-user-grid.php';
		$listClass = 'listing-grid';
        $buttonClass = 'active';
    }else{
		$loop_template	=	'loop-user-list.php';
		$listClass = '';
		$buttonClass = '';
	}

	?>

<div class="row">

  <?php
	        osc_current_web_theme_path('user-sidebar.php');

   ?>
  <div class="col-sm-8 col-md-9">
    <div class="list-header">
      <?php osc_run_hook('search_ads_listing_top'); ?>
      <h1 class="title">
        <?php _e('My listings', 'osclasswizards'); ?>
      </h1>
      <?php if(osc_count_items() == 0) { ?>
      <p class="empty" >
        <?php _e('No listings have been added yet', 'osclasswizards'); ?>
      </p>
      <?php } else { ?>
      
    </div>
    <?php
        View::newInstance()->_exportVariableToView("listClass",$listClass);
        View::newInstance()->_exportVariableToView("listAdmin", true);
        osc_current_web_theme_path($loop_template);
    ?>
    <?php
    if(osc_rewrite_enabled()){
        $footerLinks = osc_search_footer_links();
    ?>
    <ul class="footer-links">
      <?php foreach($footerLinks as $f) { View::newInstance()->_exportVariableToView('footer_link', $f); ?>
      <?php if($f['total'] < 3) continue; ?>
      <li><a href="<?php echo osc_footer_link_url(); ?>"><?php echo osc_footer_link_title(); ?></a></li>
      <?php } ?>
    </ul>
    <?php } ?>
    <div class="pagination"> <?php echo osc_pagination_items(); ?> </div>
    <?php } ?>
  </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>
