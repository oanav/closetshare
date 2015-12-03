<?php
/*
Plugin Name: Cookies warning
Plugin URI: https://github.com/conejoninja/osclass-plugin-cookies
Description: Show a warning message about the cookie usage (Cookie law)
Version: 1.0.0
Author: _CONEJO
Author URI: http://www.conejo.me/
Plugin update URI: cookies
Support URI: http://forums.osclass.org/plugins/(plugin)-european-cookie-law-plugin-(in-development)/
*/

/*       This program is free software: you can redistribute it and/or
 *     modify it under the terms of the GNU Affero General Public License
 *     as published by the Free Software Foundation, either version 3 of
 *            the License, or (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful, but
 *         WITHOUT ANY WARRANTY; without even the implied warranty of
 *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *             GNU Affero General Public License for more details.
 *
 *      You should have received a copy of the GNU Affero General Public
 * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


    osc_register_script('jquery-cookie', osc_plugin_url(__FILE__) . 'jquery.cookie.js', array('jquery'));
    osc_register_script('jquery-cookiecuttr', osc_plugin_url(__FILE__) . 'jquery.cookiecuttr.js', array('jquery', 'jquery-cookie'));
    osc_enqueue_style('cookiecuttr-style', osc_plugin_url(__FILE__) . 'cookiecuttr.css');
    osc_enqueue_script('jquery-cookiecuttr');

    function cookie_load() { ?>
        <script type="text/javascript" >
        $(document).ready(function () {
            var options = new Object();
            <?php
            if(osc_get_preference('accept', 'cookie')==1) { echo 'options.cookieAcceptButton = true;'; };
            if(osc_get_preference('decline', 'cookie')==1) { echo 'options.cookieDeclineButton = true;'; };
            if(osc_get_preference('reset', 'cookie')==1) { echo 'options.cookieResetButton = true;'; };
            echo "options.cookiePolicyLink = '".osc_esc_js(osc_get_preference('policy_link', 'cookie'))."';";
            echo "options.cookieWhatAreTheyLink = '".osc_esc_js(osc_get_preference('what_are_link', 'cookie'))."';";
            echo "options.cookieAnalyticsMessage = '".str_replace("'", "\'", osc_get_preference('analytics_msg', 'cookie'))."';";
            echo "options.cookieMessage = '".str_replace("'", "\'", osc_get_preference('non_analytics_msg', 'cookie'))."';";
            if(osc_get_preference('analytics_id', 'cookie')!='') { ?>
            options.cookieAnalytics = true;
            if (jQuery.cookie('cc_cookie_decline') == "cc_cookie_decline") {
            } else {
                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', '<?php echo osc_get_preference('analytics_id', 'cookie'); ?>']);
                _gaq.push(['_trackPageview']);

                (function() {
                    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document. getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                })();
            }
            <?php } else {
            echo 'options.cookieAnalytics = false;';
            }; ?>
            $.cookieCuttr(options);
        });
        </script>
    <?php
    }

    function cookie_menu() {
        osc_admin_menu_plugins('Cookies settings', osc_route_admin_url('cookie-conf'), 'cookie-conf');
    }

    function cookie_install() {
        osc_set_preference('analytics_msg', 'We use cookies, just to track visits to our website, we store no personal details.', 'cookie', 'STRING');
        osc_set_preference('non_analytics_msg', 'We use cookies on this website, you can <a href="{{cookiePolicyLink}}" title="read about our cookies">read about them here</a>. To use the website as intended please...', 'cookie', 'STRING');
        osc_set_preference('analytics_id', '', 'cookie', 'STRING');
        osc_set_preference('policy_link', osc_base_url(), 'cookie', 'STRING');
        osc_set_preference('what_are_link', 'http://www.allaboutcookies.org/', 'cookie', 'STRING');
        osc_set_preference('domain', '', 'cookie', 'STRING');
        osc_set_preference('accept', 1, 'cookie', 'BOOLEAN');
        osc_set_preference('decline', 1, 'cookie', 'BOOLEAN');
        osc_set_preference('reset', 0, 'cookie', 'BOOLEAN');
    }

    function cookie_uninstall() {
        Preference::newInstance()->delete(array('s_section' => 'cookie'));
    }


    osc_add_route('cookie-conf', 'cookie/conf', 'cookie/conf', osc_plugin_folder(__FILE__).'admin/conf.php');

    osc_register_plugin(osc_plugin_path(__FILE__), 'cookie_install');
    osc_add_hook(osc_plugin_path(__FILE__)."_uninstall", 'cookie_uninstall');
    if(OC_ADMIN!=1) {
        osc_add_hook('header', 'cookie_load', 10);
    }
    osc_add_hook('admin_menu_init', 'cookie_menu');

?>
