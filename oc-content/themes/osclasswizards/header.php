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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
<?php osc_current_web_theme_path('common/head.php') ; ?>
</head>
<body <?php osclasswizards_body_class(); ?>>
<div id="header">
  <header>
    
    
    <!--top link-->
    
    <div class="top_links">
      <div class="container">   
   
        <ul>
          <?php if( osc_is_static_page() || osc_is_contact_page() ){ ?>
          <li class="search"><a class="ico-search icons" data-bclass-toggle="display-search"></a></li>
          <li class="cat"><a class="ico-menu icons" data-bclass-toggle="display-cat"></a></li>
          <?php } ?>
          <?php if( osc_users_enabled() ) { ?>
          <?php if( osc_is_web_user_logged_in() ) { ?>
          <li class="first logged"> <span><?php echo sprintf(__('Hi %s', 'osclasswizards'), osc_logged_user_name() . '!'); ?> </span> <strong><a href="<?php echo osc_user_dashboard_url(); ?>">
            | <?php _e('My account', 'osclasswizards'); ?>
            </a></strong> <a href="<?php echo osc_user_logout_url(); ?>">
            | <?php _e('Log out', 'osclasswizards'); ?>
            </a> </li>
          <?php } else { ?>
          <li><a id="login_open" href="<?php echo osc_user_login_url(); ?>">
            <?php _e('Log in', 'osclasswizards') ; ?>
            </a></li>
          <?php if(osc_user_registration_enabled()) { ?>
          <li><a href="<?php echo osc_register_account_url() ; ?>">
            <?php _e('Register', 'osclasswizards'); ?>
            </a></li>
          <?php }; ?>
          <?php } ?>
          <?php } ?>
        </ul>
      </div>
    </div>
    <?php if( osc_get_preference('header-728x90', 'osclasswizards_theme') !=""){ ?>
    <!-- header ad 728x60-->
    <div class="ads_header"> <?php echo osc_get_preference('header-728x90', 'osclasswizards_theme'); ?> 
      <!-- /header ad 728x60--> 
    </div>
    <?php } ?>
    <!--main header-->
    
    <div class="main_header">
      <div class="container">
        <div id="logo"> <?php echo logo_header(); ?> <span id="description"><?php echo osc_page_description(); ?></span> </div>
        <h2 class="pull-right toggle"><i class="fa fa-align-justify"></i></h2>
        <ul class="links">
          <?php
        osc_reset_static_pages();
        while( osc_has_static_pages() ) { ?>
          <li> <a href="<?php echo osc_static_page_url(); ?>"><?php echo osc_static_page_title(); ?></a> </li>
          <?php
        }
		osc_reset_static_pages();
        ?>

        </ul>
        <div class="publish">
          <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
          <a class="btn btn-success" href="<?php echo osc_item_post_url_in_category() ; ?>">
          <?php _e("Publish your ad for free", 'osclasswizards');?>
          </a>
          <?php } ?>
        </div>
      </div>
    </div>

    <div class="container"> </div>
    <?php osc_show_widgets('header'); ?>
  </header>
</div>
<?php osc_run_hook('before-content'); ?>
<div class="wrapper" id="content">
        <?php 
	if(osc_is_home_page())
	{
		echo '<div id="header_map">';
		if(homepage_image()) { 
			echo homepage_image(); 
		} else {
		?>
    <img src="<?php echo osc_current_web_theme_url('images/map.jpg') ; ?>" />
    <?php 
		} 
		echo '</div>';
	}
	?>
    <?php if( osc_is_home_page() ) { ?>
    <form action="<?php echo osc_base_url(true); ?>" id="main_search" method="get" class="search nocsrf" <?php /* onsubmit="javascript:return doSearch();"*/ ?>>
      <div class="container">
        <input type="hidden" name="page" value="search"/>
        <div class="main-search">
          <div class="row">
            <div class="col-md-4">
              <div class="cell">
                <input type="text" name="sPattern" id="query" class="input-text" value="" placeholder="<?php echo osc_esc_html(__(osc_get_preference('keyword_placeholder', 'osclasswizards_theme'), 'osclasswizards')); ?>" />
              </div>
            </div>
            <div class="col-md-3">
              <?php  if ( osc_count_categories() ) { ?>
              <div class="cell selector">
                <?php osc_categories_select('sCategory', null, __('Select a category', 'osclasswizards')) ; ?>
              </div>
            </div>
            <div class="col-md-3">
              <div class="cell selector">
                <?php osclasswizards_regions_select('sRegion', 'sRegion', __('Select a region', 'osclasswizards')) ; ?>
              </div>
            </div>
            <div class="col-md-2">
              <div class="cell reset-padding">
                <?php  } else { ?>
                <div class="cell">
                  <?php  } ?>
                  <button  class="btn btn-success btn_search">
                  <?php _e("Search", 'osclasswizards');?>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div id="message-seach"></div>
        </div>
      </div>
    </form>
    <?php } ?>

    <div class="wrapper-flash">
  <?php
        $breadcrumb = osc_breadcrumb('&raquo;', false, get_breadcrumb_lang());
        if( $breadcrumb !== '') { ?>
  <div class="breadcrumb">
    <div class="container"> <?php echo $breadcrumb; ?> </div>
  </div>
           <?php
        }
    ?>
    <div class="error_list">
   
      <?php osc_show_flash_message(); ?>
    </div>
</div>

<div class="container">
<div id="main">
