<?php

$category = osc_get_category('id',osc_item_category_id());
$category_url = osc_search_url(array('sCategory' => $category['s_slug']));
if (osc_item_is_premium()) { 
    $class .= ' premium';
}
?>
<div class="item <?php echo $class; ?>">
    <?php if (osc_images_enabled_at_items()) { ?>
    <?php if (osc_count_item_resources()) { ?>
    <a class="listing-img img-fit" href="<?php echo osc_item_url(); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>">
        <img src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()); ?>" ></a>
    <?php } else { ?>
    <a class="listing-img" href="<?php echo osc_item_url(); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>">
        <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()); ?>"></a>
    <?php } ?>
    <?php } ?>

    <div class="listing-attributes">
        <span class="listing-title"><a href="<?php echo osc_item_url();?>"><?php echo osc_item_title(); ?></a></span>
        <span class="listing-price"><?php echo osc_format_price(osc_item_price()); ?></span>

        <!-- <span class="listing-category"><a href="<?php echo $category_url; ?>"><?php echo osc_item_category(); ?></a></span> -->
        <?php   
        if( osc_item_city() !== '' ) {
            $location = osc_item_city();
        }

        if( osc_item_region() !== '' ) {

            $location .= ' (' . osc_item_region() . ')';
        }

        ?>
        <?php if ($location && Params::getParam('page')!='user' && Params::getParam('_page')!='user') { ?>
        <div class="listing-location">
            <i class="fa fa-map-marker"></i>
            <?php echo $location; ?>
        </div>
        <?php } ?>
        <?php if ($admin) { ?>
        <div>
            <span><?php _e('published on','pop'); ?>
                <?php printf( __('%1$s', 'pop'),osc_format_date( osc_item_pub_date() ) );  ?></span>
            <?php if(osc_item_is_expired()) { ?>
            <span>| </span>
            <i><?php _e('Item expired','pop')?></i>
            <?php } else if(osc_item_dt_expiration() != '9999-12-31 23:59:59') {?>
            <span>| </span>
            <span><?php _e('expires on','pop'); ?>
                <?php printf( __('%1$s', 'pop'),osc_format_date( osc_item_dt_expiration() ) ); ?>
            </span>
            <?php } ?>
        </div>
        <div>
            <i class="material-icons">visibility</i>
            <?php echo osc_item_views() ?> <?php _e('views')?>

        </div>
        <?php }?>
    </div>

    <?php if(Params::getParam('page')=='user' || Params::getParam('_page')=='user') { ?>
    <?php if ($admin) { ?>
    <div class="admin-options">
        <!--   <div id="doptions_//<?php echo osc_item_id(); ?>" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-gear"></i><i class="fa fa-caret-down"></i>
        </div>-->

        <a class="link" href="<?php echo osc_item_edit_url(); ?>" rel="nofollow">
            <i class="material-icons">edit</i>
            <?php _e('Edit item', 'pop'); ?></a>
        <a href="#" class="link delete" onclick="confirmDelete('#dialog-delete-item','<?php echo osc_item_delete_url(); ?>')" >
            <i class="material-icons">delete</i>
            <?php _e('Delete', 'pop'); ?></a>
        <?php if(osc_item_is_inactive()) {?>
        <a class="link" href="<?php echo osc_item_activate_url();?>">
            <i class="material-icons">check_circle</i>
            <?php _e('Activate', 'pop'); ?>
        </a>
        <?php } else { ?>
        <a class="link" href="<?php echo osc_item_deactivate_url();?>">
            <i class="material-icons">block</i>
            <?php _e('Deactivate', 'pop'); ?>
        </a>
        <?php } ?>
        <?php if(osc_item_is_expired()) { ?>
        <a class="link" href="<?php if (function_exists('republish_url')) {echo republish_url();} ?>">
            <i class="material-icons">autorenew</i>

            <?php _e('Republish', 'pop'); ?>
        </a>
        <?php } ?>
    </div>
    <?php } ?>

    <div class="clear"></div>
    <?php } else if(osc_item_user_id()!='') {
              View::newInstance()->_exportVariableToView('user', User::newInstance()->findByPrimaryKey(osc_item_user_id()));
    ?>
    <?php 
              $fbUser = OSCFacebook::newInstance()->getFBUser(osc_item_user_id());
              if($fbUser) {
                  $user_picture_url = "https://graph.facebook.com/". $fbUser . "/picture";
              } else {
                  $user_picture_url =  osc_current_web_theme_url('images/user_default.gif');
              }
    ?>
    <a href="<?php echo osc_user_public_profile_url(); ?>">


        <div class="listing-seller">
            <img class="listing-seller-avatar" src="<?php echo $user_picture_url ?>"/>
            <span class="seller-name"><?php echo osc_user_name(); ?></span>
        </div>
    </a>

    <?php if (!$admin) { ?>
    <div class="actions pull-right">
        <a href="<?php echo osc_esc_html(pop_facebook_share_url()); ?>" title="<?php _e('Share','pop')?>"><i class="material-icons">share</i></a>
        <?php watchlist(); ?>
    </div>
    <?php } ?>

    <?php } ?>

</div>
