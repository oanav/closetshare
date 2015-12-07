<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
    <?php osc_current_web_theme_path('head.php'); ?>
</head>
<body <?php pop_body_class(); ?>>

    <div class="navbar navbar-fixed-top" id="menu">
        <div class="top-header">
            <div class="container">
              
              
            </div>
        </div>
        <div class=" header container">
            <div class="pull-left">
                    <?php echo logo_header(); ?>
                    <a href="#" class="custom-toggle hidden" id="toggle">
                        <s class="bar"></s><s class="bar"></s>
                    </a>

                      <ul class="page-list">
                     <li>
                        <a href="<?php echo osc_contact_url(); ?>"><i class="fa fa-envelope"></i><?php _e('Contact', 'pop'); ?></a>
                        </li> 
                        <li>
<a href=""><i class="fa fa-question"></i><?php _e('Help', 'pop'); ?></a>
</li>
                </ul>
            </div>
               <div class="pull-right">

                    <?php if (osc_is_web_user_logged_in()) { ?>
                    <?php
                              $user_id = OSCFacebook::newInstance()->getUser();
                              if ($user_id) {
                                  $user_picture_url = 'https://graph.facebook.com/'.$user_id.'/picture';
                              } else {
                                  $user_picture_url = osc_current_web_theme_url('images/user_default.gif');
                              }
                    ?>
                        <div id="dLabel" class="logo-user-menu" >
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar" src="<?php echo $user_picture_url ?>" />
                            <span class="name"><?php echo osc_logged_user_name(); ?></span>
                            <i class="fa fa-caret-down"></i>
                            </a>
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
                        </div>

                    <?php } else { ?>
                        <a href="<?php echo osc_user_login_url(); ?>">
                        <i class="fa fa-user"></i>
<?php _e('Login', 'pop'); ?></a>
</li>
                    <?php } ?>

                            <a href="<?php echo osc_item_post_url_in_category(); ?>" class="btn btn-primary">
<i class="fa fa-plus"></i>
<?php _e('Publish new listing', 'pop'); ?></a>


                </div>
            <div class="text-center">
                <div class="categories-dropdown">
                    <a>
                    <i class="fa fa-bars"></i>
                    <?php _e('Categories','pop') ?>
                    </a>
                    <div class="dropdown">
                        <?php $i=0;
                              while(osc_has_categories()) { ?>
                              
                            <ul>
                             <li class="cat"><a href="<?php echo osc_search_category_url()?>"><?php echo osc_category_name();?></a></li>
                           
                                <?php while (osc_has_subcategories()) { ?>
                                <li class="subcat">
                                    <a href="<?php echo osc_search_category_url()?>"><?php echo osc_category_name();?></a>
                                </li>

                                <?php } ?>
                            </ul>

                        <?php              $i++;
                              } ?>
                              </div>
                </div>
                <div class="search-dropdown">
                <a>
               <i class="fa fa-search"></i>
                 <?php _e('Search','pop') ?>
                 </a>
                 <div class="header-search">
                 <?php require WebThemes::newInstance()->getCurrentThemePath() . 'inc.quick.search.php';?></div>
                </div>
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
        </div>


        <div id="main">
