<?php
// meta tag robots
osc_add_hook('header', 'pop_follow_construct');

$address = '';
if (osc_user_address() != '') {
    if (osc_user_city_area() != '') {
        $address = osc_user_address() . ", " . osc_user_city_area();
    } else {
        $address = osc_user_address();
    }
} else {
    $address = osc_user_city_area();
}
$location_array = array();
if (osc_user_city()) {
    $location_array[] = osc_user_city();
}
if (osc_user_region() != '') {
    $location_array[] = osc_user_region();
}
if (osc_user_country() != '') {
    $location_array[] = osc_user_country();
}
$location = implode(", ", $location_array);
unset($location_array);

osc_enqueue_script('jquery-validate');

pop_add_body_class('user-public-profile');

//osc_add_hook('before-main', 'pop_user_map_header');
//function pop_user_map_header() {
//    osc_current_web_theme_path('inc.user_header_public_profile.php');
//}
osc_current_web_theme_path('header.php');
?>

<div class="container">
    <div class="user-card pull-left">
       <?php 
       $fbUser = OSCFacebook::newInstance()->getFBUser(osc_item_user_id());
       if($fbUser) {
        $user_picture_url = "https://graph.facebook.com/". $fbUser . "/picture";
    } else {
        $user_picture_url =  osc_current_web_theme_url('images/user_default.gif');
    }
    ?>
    <div>
        <img class="user-avatar" src="<?php echo $user_picture_url ?>" />
        <div class="name"><?php echo osc_highlight(osc_user_name(),120); ?></div>
    </div>
    <ul class=" user_data">
    <?php if($location) {?>
        <li class="location">
            <i class="md-icon">place</i>
            <?php echo $location; ?>
        </li>
        <?php } ?>
        <li class="email">
            <i class="md-icon">email</i>
            <a href="mailto:<?php echo osc_user_email(); ?>"><?php echo osc_user_email(); ?></a></li>

            <?php if( osc_user_website() !== '' ) { ?>
            <li class="website">
                <i class="fa fa-globe"></i>
                <a href="<?php echo osc_user_website(); ?>"><?php echo osc_user_website(); ?></a></li>
                <?php } ?>


    </ul>
    <div class="clear"></div>
    <div class="share-links">
        <a href="<?php echo pop_facebook_share_url(); ?>" class="share-icon facebook-icon"></a>
        <a href="<?php echo pop_twitter_share_url(); ?>" class="share-icon twitter-icon"></a>
        <a href="<?php echo osc_esc_html(pop_gplus_share_url()); ?>" class="share-icon googleplus-icon"></a>
        <a href="<?php echo pop_email_share_url(); ?>" class="share-icon email-icon"></a>
    </div>
</div>
<div id="content_loadin">
    <div id="grid" data-columns class="listings">
    <?php if (osc_count_items() > 0) { 
        osc_current_web_theme_path('loop-items.php');
    } ?>
    </div>
      <div class="clear"></div> 
      <?php if(osc_search_total_pages()>1) {
        ?>
        <div class="loading-bar">
                <a href="" class="load-more">
                        <i class="ico-plus_normal"></i>
                        <span><?php _e('Load more listings', 'pop'); ?></span>
                    </a>
                <div class="loading">
                    <img src="<?php echo osc_current_web_theme_url('images/loading_transparent.gif') ?>"/>
                </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php'); ?>