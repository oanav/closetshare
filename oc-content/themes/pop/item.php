<?php   
$location = array();
    if( osc_item_region() !== '' ) {
        $location[] = osc_item_region();
    }
        if( osc_item_city() !== '' ) {
        $location[] = osc_item_city();
    }
        if( osc_item_city_area() !== '' ) {
        $location[] = osc_item_city_area();
    }

// meta tag robots
osc_add_hook('header', 'pop_follow_construct');
pop_add_body_class('item');
osc_enqueue_script('jquery-validate');
osc_enqueue_script('jquery-bxslider');
osc_enqueue_style('jquery-bxslider-css', osc_current_web_theme_url('css/jquery.bxslider.css'));
osc_enqueue_script('imgLiquid-js');
View::newInstance()->_exportVariableToView('user', User::newInstance()->findByPrimaryKey(osc_item_user_id()));
?>

<?php osc_current_web_theme_path('header.php'); ?>
<?php $class = '';
if (osc_count_item_resources() == 0) {
    $class = "no-image";
} ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="item-photos">
                <?php if (osc_count_item_resources() > 0) { ?>
                <a class="main-photo" href="<?php echo osc_resource_url(); ?>">
                    <img class="img-responsive"  src="<?php echo osc_resource_url(); ?>"  
            title="<?php echo osc_item_title(); ?>"/>
                </a>
                <div class="thumbs">
                    <?php osc_reset_resources();
 for ( $i = 0; osc_has_item_resources(); $i++ ) { ?>
                    <a href="<?php echo osc_resource_url(); ?>" class="fancybox" data-fancybox-group="group" title="<?php _e('Image', 'pop'); ?> <?php echo $i+1;?> / <?php echo osc_count_item_resources();?>">
                        <img src="<?php echo osc_resource_thumbnail_url(); ?>" class="img-responsive" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" />
                    </a>
                    <?php } ?>
                </div>
                <?php } else { ?>
                <div>
                    <img class="img-responsive" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>"/>
                </div>
                <?php }?>
            </div>


            <!--<div class="box fb-comments" data-href="<?php echo osc_item_url() ?>" data-numposts="5"></div>-->

            <?php if( osc_comments_enabled() ) { 
      //  item_comments();
        } ?>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="item-detail">
                <?php if(osc_is_web_user_logged_in() && osc_logged_user_id()==osc_item_user_id()) { ?>

                <div class="toolbar admin-options">
                   
                    <a class="link" href="<?php echo osc_item_edit_url(); ?>" rel="nofollow">
                        <i class="fa fa-pencil"></i>
                        <?php _e('Edit', 'pop'); ?>
                    </a>
                    <a class="link" href="#" onclick="confirmDelete('#dialog-delete-item','<?php echo osc_item_delete_url(); ?>')" rel="nofollow">
                        <i class="fa fa-trash"></i>
                        <?php _e('Delete', 'pop'); ?>
                    </a>
                     <?php if(osc_item_is_inactive()) {?>
                    <a class="link" href="<?php echo osc_item_activate_url();?>">
                        <i class="fa fa-check-circle"></i>
                        <?php _e('Activate', 'pop'); ?>
                    </a>
                    <?php } else { ?>
                    <a class="link" href="<?php echo osc_item_deactivate_url();?>">
                        <i class="fa fa-minus-circle"></i>
                        <?php _e('Deactivate', 'pop'); ?>
                    </a>
                    <?php } ?>
                </div>
                <?php } ?>
                <div class="item-header">
                    <h1 class="item-title"><?php echo osc_item_title(); ?></h1>


                    <?php if (count($location)>0) { ?>
                    <div class="item-location">
                        <i class="fa fa-map-marker"></i>
                        <?php echo implode(', ', $location); ?>
                    </div>
                    <?php }; ?>
                    <div class="item-date">
                        <i class="fa fa-calendar"></i>
                        <?php
                if ( osc_item_pub_date() !== '' ) { 
                    printf( __('%1$s', 'pop'),osc_format_date( osc_item_pub_date() ) ); 
                    }
            ?>
                    </div>

                    <?php voting_item_detail(); ?>

                </div>
                <?php if(osc_price_enabled_at_items() && osc_item_price()){ ?>
                <div class="item-price">
                    <?php echo osc_item_formated_price();?>
                </div>
                <?php  } ?>
                <div>

                    <?php watchlist(); ?>
                </div>
                <div class="share-links">
                    <p>
                        <a href="<?php echo osc_esc_html(pop_facebook_share_url()); ?>" title="Share" class="share-icon facebook-icon"></a>
                        <a href="<?php echo osc_esc_html(pop_twitter_share_url()); ?>" title="Share" class="share-icon twitter-icon"></a>
                        <a href="<?php echo osc_esc_html(pop_gplus_share_url()); ?>" title="Share" class="share-icon googleplus-icon"></a>

                        <a href="<?php echo osc_esc_html(pop_email_share_url()); ?>" title="Share" class="share-icon email-icon"></a>
                        <p>
                </div>
            </div>

            <div class="item-details">
                <div class="header"><?php _e('Details', 'pop'); ?> </div>

                <?php osc_run_hook('item_detail', osc_item() ); ?>

                <div id="custom_fields">
                    <?php if( osc_count_item_meta() >= 1 ) { ?>
                    <div class="meta_list">
                        <?php while ( osc_has_item_meta() ) { ?>
                        <?php if(osc_item_meta_value()!='') { ?>
                        <div class="meta">
                            <strong><?php echo osc_item_meta_name(); ?>:</strong> <?php echo osc_item_meta_value(); ?>
                        </div>
                        <?php } ?>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>

                <h4><?php _e('Description', 'pop'); ?> :</h4>
                <div>
                    <?php echo osc_item_description(); ?>
                </div>
            </div>


        </div>

        <div class="col-sm-6 col-md-3">
            <div class="box user-detail">
                <?php if(osc_item_user_id()!=0) { ?>
                <?php 
        $fbUser = OSCFacebook::newInstance()->getFBUser(osc_item_user_id());
        if($fbUser) {
            $user_picture_url = "https://graph.facebook.com/". $fbUser . "/picture";
        } else {
            $user_picture_url =  osc_current_web_theme_url('images/user_default.gif');
        }
        ?>
                <div class="listing-seller">

                    <div class="listing-seller-avatar" style="background-image: url('<?php echo $user_picture_url; ?>')"></div>
                    <div class="seller-name">
                        <?php echo osc_item_contact_name(); ?>
                        <br/>
                    <a class="link" href="<?php echo osc_user_public_profile_url();?>"><?php _e('View 
profile','pop')?></a>
                    </div>
                    <div class="clear"></div>
                 <!--   <div class="seller-location">
                        <i class="fa fa-map-marker"></i>
                        <?php echo osc_user_city(); ?>
                    </div>-->

                     <button class="btn btn-gray" id="contact_btn">
                    <i class="md-icon">email</i>
                    <?php _e('Send message', 'pop'); ?>
                </button>
                </div>
                <?php /* if (osc_user_phone() != '') { ?>
                <div class="user-phone">
                    <i class="fa fa-phone"></i>
                    <span><?php echo osc_user_phone() ?></span>
                </div>
                <?php }*/?>
               
                <div class="divider"></div>

                <?php } ?>

                <?php $aItems = Item::newInstance()->findByUserID(osc_item_user_id(), 0, 3);
    View::newInstance()->_exportVariableToView('items', $aItems);
    ?>
                <div class="user-products">
                    <p><?php printf(__('Other products from %s', 'pop'), osc_user_name()); ?></p>
                    <div>
                        <?php
        while (osc_has_items()) {
            if (osc_count_item_resources()) {
                osc_get_item_resources();
                ?>
                        <a class="user-item" href="<?php echo osc_item_url(); ?>"  title="<?php echo osc_esc_html(osc_item_title()); ?>">
                            <img src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" />
                        </a>
                        <?php } else { ?>
                        <a class="user-item" href="<?php echo osc_item_url(); ?>"  title="<?php echo osc_esc_html(osc_item_title()); ?>">
                            <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="<?php echo osc_item_title(); ?>" title="<?php echo osc_item_title(); ?>" />
                        </a>
                        <?php } ?>
                        <?php }  ?>
                    </div>
                    <div class="clear"></div>
                    <a href="<?php echo osc_user_public_profile_url(); ?>"><?php _e('See all user products', 'pop')?></a>
                </div>
            </div>

    <?php require 'inc.seller.contact.php'; ?>


</div>
</div>
</div>
<?php related_listings(); ?>
<?php if( osc_count_items() > 0 ) { ?>
<section class="gray">

    <div class="similar listings container">
        <h1 class="title">
            <?php _e('Related items', 'pop'); ?>
        </h1>
        <div>
            <?php
    $i=0;
        while (osc_has_items()) {
                pop_draw_item('', false);
                $i++;
     } ?>
        </div>
    </div>
</section>
<div class="ad">
    <?php pop_draw_ad('search-results-300x250'); ?>
</div>
<?php } ?>

<script>
    $("#contact").dialog({
        modal: true,
        autoOpen: false,
        width: 560
    });
    $("#contact_btn").on("click", function () {
        $("#contact").dialog('open');
    });
    $("#dialog-delete-item").dialog({
        autoOpen: false,
        modal: true,
        width: 350
    });
</script>

<script>
    $('.bxslider').bxSlider({
        pagerCustom: '#bx-pager',
        mode: 'fade'
    });
</script>
<?php
osc_current_web_theme_path('footer.php');
?>