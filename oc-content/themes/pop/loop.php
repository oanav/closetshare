<?php
$class='';
$loopClass = '';
$type = 'items';
if (View::newInstance()->_exists('listType')) {
    $type = View::newInstance()->_get('listType');
}
if (View::newInstance()->_exists('listClass')) {
    $loopClass = View::newInstance()->_get('listClass');
}
?>
<div class="masonry"><?php echo Params::getParam('page'); ?>
    <?php if( (osc_is_search_page() || osc_is_home_page()) && Params::getParam('hook')!='load_more_listing') { ?>
    <div class="item stamp sidebar">
        <?php require WebThemes::newInstance()->getCurrentThemePath() . 'inc.search.filters.php'; ?>
    </div>
    <?php   if( osc_is_search_page() && Params::getParam('hook')!='load_more_listing') { ?>
    <div class="item stamp  stamp-alert">
        <?php require WebThemes::newInstance()->getCurrentThemePath() . 'inc.alert.form.php'; ?>
    </div>
    <?php   } ?>
    <?php } ?>
    <?php
    // get premium ads
    if(!osc_is_list_items() &&
        !osc_is_public_profile()
        ) {
        $max = osc_get_preference('pop_max_premium', 'pop_theme');
        osc_get_premiums($max);
        if (osc_count_premiums() > 0) {
            while (osc_has_premiums()) {
                pop_draw_item($class, false, true);
            }
        }
    }

    $i = 0;
    if ($type == 'latestItems') {
        while (osc_has_latest_items()) {
            pop_draw_item($class);
            $i++;
        }
    } elseif ($type == 'premiums') {
        while (osc_has_premiums()) {
            pop_draw_item($class, false, true);
            $i++;
            if ($i == 3) { // preferencia cuantos listings destacados ?
                break;
            }
        }
    } else {
        while (osc_has_items()) {
            $i++;
            $admin = false;
            if (View::newInstance()->_exists("listAdmin")) {
                $admin = true;
            }
            pop_draw_item('', $admin);
        }
    }
    pop_draw_ad('search-results-300x250');
    ?>

</div>
<?php
    if(osc_search_total_pages()>1) {
?>
<div class="wrapper wrapper-more-listings">
    <div class="more-listings-section clear">
        <a href=".dummy" id="js-load-more-listings" class="more-listings-block">
            <i class="ico-plus_normal"></i>
            <br/>
            <span><?php _e('Load more listings', 'pop'); ?></span>
        </a>
    </div>
    <div id="js-load-more-listings-loading">
        <img src="<?php echo osc_current_web_theme_url('images/loading_transparent.gif') ?>"/>
    </div>
</div>
<?php } ?>