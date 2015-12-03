<?php ?>
<div id="general-settings">
    <div class="head">
        <a href="#back" class="btn btn-dim toggle-theme-options" id="back-current">&laquo; <?php _e('Available designs', 'theme_selector'); ?></a>
        <div class="clear"></div>
    </div>
    <div class="card ">
        <?php require THEMES_PATH.'pop/admin/inc.color.settings.php'; ?>
    </div>
    <div class="clear"></div>
</div>

<iframe id="live-preview" src="<?php echo osc_base_url(); ?>?preview">
</iframe>
<script type="text/javascript">
    $('#content-page').css('min-height', $('#general-settings').outerHeight());
    $(window).resize(function () {
        $('#live-preview').css('width', $(window).outerWidth() - 420);
    });
</script>