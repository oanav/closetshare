<?php
    // meta tag robots
    osc_add_hook('header','pop_nofollow_construct');

    pop_add_body_class('user user-custom');

    osc_current_web_theme_path('header.php') ;
?>

<?php osc_current_web_theme_path('user-sidebar.php'); ?>
<div class="user-content box">
    <div class="header">
    </div>
    <?php osc_render_file(); ?>
</div>
<?php
    osc_current_web_theme_path('footer.php');
?>