<?php
    // meta tag robots
    osc_add_hook('header','pop_nofollow_construct');

    pop_add_body_class('page');
    osc_current_web_theme_path('header.php') ;
?>
<div class="form-container box">
    <div class="header">
        <h1><?php echo osc_static_page_title(); ?></h1>
    </div>
    <div class="form-content">
        <?php echo osc_static_page_text(); ?>
    </div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>