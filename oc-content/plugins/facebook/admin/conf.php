<?php

    /**
     * OSClass – software for creating and publishing online classified advertising platforms
     *
     * Copyright (C) 2010 OSCLASS
     *
     * This program is free software: you can redistribute it and/or modify it under the terms
     * of the GNU Affero General Public License as published by the Free Software Foundation,
     * either version 3 of the License, or (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
     * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
     * See the GNU Affero General Public License for more details.
     *
     * You should have received a copy of the GNU Affero General Public
     * License along with this program. If not, see <http://www.gnu.org/licenses/>.
     */

    if( Params::getParam('plugin_action') == 'done' ) {
        osc_set_preference('fbc_appId',  Params::getParam('fbc_appId'),  'facebook_connect', 'STRING') ;
        osc_set_preference('fbc_secret', Params::getParam('fbc_secret'), 'facebook_connect', 'STRING') ;

        if(osc_version()<300) {
            echo '<div style="text-align:center; font-size:22px; background-color:#00bb00;"><p>' . __('Congratulations. The plugin is now configured','facebook') . '.</p></div>' ;
            osc_reset_preferences();
        } else {
            ob_get_clean();
            osc_add_flash_ok_message(__('Congratulations. The plugin is now configured', 'facebook'), 'admin');
            osc_admin_render_plugin(osc_plugin_folder(__FILE__) . 'conf.php');
        }


    }

?>
<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
    <div style="padding: 20px;">
        <div style="float: left; width: 50%;">
            <fieldset>
                <h2><?php _e('Facebook Options', 'facebook') ; ?></h2>
                    <form name="fb_form" id="fb_form" action="<?php echo osc_admin_base_url(true) ; ?>" method="GET" enctype="multipart/form-data" >
                    <input type="hidden" name="page" value="plugins" />
                    <input type="hidden" name="action" value="renderplugin" />
                    <input type="hidden" name="file" value="facebook/admin/conf.php" />
                    <input type="hidden" name="plugin_action" value="done" />
                    <?php _e("Please enter your Facebook appId and secret*:", 'facebook') ; ?><br />
                    <p style="display: table; height: 26px;"><label style="width: 60px; display: table-cell; vertical-align: middle; text-align: center;">appId:</label> <input type="text" name="fbc_appId" id="fbc_appId" value="<?php echo osc_get_preference('fbc_appId','facebook_connect') ; ?>" maxlength="100" size="60" /></p>
                    <p style="display: table; height: 26px;"><label style="width: 60px; display: table-cell; vertical-align: middle; text-align: center;">secret:</label> <input type="text" name="fbc_secret" id="fbc_secret" value="<?php echo osc_get_preference('fbc_secret', 'facebook_connect') ; ?>" maxlength="100" size="60" /></p>
                    <button class="btn" type="submit"><?php _e('Update', 'facebook') ; ?></button>
                    </form>
            </fieldset>
        </div>
        <div style="float: left; width: 50%;">
            <fieldset>
            <h2><?php _e("Facebook Connect Help", 'facebook') ; ?></h2>

            <h3><?php _e("What is Facebook Connect Plugin?", 'facebook') ; ?></h3>
            <?php _e("Facebook Connect plugin allows your users to log into your webpage with their Facebook accounts", 'facebook') ; ?>.
            <br/>
            <br/>
            <h3><?php _e("Using Facebook login", 'facebook') ; ?></h3>
            <?php _e('You can freely obtain an appId and secret key (needed to use Facebook login on your website) after signing up on this URL','facebook') ; ?>: <a rel="nofollow" target="_blank" href="http://www.facebook.com/developers/createapp.php">http://www.facebook.com/developers/createapp.php</a><br />
            <?php _e("In order to use Facebook login in your website you should include at least one facebook button for login (and logout). To do that place the following code where you want it to appear",'facebook') ; ?>:<br/>
            <pre>
            &lt;?php fbc_button(); ?&gt;
            </pre>
            <br />
            <div style="font-size: small;"><strong>*</strong> <?php _e('You can freely obtain an appId and secret key after signing up on this URL') ; ?>: <a rel="nofollow" target="_blank" href="http://www.facebook.com/developers/createapp.php">http://www.facebook.com/developers/createapp.php</a>.</div>
            <br/>
            </fieldset>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>