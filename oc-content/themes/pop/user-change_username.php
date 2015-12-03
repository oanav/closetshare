<?php
    // meta tag robots
    osc_add_hook('header','pop_nofollow_construct');

    osc_enqueue_script('jquery-validate');

    pop_add_body_class('user user-profile');

    osc_add_filter('meta_title_filter','custom_meta_title');
    function custom_meta_title($data){
        return __('Change username', 'pop');
    }
    osc_current_web_theme_path('header.php') ;
    $osc_user = osc_user();
?>
<?php osc_current_web_theme_path('user-sidebar.php'); ?>
<div class="user-content box col-sm-8 col-md-9">
<h1><?php _e('Change username', 'pop'); ?></h1>
<script type="text/javascript">
$(document).ready(function() {
    $('form#change-username').validate({
        rules: {
            s_username: {
                required: true
            }
        },
        messages: {
            s_username: {
                required: '<?php echo osc_esc_js(__("Username: this field is required", "pop")); ?>.'
            }
        },
        errorLabelContainer: "#error_list",
        wrapper: "li",
        invalidHandler: function(form, validator) {
            $('html,body').animate({ scrollTop: $('h1').offset().top }, { duration: 250, easing: 'swing'});
        },
        submitHandler: function(form){
            $('button[type=submit], input[type=submit]').attr('disabled', 'disabled');
            form.submit();
        }
    });

    var cInterval;
    $("#s_username").keydown(function(event) {
        if($("#s_username").attr("value")!='') {
            clearInterval(cInterval);
            cInterval = setInterval(function(){
                $.getJSON(
                    "<?php echo osc_base_url(true); ?>?page=ajax&action=check_username_availability",
                    {"s_username": $("#s_username").attr("value")},
                    function(data){
                        clearInterval(cInterval);
                        if(data.exists==0) {
                            $("#available").text('<?php echo osc_esc_js(__("The username is available", "pop")); ?>');
                        } else {
                            $("#available").text('<?php echo osc_esc_js(__("The username is NOT available", "pop")); ?>');
                        }
                    }
                );
            }, 1000);
        }
    });

});
</script>
<div class="form-container form-horizontal">
    <div class="resp-wrapper">
        <ul id="error_list"></ul>
        <form action="<?php echo osc_base_url(true); ?>" method="post" id="change-username">
            <input type="hidden" name="page" value="user" />
            <input type="hidden" name="action" value="change_username_post" />
            <div class="control-group">
                <label class="control-label" for="s_username"><?php _e('Username', 'pop'); ?></label>
                <div class="controls">
                    <input type="text" name="s_username" id="s_username" value="" />
                    <div id="available"></div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn-black"><?php _e("Update", 'pop');?></button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>