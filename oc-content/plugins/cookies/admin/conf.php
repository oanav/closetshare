<?php

if(Params::getParam('plugin_action')=='done') {
    osc_set_preference('analytics_msg', trim(Params::getParam("analytics_msg", false, false)), 'cookie', 'STRING');
    osc_set_preference('non_analytics_msg', trim(Params::getParam("non_analytics_msg", false, false)), 'cookie', 'STRING');
    osc_set_preference('analytics_id', trim(Params::getParam("analytics_id")), 'cookie', 'STRING');
    osc_set_preference('policy_link', trim(Params::getParam("policy_link")), 'cookie', 'STRING');
    osc_set_preference('what_are_link', trim(Params::getParam("what_are_link")), 'cookie', 'STRING');
    osc_set_preference('domain', Params::getParam("domain"), 'cookie', 'STRING');
    osc_set_preference('accept', Params::getParam("accept")==1?1:0, 'cookie', 'BOOLEAN');
    osc_set_preference('decline', Params::getParam("decline")==1?1:0, 'cookie', 'BOOLEAN');
    osc_set_preference('reset', Params::getParam("reset")==1?1:0, 'cookie', 'BOOLEAN');

    // HACK : This will make possible use of the flash messages ;)
    ob_get_clean();
    osc_add_flash_ok_message(__('Congratulations, the plugin is now configured', 'cookie'), 'admin');
    osc_redirect_to(osc_route_admin_url('cookie-conf'));
}
?>
<script type="text/javascript" >
    $(document).ready(function () {
        $.cookie("cc_cookie_accept", null, { path: '/' });
        $.cookie("cc_cookie_decline", null, { path: '/' });

        var options = new Object();

        function get_options() {
            options.cookieAcceptButton = $("#accept").prop("checked");
            options.cookieDeclineButton = $("#decline").prop("checked");
            options.cookieResetButton = $("#reset").prop("checked");
            options.cookiePolicyLink = $("#policy_link").prop("value");
            options.cookieWhatAreTheyLink = $("#what_are_link").prop("value");
            options.cookieMessage= $("#non_analytics_msg").prop("value");
            options.cookieAnalyticsMessage = $("#analytics_msg").prop("value");
            if($("#analytics_id").prop("value")!="") {
                options.cookieAnalytics = true;
            } else {
                options.cookieAnalytics = false;
            }
        }

        $("#accept, #decline, #reset, #non_analytics_msg, #analytics_msg, #analytics_id, #policy_link, #what_are_link").on('change', function() {
            $.cookie("cc_cookie_accept", null, { path: '/' });
            $.cookie("cc_cookie_decline", null, { path: '/' });
            $(".cc-cookies").remove();
            get_options();
            console.log(options);
            $.cookieCuttr(options);
        });

        get_options();
        $.cookieCuttr(options);
    });
</script>
<div id="general-setting" xmlns="http://www.w3.org/1999/html">
    <div id="general-settings">
    <h2 class="render-title"><?php _e('Cookies settings', 'cookie'); ?></h2>
        <ul id="error_list"></ul>
        <form name="cookie_form" action="<?php echo osc_admin_base_url(true); ?>" method="post">
            <input type="hidden" name="page" value="plugins" />
            <input type="hidden" name="action" value="renderplugin" />
            <input type="hidden" name="route" value="cookie-conf" />
            <input type="hidden" name="plugin_action" value="done" />
            <fieldset>
                <div class="form-horizontal">
                    <div class="form-row">
                        <div class="form-label"><?php _e('Accept', 'cookie'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('accept', 'cookie') ? 'checked="true"' : ''); ?> id="accept" name="accept" value="1" />
                                    <?php _e('Show accept button', 'cookie'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Decline', 'cookie'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('decline', 'cookie') ? 'checked="true"' : ''); ?> id="decline" name="decline" value="1" />
                                    <?php _e('Show decline button', 'cookie'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Reset', 'cookie'); ?></div>
                        <div class="form-controls">
                            <div class="form-label-checkbox">
                                <label>
                                    <input type="checkbox" <?php echo (osc_get_preference('reset', 'cookie') ? 'checked="true"' : ''); ?> id="reset" name="reset" value="1" />
                                    <?php _e('Show reset button', 'cookie'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Default message (without Google Analytics)', 'cookie'); ?></div>
                        <div class="form-controls"><textarea style="width:400px" id="non_analytics_msg" name="non_analytics_msg"><?php echo osc_get_preference('non_analytics_msg', 'cookie'); ?></textarea></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Analytics message', 'cookie'); ?></div>
                        <div class="form-controls"><textarea style="width:400px" id="analytics_msg" name="analytics_msg"><?php echo osc_get_preference('analytics_msg', 'cookie'); ?></textarea></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Analytics ID', 'cookie'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" id="analytics_id" name="analytics_id" value="<?php echo osc_get_preference('analytics_id', 'cookie'); ?>" /></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('Policy link', 'cookie'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" id="policy_link" name="policy_link" value="<?php echo osc_get_preference('policy_link', 'cookie'); ?>" /></div>
                    </div>
                    <div class="form-row">
                        <div class="form-label"><?php _e('What are cookies link', 'cookie'); ?></div>
                        <div class="form-controls"><input type="text" class="xlarge" id="what_are_link" name="what_are_link" value="<?php echo osc_get_preference('what_are_link', 'cookie'); ?>" /></div>
                    </div>
                    <div class="clear"></div>
                    <div class="form-actions">
                        <input type="submit" id="save_changes" value="<?php echo osc_esc_html( __('Save changes') ); ?>" class="btn btn-submit" />
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>