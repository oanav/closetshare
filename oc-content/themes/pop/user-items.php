<?php
    // meta tag robots
    osc_add_hook('header','pop_nofollow_construct');

    pop_add_body_class('user user-items');

    osc_current_web_theme_path('header.php') ;

?>
<div class="container">
<?php osc_current_web_theme_path('user-sidebar.php'); ?>
<div class="col-sm-8 col-md-9">
   <?php $total_items = osc_count_items();?>
    <?php if($total_items == 0) { ?>
        <p class="empty" ><?php _e('No listings have been added yet', 'pop'); ?></p>
    <?php } else { ?>
    <div class="toolbar"><?php printf(__('%s listings', 'pop'), $total_items); ?></div>
    <div id="grid" class="listings admin-items">
    <?php
        View::newInstance()->_exportVariableToView("listAdmin", true);
        View::newInstance()->_exportVariableToView("listClass", "user");
        osc_current_web_theme_path('loop-items.php');
    ?>
        </div>
    <div class="clear"></div> 
     
<?php }  ?>
</div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>
