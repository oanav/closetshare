<?php
/*
Plugin Name: Facebook Connect
Plugin URI: http://www.osclass.org/
Description: Use Facebook to connect and log in your users accounts
Version: 1.4.1
Author: OSClass
Author URI: http://www.osclass.org/
Short Name: facebook
Plugin update URI: facebook-connect
*/

    require_once dirname( __FILE__ ) . '/OSCFacebook.php';

    function fbc_init() {
        $facebook = OSCFacebook::newInstance()->init();
    }

    /**
     * Just in case you want to customize the login button with some image
     *
     * @return string Facebook login url
     */
    function fbc_login_url() {
        return OSCFacebook::newInstance()->loginUrl();
    }

    function fbc_button() {
        if( !osc_is_web_user_logged_in() ) {
            echo '<div><a href="' . OSCFacebook::newInstance()->loginUrl() . '">' . __( 'Login with Facebook', 'facebook' ) . '</a></div>';
        } else {
            Header("Refresh:0"); //refresh page
        }
    }

    function fbc_call_after_install() {
        OSCFacebook::newInstance()->import( 'facebook/struct.sql' );
        osc_set_preference('fbc_appId' , '', 'facebook_connect', 'STRING');
        osc_set_preference('fbc_secret', '', 'facebook_connect', 'STRING');
    }

    function fbc_call_after_uninstall() {
        OSCFacebook::newInstance()->uninstall();
        osc_delete_preference( 'fbc_appId' , 'facebook_connect' );
        osc_delete_preference( 'fbc_secret', 'facebook_connect' );
    }

    function fbc_delete_user( $userID ) {
        $osc = OSCFacebook::newInstance();
        $osc->resetCookies();
        $osc->deleteByPrimaryKey( $userID );
    }

    // LOGOUT in 3.1+ versions
    function fbc_logout() {
        OSCFacebook::newInstance()->resetCookies();
    }

    // LOGOUT in 2.x and 3.0.x versions
    function fbc_check_logout() {
        if(Params::getParam("page")=="main" && Params::getParam("action")=="logout" && osc_version()<310) {
            OSCFacebook::newInstance()->resetCookies();
        }
    }

    // Display help
    function fbc_conf() {
        osc_admin_render_plugin( osc_plugin_path( dirname(__FILE__) ) . '/admin/conf.php' );
    }

    // extend manage users
    function fbc_extend_manage_users($row, $aRow) {
        $user_id = $aRow['pk_i_id'];
        $user_exist = false;
        $manager = User::newInstance();
        $manager->dao->select();
        $manager->dao->from( DB_TABLE_PREFIX.'t_facebook_connect' );
        $manager->dao->where( 'fk_i_user_id', $user_id );
        $result = $manager->dao->get();
        if($result != false) {
            if($result->result()!=array()) {
                $row['email'] = $row['email'] . ' - '. __('via facebook', 'facebook') ;
            }
        }
        return $row;
    }
    osc_add_filter('users_processing_row', 'fbc_extend_manage_users');

    // extend email subject
    function fbc_extend_email_title($title) {
        return $title . ' - '. __('via facebook', 'facebook') ;
    }
    function fbc_extend_email($user) {
        $manager = User::newInstance();
        $manager->dao->select();
        $manager->dao->from( DB_TABLE_PREFIX.'t_facebook_connect' );
        $manager->dao->where( 'fk_i_user_id', $user['pk_i_id'] );
        $result = $manager->dao->get();
        if($result != false) {
            if($result->result()!=array()) {
                osc_add_filter('email_user_registration_title', 'fbc_extend_email_title');
            }
        }
    }
    osc_add_hook('hook_email_user_registration', 'fbc_extend_email', 4);
    osc_add_hook('hook_email_admin_new_user', 'fbc_extend_email', 4);

    // This is needed in order to be able to activate the plugin
    osc_register_plugin( osc_plugin_path( __FILE__ ), 'fbc_call_after_install' );
    // This is a hack to show a Configure link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook( osc_plugin_path( __FILE__ ) . '_configure', 'fbc_conf' );
    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook( osc_plugin_path( __FILE__ ) . '_uninstall', 'fbc_call_after_uninstall' );

    osc_add_hook('before_html', 'fbc_init');
    osc_add_hook('delete_user', 'fbc_delete_user');
    osc_add_hook('init',        'fbc_check_logout');
    osc_add_hook('logout',      'fbc_logout');

    /* file end: ./oc-content/plugins/facebook/index.php */
?>
