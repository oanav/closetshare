<?php
/*
Plugin Name: Success page/ Item success
Plugin URI: http://www.osclass.org/
Description: Success page
Version: 1.1.0
Author: Osclass
Author URI: http://www.osclass.org/
Short Name: Success page
Plugin update URI: item_success
*/

function item_success_install() {
    osc_set_preference('item_success_version', '100', 'item_success', 'STRING');

}
function item_success_uninstall() {
    osc_delete_preference('item_success_add_meta_og', 'item_success');
    osc_delete_preference('item_success_version', 'item_success');
}
osc_register_plugin(osc_plugin_path(__FILE__), 'market_install');
osc_add_hook(osc_plugin_path(__FILE__) . "_uninstall", 'market_uninstall');




function item_success_update_version() {
    $version = osc_get_preference('item_success_version', 'item_success');
    if ($version == '') {
        $version = 0;
    }
    if ($version < 110 ) {
        osc_set_preference('item_success_add_meta_og', 'true', 'item_success', 'BOOLEAN');
        osc_set_preference('item_success_version', '110', 'item_success', 'STRING');
        osc_reset_preferences();
    }
}
osc_add_hook('init', 'market_update_version');


if(OC_ADMIN) {
    function item_success_admin_menu() {
        osc_add_admin_submenu_divider('plugins', 'Social item success', 'item_success_divider', 'administrator');
        osc_admin_menu_plugins('» Settings', osc_admin_render_plugin_url('item_success/admin/settings.php'), 'item_success_settings', 'administrator');
    }
    osc_add_hook('admin_menu_init', 'item_success_admin_menu');

    function item_success_admin_title() {
        if(Params::getParam('file') == 'item_success/admin/settings.php') {
            osc_add_hook('custom_plugin_title',     'item_success_admin_page_header');
            osc_add_hook('admin_title',                  'item_success_admin_page_title');
        }
    }
    osc_add_hook('init', 'item_success_admin_title');
    function item_success_admin_page_header($text) {
        return __('Social item success settings', 'item_success');
    }
    function item_success_admin_page_title($text) {
        return __('Social item success settings - Osclass', 'item_success');
    }
}

// route /item-success
osc_add_route('item-success', 'item-success$', 'item-success', 'item_success/item-success.php', false, 'custom', 'custom', __('Thank you', 'item_success') );

//valiadate item
osc_add_hook('init', 'item_success_item_validate');
function item_success_item_validate() {
    if( Params::getParam('page')=='item' && Params::getParam('action')=='activate') {
        $secret  = Params::getParam('secret');
        $id        = Params::getParam('id');
        $item    = Item::newInstance()->listWhere("i.pk_i_id = '%s' AND ((i.s_secret = '%s') OR (i.fk_i_user_id = '%d'))", addslashes($id), addslashes($secret), addslashes(osc_logged_user_id()));

        // item doesn't exist
        if( count($item) == 0 ) {
            Rewrite::newInstance()->set_location('error');
            header('HTTP/1.1 404 Not Found');
            osc_current_web_theme_path('404.php');
            exit;
        }

        View::newInstance()->_exportVariableToView('item', $item[0]);
        if( $item[0]['b_active'] == 0 ) {
            // ACTIVETE ITEM
            $mItems = new ItemActions(false);
            $success = $mItems->activate( $item[0]['pk_i_id'], $item[0]['s_secret'] );

            if( $success ) {
                osc_add_flash_ok_message( _m('The listing has been validated') );
                item_success_redirect(Item::newInstance()->findByPrimaryKey($item[0]['pk_i_id']) );
                exit;
            }else{
                osc_add_flash_error_message( _m("The listing can't be validated") );
            }
        } else {
            osc_add_flash_warning_message( _m('The listing has already been validated') );
        }
        osc_redirect_to(osc_item_url());
    }
}

function item_success_redirect($item) {
    if(!OC_ADMIN) {
        if( isset($item['pk_i_id']) ) {
            Session::newInstance()->_dropKeepForm();

            if($item['b_active']==0) {
                osc_add_flash_ok_message( _m('Check your inbox to validate your listing') );
            } else {
                // only if enabled and active can show item-success page
                if($item['b_active']==1 && $item['b_enabled']==1) {
                    // item-success redirect
                    Session::newInstance()->_set('inserted_item', $item);
                    osc_redirect_to( osc_route_url('item-success') );
                    exit;
                }
            }

            $itemId  = Params::getParam('itemId');

            $category = Category::newInstance()->findByPrimaryKey(Params::getParam('catId'));
            View::newInstance()->_exportVariableToView('category', $category);
            osc_redirect_to(osc_search_category_url());
        }
    }
}
osc_add_hook('posted_item', 'item_success_redirect', 10);


function item_success_share_buttons($url, $id) {
    ?>
    <style>

        #share-nav .share-buttons.v2 {
            float: none;
            padding-bottom: 0px !important;
            margin-bottom: 0px !important;
            padding-top: 0px !important;
            font-size: 14px;
        }

        #share-nav .share-buttons {
            display: inline-block;
        }

        .primary-shares {
            display: inline-block;
            width: 760px;
        }

        .share-buttons div, .share-buttons a {
            vertical-align: middle;
            text-decoration: none;
        }


        #share-nav .facebook, #share-nav .twitter, #share-nav .google_plus {
            margin-right: 8px !important;
            line-height: 34px;
            margin-top: 5px;
            height: 34px;
            width: 48px;
            color: #fff;
        }

        .share-buttons.v2 .facebook {
            background: #2d609b;
            color: transparent;
        }

        .share-buttons.v2 .facebook,
        .share-buttons.v2 .twitter,
        .share-buttons.v2 .google_plus {
            font-size: 14px;
            text-rendering: optimizeLegibility;
            margin-right: 2px;
            line-height: 41px;
            font-family: "ProximaNovaRegular";
            font-weight: 500;
            width: 30px;
        }

        .share-buttons.v2 .facebook,
        .share-buttons.v2 .twitter,
        .share-buttons.v2 .google_plus {
            border-radius: 2px;
            margin-right: 4px;
            background: #c5c5c5;
            position: relative;
            display: inline-block;
            cursor: pointer;
            height: 41px;
            width: 41px;
            color: #fff;
        }

        #share-nav .share-buttons.v2 .expanded-text, #share-nav .share-buttons.v2 .primary-text {
            display: inline;
            font-weight: bold;
        }

        .share-buttons.v2 span {
            vertical-align: top;
        }

        #share-nav .share-buttons.v2 .facebook {
            color: #fff;
        }
        #share-nav .facebook,
        #share-nav .google_plus,
        #share-nav .twitter {
            line-height: 34px;
            color: #fff;
        }

        .share-buttons.v2 .facebook,
        .share-buttons.v2 .twitter ,
        .share-buttons.v2 .google_plus {
            font-size: 14px;
            line-height: 41px;
            font-family: "ProximaNovaRegular";
            font-weight: 500;
        }

        #share-nav .share-buttons.v2 .twitter {
            width: 168px;
            color: #fff;
        }

        #share-nav .share-buttons.v2 .google_plus {
            width: 180px;
            color: #fff;

        }
        #share-nav .share-buttons.v2 .facebook {
            width: 183px;
            color: #fff;
        }

        .share-buttons.v2 .twitter {
            background: #00c3f3;
        }
        .share-buttons.v2 .facebook {
            background: #2d609b;
        }
        .share-buttons.v2 .google_plus {
            background: #eb4026;
        }
        .fa {
            font-size: 24px;
            line-height: 34px;
        }
    </style>

    <script>
        function shareTw() {
            var popUp = window.open("https://twitter.com/share?url=<?php echo urlencode($url).'&text='.urlencode(osc_item_title()); ?>", 'popupwindow', 'scrollbars=yes,width=800,height=400');
            popUp.focus();
            return false;
        }
        function shareFb() {
            var popUp = window.open("https://www.facebook.com/sharer.php?u=<?php echo urlencode($url); ?>&t=<?php echo urlencode(osc_item_title()); ?>", 'popupwindow', 'scrollbars=yes,width=800,height=400');
            popUp.focus();
            return false;
        }
        function shareGp() {
            var popUp = window.open("https://plus.google.com/share?url=<?php echo urlencode($url); ?>", 'popupwindow', 'scrollbars=yes,width=800,height=400');
            popUp.focus();
            return false;
        }
    </script>

    <div id="share-nav">
        <div class="share-buttons v2">
            <div class="primary-shares">
                <a class="social-share facebook" target="_blank" onclick="shareFb(); return false;" href="#">
                    <i class="fa fa-facebook-square"></i>
                    <span class="primary-text"><?php _e('Share on Facebook', 'item_success'); ?></span>
                </a>
                <a class="social-share twitter" onclick="shareTw(); return false;" href="#">
                    <i class="fa fa-twitter"></i>
                    <span class="primary-text"><?php _e('Share on Twitter', 'item_success'); ?></span>
                </a>
                <a class="social-share google_plus" onclick="shareGp(); return false;" href="#">
                    <i class="fa fa-google-plus"></i>
                    <span class="primary-text"><?php _e('Share on Google+', 'item_success'); ?></span>
                </a>
            </div>
        </div>
    </div>

    <?php
}

// add open graph meta data  -- if preference 'item_success_add_meta_og' is enabled  and is ad page
$_meta_og   = osc_get_preference('item_success_add_meta_og', 'item_success');
if($_meta_og=="true" && Params::getParam('page')=='item' && Params::getParam('action')=='') {
    osc_add_hook('header', 'item_success_meta_og');
}
function item_success_meta_og() {
    $image = null;
    $r         = ItemResource::newInstance()->getResource( osc_item_id() );
    if(isset($r['pk_i_id'])) {
        $image = (string) osc_base_url().$r['s_path'].$r['pk_i_id']."_thumbnail.".$r['s_extension'];
    }

    $_item = Item::newInstance()->findByPrimaryKey(osc_item_id());

?>
<meta property="og:title" content="<?php echo osc_esc_html( $_item['s_title'] ); ?>"/>
<meta property="og:url" content="<?php echo osc_item_url(); ?>"/>
<?php if($image!=null) { ?>
<meta property="og:image" content="<?php echo $image; ?>"/>
<?php } else { ?>
<meta property="og:image" content="<?php echo osc_plugin_url(true).'item_success/images/no_photo.gif'; ?>"/>
<?php } ?>
<meta property="og:site_name" content="<?php echo osc_esc_html(meta_title()); ?>"/>

<meta property="og:description" content="<?php echo osc_esc_html( osc_highlight($_item['s_description']) ) ; ?>"/>
<?php
}



?>