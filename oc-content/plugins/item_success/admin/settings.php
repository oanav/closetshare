<?php 
if(Params::getParam('option')=='submit') {
    $bool = (Params::getParam('item_success_add_meta_og')=='on') ? "true" : "false";
    osc_set_preference('item_success_add_meta_og', $bool, 'item_success');
    osc_reset_preferences();
}

$b_meta_og = "";
$_meta_og   = osc_get_preference('item_success_add_meta_og', 'item_success');
if($_meta_og=="true") { $b_meta_og = "checked"; }

?>
<h2 class="render-title"><?php _e('Social item success', 'item_success'); ?></h2>
<form action="<?php echo osc_admin_render_plugin_url('item_success/admin/settings.php'); ?>" method="post">
    <input type="hidden" name="option" value="submit" />
    <fieldset>
        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"></div>
                <div class="form-controls">
                    <label>
                        <input type="checkbox" class="" name="item_success_add_meta_og" <?php echo $b_meta_og ?>> <?php _e('Add open graph meta elements', 'item_success') ?>
                    </label>
                </div>
            </div>
            <div class="form-actions">
                <input type="submit" value="<?php echo osc_esc_html(__('Save changes', 'item_success')); ?>" class="btn btn-submit">
            </div>
        </div>
    </fieldset>
</form>