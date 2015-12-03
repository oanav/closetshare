<?php
$category = osc_get_category('id',osc_premium_category_id());
$category_url = osc_search_url(array('sCategory' => $category['s_slug']));

?>
<div class="item <?php echo $class;
if (osc_premium_is_premium()) {
    echo ' premium';
} ?>">
    <?php if (osc_images_enabled_at_items()) { ?>
        <?php if (osc_count_premium_resources()) { ?>
            <a class="" href="<?php echo osc_premium_url(); ?>" title="<?php echo osc_esc_html(osc_premium_title()); ?>"><img src="<?php echo osc_resource_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()); ?>" width="220" ></a>
        <?php } else { ?>
            <a class="" href="<?php echo osc_premium_url(); ?>" title="<?php echo osc_esc_html(osc_premium_title()); ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()); ?>" width="220"></a>
        <?php } ?>
<?php } ?>

    <div class="listing-attributes">
        <span class="listing-price"><?php echo osc_format_price( osc_premium_price(), osc_premium_currency_symbol()); ?></span>
        <span class="listing-title"><a href="<?php echo osc_premium_url();?>"><?php echo osc_premium_title(); ?></a></span>
        <span class="listing-category"><a href="<?php echo $category_url; ?>"><?php echo osc_premium_category(); ?></a></span>
    </div>

    <?php if(Params::getParam('page')=='user') { ?>
    <?php } else if(osc_premium_user_id()!='') {
        View::newInstance()->_exportVariableToView('user', User::newInstance()->findByPrimaryKey(osc_premium_user_id()));
        ?>
    <a href="<?php echo osc_user_public_profile_url(); ?>">
        <div class="listing-seller">
            <div class="listing-seller-avatar" style="background-image: url('<?php echo osc_current_web_theme_url('images/seller-default.png');?>')"></div>
            <span class="seller-name"><?php echo osc_user_name(); ?></span>
            <span class="seller-products"><?php echo osc_user_items_validated(), ' ' ._n('Listing', 'Listings', osc_user_items_validated())?></span>
        </div>
    </a>
    <?php } ?>

</div>