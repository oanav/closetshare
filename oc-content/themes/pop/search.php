<?php
// meta tag robots
if (osc_count_items() == 0 || stripos($_SERVER['REQUEST_URI'], 'search')) {
    osc_add_hook('header', 'pop_nofollow_construct');
} else {
    osc_add_hook('header', 'pop_follow_construct');
}

$listClass = 'item';
pop_add_body_class('search');
?>
<?php osc_current_web_theme_path('header.php');  ?>

<?php

View::newInstance()->_exportVariableToView("listType", 'items');
View::newInstance()->_exportVariableToView("listClass", $listClass);
?>
<?php   $category = __get("category");
        if(!isset($category['pk_i_id']) ) {
            $category['pk_i_id'] = null;
        }

        $current_category_id = '';
        $current_category_parent = '';
        $_current_category_id = osc_search_category_id();
        if( count($_current_category_id) > 0 ) {
            $current_category_id = $_current_category_id[0];
            $_current_category = Category::newInstance()->findByPrimaryKey( $current_category_id );
        }           
?>
<div class="container">
    
        <div class="search-sidebar hidden-mobile">
     <!--   <div class="box category">
      <h3> <?php _e('Categories', 'pop'); ?></h3>
        <div id="ssCategory" class="collapse in">
       <?php pop_sidebar_category_search($current_category_id); ?>
            </div>
        </div>-->
        <div class="box filter">
            <div id="ssFilter" class="collapse in">
            <?php require WebThemes::newInstance()->getCurrentThemePath() . 'inc.search.filters.php';?>
            </div>
        </div>
        <div id="ssAlert" class="box alert">
            <?php require WebThemes::newInstance()->getCurrentThemePath() . 'inc.alert.form.php'; ?>
        </div>
    </div>
 <!--   <div class="search-bar"> <?php // require WebThemes::newInstance()->getCurrentThemePath() . 'inc.search.filters.php';?></div>-->
    <div class="search listings">

        <div class="toolbar">
            <?php osc_run_hook('search_ads_listing_top'); ?>
            <?php if(osc_count_items() == 0) { ?>
            <p class="empty"><?php _e('There are no results matching your search', 'pop') ; ?></p>
            <?php } else { ?>
            <span class="counter-search">
                <?php
                      printf(__('%s results', 'pop'), osc_search_total_items());
                ?>
            </span>
            <div class="sort">
                <span><?php echo _e('Sort by:', 'pop'); ?></span>
                <?php
                      $orders = osc_list_orders();
                      $current = '';
                      foreach($orders as $label => $params) {
                          $orderType = ($params['iOrderType'] == 'asc') ? '0' : '1';
                          if(osc_search_order() == $params['sOrder'] && osc_search_order_type() == $orderType) {
                              $current = $label;
                          }
                      }
                ?>
                <?php $i = 0; ?>
                <ul>
                    <?php
                      foreach($orders as $label => $params) {
                          $orderType = ($params['iOrderType'] == 'asc') ? '0' : '1'; ?>
                    <?php if(osc_search_order() == $params['sOrder'] && osc_search_order_type() == $orderType) { ?>
                    <li><a class="active" href="<?php echo osc_esc_html(osc_update_search_url($params)); ?>"><?php echo $label; ?></a></li>
                    <?php } else { ?>
                    <li><a href="<?php echo osc_esc_html(osc_update_search_url($params)); ?>"><?php echo $label; ?></a></li>
                    <?php } ?>
                    <?php $i++; ?>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>
        </div>
        <div id="content_loadin">
            <div id="grid" data-columns="4">
                <?php
                osc_current_web_theme_path('loop-search.php');
                ?>
            </div>
            <?php
            if(osc_search_total_pages()>1) {
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
            <!--     <div class="wrapper-more-listings">
        <div class="more-listings-section ">
            <a href="" id="js-load-more-listings" class="more-listings-block">
                <i class="ico-plus_normal"></i>
                <span><?php _e('Load more listings', 'pop'); ?></span>
            </a>
        </div>
        <div id="js-load-more-listings-loading">
            <img src="<?php echo osc_current_web_theme_url('images/loading_transparent.gif') ?>"/>
        </div>
    </div> -->
            <?php } ?>
        </div>
    </div>
</div>
<?php location_autocomplete(); ?>



<?php
osc_current_web_theme_path('footer.php');



?>
