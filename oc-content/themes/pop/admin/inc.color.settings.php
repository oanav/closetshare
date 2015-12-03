<?php
//Show params acording to subaction
$params         = pop_getColorScheme(); // pop_theme_options(Params::getParam('subaction'));
$paramsOrigin   = array(); //pop_theme_options();
?>
<p >
<?php osc_run_hook("logo_tool"); ?>
<div class="clear"></div>
</p>
<form id="live-preview-form" action="<?php echo osc_admin_render_theme_url('oc-content/themes/pop/admin/settings.php'); ?>" method="post" enctype="multipart/form-data">
<div class="widget-settings">
    <table width="100%">
        <tr class="head-section">
            <td colspan="2"><div><?php _e('Header buttons', 'pop') ; ?></div></td>
        </tr>
        <tr>
            <td><?php _e('Background', 'pop') ; ?></td>
            <td><input type="hidden" maxlength="6" class="canPick" name="headerButtonBG" id="headerButtonBG" value="<?php echo $params['headerButtonBG']; ?>" /></td>
        </tr>
        <tr>
            <td><?php _e('Text buttons', 'pop') ; ?></td>
            <td><input type="hidden" maxlength="6" class="canPick" name="headerButtonText" id="headerButtonText" value="<?php echo $params['headerButtonText']; ?>" /></td>
        </tr>
        <tr>
            <td><?php _e('Background (hover)', 'pop') ; ?></td>
            <td><input type="hidden" maxlength="6" class="canPick" name="headerButtonHoverBG" id="headerButtonHoverBG" value="<?php echo $params['headerButtonHoverBG']; ?>" /></td>
        </tr>
        <tr>
            <td><?php _e('Text buttons (hover)', 'pop') ; ?></td>
            <td><input type="hidden" maxlength="6" class="canPick" name="headerButtonHoverText" id="headerButtonHoverText" value="<?php echo $params['headerButtonHoverText']; ?>" /></td>
        </tr>
        <tr class="head-section">
            <td colspan="2"><div><?php _e('Content', 'pop') ; ?></div></td>
        </tr>
        <tr>
            <td><?php _e('Background', 'pop') ; ?></td>
            <td><input type="hidden" maxlength="6" class="canPick" name="backgroundColor" id="backgroundColor" value="<?php echo $params['backgroundColor']; ?>" /></td>
        </tr>
        <tr>
            <td><?php _e('Main color', 'pop') ; ?></td>
            <td><input type="hidden" maxlength="6" class="canPick" name="mainColor" id="mainColor" value="<?php echo $params['mainColor']; ?>" /></td>
        </tr>
        <tr class="head-section">
            <td colspan="2"><div><?php _e('Premium listings', 'pop') ; ?></div></td>
        </tr>
        <tr>
            <td><?php _e('Background', 'pop') ; ?></td>
            <td><input type="hidden" maxlength="6" class="canPick" name="premiumBackgroundColor" id="premiumBackgroundColor" value="<?php echo $params['premiumBackgroundColor']; ?>" /></td>
        </tr>
        <tr>
            <td><?php _e('Border color', 'pop') ; ?></td>
            <td><input type="hidden" maxlength="6" class="canPick" name="premiumBorderColor" id="premiumBorderColor" value="<?php echo $params['premiumBorderColor']; ?>" /></td>
        </tr>
    </table>
</div>
<p>
    <input type="hidden" name="subaction" value="preview"/>
    <button type="submit" class="btn btn-submit" name="subaction" value="color-update"><?php _e('Save','pop'); ?></button>
    <button type="submit" class="btn btn-red" name="subaction" value="color-restore" id="restore-button"><?php _e('Restore default','pop'); ?></button>
</p>
</form>
<script type="text/javascript">
$('.canPick').each(function(){
    var that = $(this);
    var pickerBg = $('<div class="color"></div>').css('background-color','#'+that.val());
    var pickerMask = $('<div class="mask"></div>');
    var picker = $('<span class="colorpicker-trigger"></span>');

    picker.append(pickerBg).append(pickerMask);

    that.before(picker);
    picker.ColorPicker({
        color: that.val(),
        onSubmit: function(hsb, hex, rgb, el) { },
        onChange: function (hsb, hex, rgb) {
            that.val(hex) ;
            pickerBg.css('background-color','#'+that.val());
            paint();
        }
    });
});
$('select').change(function(){
    paint();
});
function paint(){
    var typefaces = {'serif':'Georgia, Times, "Times New Roman", serif','sans':'Arial, "Helvetica Neue", Helvetica, Verdana, sans-serif'};
    var mainFont = $('select[name="main-font"]').val();
    var secondaryFont = $('select[name="secondary-font"]').val();

    var text = '.custom-wrapper { background-color: #' + $('#headerBG').val() + '}' +
        ' #menu .pure-menu-horizontal .pure-menu-item a.btn-round  {   background-color: #' +$('#headerButtonBG').val()+'; color: #' + $('#headerButtonText').val() + '; }'+
        ' #menu .pure-menu-horizontal .pure-menu-item a.btn-round:hover  {   background-color: #'+ $('#headerButtonHoverBG').val()+'; color: #'+ $('#headerButtonHoverText').val() +';} ' +
        ' body { background-color: #'+ $('#backgroundColor').val() + '; }'+
        ' .btn-round:hover { background-color: #'+ $('#mainColor').val() +'; }' +
        '.masonry .item .listing-attributes .listing-price { color: #'+ $('#mainColor').val() +'; }' +
        '.stamp.sidebar .collections a.active { color: #'+ $('#mainColor').val() +'; }' +
        ' .custom-wrapper { background-color: #'+ $('#mainColor').val() +'; }' +
        '.dropdown-menu>li>a:hover, .dropdown-menu>li>a:focus { background-color: #' + $('#mainColor').val() + '; }' +
        '.masonry .item.premium {border:1px solid #' + $('#premiumBackgroundColor').val() + ';background-color: #'+ $('#premiumBorderColor').val() + ';}';
    //check if exists
    if($('#live-preview').contents().find("#preview").length == 0){
        $('#live-preview').contents().find('head').append('<style id="preview">'+text+'</style>');
    } else {
        $('#live-preview').contents().find("#preview").html(text);
    }
}
$('#live-preview').load(function(){
    paint();
});
$('#restore-button').click(function(){
    var x=window.confirm("<?php echo osc_esc_js(__('Are you sure?')); ?>")
    if (x)
        return true;
    else
        return false;
});
</script>