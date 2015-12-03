<?php
// meta tag robots
osc_add_hook('header','pop_follow_construct');
pop_add_body_class('home');
$listClass   = '';
?>
<?php osc_current_web_theme_path('header.php') ; ?>
<section class="categories">

    <div class="container text-center">
        <div>
            <h1 class="title">
                <?php _e('Categories', 'pop') ; ?>

            </h1>
        </div>
        <?php
        //cell_3
        $total_categories   = osc_count_categories();
        $col1_max_cat       = ceil($total_categories/1);
        osc_goto_first_category();
        $i      = 0;
        $catcount	=	0;
        while ( osc_has_categories() ) {
            $catcount++;

        ?>
        <div class="category-card">
            <?php
            $_slug      = osc_category_slug();
            $_url       = osc_search_category_url();
            $_name      = osc_category_name();
            $_total_items = osc_category_total_items();
            ?>
            <a href="<?php echo $_url; ?>" class="category <?php echo $_slug; ?>">
                <h2>
                    <?php echo $_name ; ?>
                    <span><?php //echo $_total_items; ?></span>
                </h2>
            </a>
            <?php if ( osc_count_subcategories() > 0 ) {
                      $m=1; ?>
            <ul>
                <?php while ( osc_has_subcategories() ) {
                          if( $m<=5){?>
                <li>
                    <a class="sub-category <?php echo osc_category_slug() ; ?>" href="<?php echo osc_search_category_url() ; ?>"><?php echo osc_category_name() ; ?> <span>(<?php echo osc_category_total_items() ; ?>)</span></a>
                </li>
                <?php } $m++;
                          
                          if($m>6) {?>
                <li class="last"><a href="<?php echo $_url; ?>"><strong><?php _e('See more categories...', 'pop'); ?></strong></a></li>
                <?php }
                          
                      }?>
            </ul>
            <?php 
                      $_total_items = $m;
                  }
                  
            ?>

        </div>
    <?php
            $i++;
            
        }
    ?>
</section>
<?php $listClass = 'item'; ?>
<section class=" container text-center">
    <div class="">
        <h1 class="title">
            <?php _e('Latest Listings', 'pop') ; ?>

        </h1>
    </div>
    <div class="latest_ads">
        <?php if( osc_count_latest_items() == 0) { ?>
        <p class="empty">
            <?php _e("There aren't listings available at this moment", 'pop'); ?>
        </p>
        <?php } else { ?>

        <div class="row listings">
            <?php
                  View::newInstance()->_exportVariableToView("listType", 'latestItems');
                  View::newInstance()->_exportVariableToView("listClass", $listClass);
                  osc_current_web_theme_path('loop-items.php');
            ?>
        </div>
        <?php if( osc_count_latest_items() == osc_max_latest_items() ) { ?>
        <p class="clear see-more-link">
            <a class="btn btn-default" href="<?php echo osc_search_show_all_url() ; ?>">
                <?php _e('See all listings', 'pop') ; ?></a>
        </p>
        <?php } ?>
        <?php } ?>
    </div>
    <?php if( osc_get_preference('homepage-728x90', 'pop_theme') != "") { ?>
    <div class="ads_home">
        <?php echo osc_get_preference('homepage-728x90', 'pop_theme'); ?>
    </div>
    <?php } ?>
</section>
<section class="action-call">
    <div class="container">
        <h3>Ai un articol de vanzare? Adauga acum un anunt gratuit.</h3>
        <button class="btn btn-ghost"><?php _e('Publish new listing','pop')?></button>
    </div>
</section>

<?php osc_current_web_theme_path('footer.php') ; ?>