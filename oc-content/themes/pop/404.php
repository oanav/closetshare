<?php
// meta tag robots
osc_add_hook('header', 'pop_nofollow_construct');

osc_add_filter('meta_title_filter', 'pop_title_404');
function pop_title_404($title) {
    $header_text = __("Sorry but I can't find the page you're looking for", 'pop');
    if(View::newInstance()->_get('pop_404_header_text')!='') {
        $header_text = View::newInstance()->_get('pop_404_header_text');
    }
    return $header_text;
}

pop_add_body_class('_404');
osc_current_web_theme_path('header.php');
?>
<div class="form-container box">
    <div class="header">
        <?php $header_text = __("Sorry but I can't find the page you're looking for", 'pop');
        if(View::newInstance()->_get('pop_404_header_text')!='') {
            $header_text = View::newInstance()->_get('pop_404_header_text');
        } ?>
        <h1><?php echo $header_text; ?></h1>
    </div>
    <div class="form-content">
        <div class="flashmessage-404">
            
            <ul>
                <li>
                    <?php _e("<strong>Search</strong> for it:", 'pop') ; ?>
                    <?php osc_current_web_theme_path('inc.search.404.php') ; ?>
                </li>
                <li><?php _e("<strong>Look</strong> for it in the most popular categories.", 'pop') ; ?>
                    <div class="categories">
                        <?php osc_get_non_empty_categories(); ?>
                        <?php while ( osc_has_categories() ) { ?>
                                <h2><a class="category <?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?></a> <span>(<?php echo osc_category_total_items() ; ?>)</h2>
                                <?php if ( osc_count_subcategories() > 0 ) { ?>
                                    <?php while ( osc_has_subcategories() ) { ?>
                                        <h3><a class="category <?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?></a> <span>(<?php echo osc_category_total_items() ; ?>)</h3>
                                    <?php } ?>
                                <?php } ?>
                        <?php } ?>
                   </div>
                   <div class="clear"></div>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php
osc_current_web_theme_path('footer.php') ; ?>