<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
    <?php osc_current_web_theme_path('head.php'); ?>
</head>
<body <?php pop_body_class(); ?>>

    <div class="navbar navbar-fixed-top" id="menu">
        <div class="top-header">
            <div class="container">
                <ul class="pull-left">
              
                     <li><a href="<?php echo osc_contact_url(); ?>"><?php _e('Contact', 'pop'); ?></a></li> 
<li><a href=""><?php _e('Help', 'pop'); ?></a></li>
                </ul>
                <ul class="pull-right">

                    <?php if (osc_is_web_user_logged_in()) { ?>
                    <?php

                              $user_id = OSCFacebook::newInstance()->getUser();
                              if ($user_id) {
                                  $user_picture_url = 'https://graph.facebook.com/'.$user_id.'/picture';
                              } else {
                                  $user_picture_url = osc_current_web_theme_url('images/user_default.gif');
                              }
                    ?>


                    <li class="">
                        <div id="dLabel" class="logo-user-menu dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <img class="user-avatar" src="<?php echo $user_picture_url ?>" />
                            <span class="name"><?php echo osc_logged_user_name(); ?></span>
                            <i class="fa fa-caret-down"></i>
                        </div>
                        <ul class="dropdown-menu user-menu" role="menu" aria-labelledby="dLabel">
                            <li>
                                <a href="<?php echo osc_user_list_items_url(); ?>"><?php _e('My listings', 'pop'); ?></a></li>
                            <li>
                                <a href="<?php echo osc_user_alerts_url(); ?>"><?php _e('Search watchlist', 'pop'); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo osc_render_file_url('watchlist/watchlist.php'); ?>"><?php _e('Watchlist', 'pop'); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo osc_user_profile_url(); ?>"><?php _e('Account settings', 'pop'); ?></a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo osc_user_logout_url(); ?>"><?php _e('Logout', 'pop'); ?></a>
                            </li>
                        </ul>

                    </li>
                    <?php } else { ?>
                    <li>

                        <a href="<?php echo osc_user_login_url(); ?>">
<i class="ionicons ion-person"></i>
<?php _e('New account', 'pop'); ?></a>
</li>
                    <li>

                        <a href="<?php echo osc_user_login_url(); ?>">
                        <i class="ionicons ion-locked"></i>
<?php _e('Login', 'pop'); ?></a>
</li>

                    <?php } ?>
                </ul>
            </div>

        </div>
        <div class=" header container">
            <div class="pull-left">
                    <?php echo logo_header(); ?>
                    <a href="#" class="custom-toggle hidden" id="toggle">
                        <s class="bar"></s><s class="bar"></s>
                    </a>
            </div>
               <div class="pure-menu pull-right">

                            <a href="<?php echo osc_item_post_url_in_category(); ?>" class="btn btn-primary">
<i class="ionicons ion-plus"></i>
<?php _e('Publish new listing', 'pop'); ?></a>


                </div>
            <div class="text-center">
                <div class="categories-dropdown">
                    <span class="fa fa-bars"></span>
                    <span><?php _e('Categories','pop') ?></span>
                    <ul>
                        <?php $i=0;
                              while(osc_has_categories()) { ?>
                        <li>
                            <a href="<?php echo osc_search_category_url()?>"><?php echo osc_category_name();?></a>
                            <?php if (osc_count_subcategories() > 0) { ?>
                            <ul>
                                <?php while (osc_has_subcategories()) { ?>
                                <li>
                                    <a href="<?php echo osc_search_category_url()?>"><?php echo osc_category_name();?></a>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                        <?php              $i++;
                              } ?>
                    </ul>
                </div>
                <div class="pure-menu">
                <form action="<?php echo osc_base_url(true); ?>" method="get" class="search search-header nocsrf" >
                    <input type="hidden" name="page" value="search" />
                    <input type="text" name="sPattern" id="query" class="input-text hidden-mobile" value="<?php echo osc_esc_html(Params::getParam('sPattern')); ?>" placeholder="<?php echo osc_esc_html(__(osc_get_preference('keyword_placeholder', 'pop_theme'), 'pop')); ?>" />
                    <i class="ionicons ion-search icon-search" title="<?php echo _e('Search', 'pop'); ?>"></i>
                </form>
                </div>
            </div>
             
        </div>
        <div class="subheader">
            <div class="container">
            </div>
        </div>
    </div>
    <div id="content">

        <div class="error_list">

            <?php osc_show_flash_message(); ?>
        </div>
        <?php
        $breadcrumb = osc_breadcrumb(' / ', false, get_breadcrumb_lang());
        if ($breadcrumb !== '') {
        ?>
        <div class="container">
            <?php echo $breadcrumb; ?>
            <div class="clear"></div>
        </div>
        <?php } ?>

        <?php if (!osc_is_public_profile()) { ?>
        <div class="container ads_header">
            <!-- header ad 728x60-->
            <?php echo osc_get_preference('header-728x90', 'pop_theme'); ?>
        </div>
        <!-- /header ad 728x60-->
        <?php } ?>
        <?php osc_run_hook('before-main'); ?>
        <?php 
        if(osc_is_home_page())
        {?>
        <div id="header_map">

        <div class="overlay">
            <div class="headline">
                <h1>Reinoieste-ti garderoba!</h1>
                <h6>Bazar online cu haine, incaltaminte si accesorii noi si second hand</h6>
            </div>
            </div>

            <form action="<?php echo osc_base_url(true); ?>" id="main_search" method="get" class="search nocsrf">
                <div class="container">
                    <input type="hidden" name="page" value="search" />
                    <div class="main-search">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="cell">
                                    <input type="text" name="sPattern" id="query" class="input-text" value="" placeholder="<?php _e('Search...', 'pop'); ?>" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="cell selector">
                                    <?php osc_categories_select('sCategory', null, __('Select a category', 'pop')) ; ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="cell selector">
                                    <?php 
            $aCountries = osc_get_countries();
            $aRegions = osc_get_regions($aCountries[0]['pk_c_code']);
                                    ?>
                                    <?php ItemForm::region_select($aRegions); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="cell">
                                    <button class="btn btn-primary btn_search">
                                        <?php _e("Search", 'pop');?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="message-seach"></div>
                    </div>
                </div>
            </form>
            <?php } ?>
        </div>


        <div id="main">
