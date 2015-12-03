<?php
    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2014 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
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
?>
<?php
    $js_lang = array(
        'delete' => __('Delete', 'osclasswizards'),
        'cancel' => __('Cancel', 'osclasswizards')
    );

    osc_enqueue_script('jquery');
    osc_enqueue_script('jquery-ui');
    osc_register_script('global-theme-js', osc_current_web_theme_js_url('global.js'), 'jquery');
    osc_register_script('delete-user-js', osc_current_web_theme_js_url('delete_user.js'), 'jquery-ui');
    osc_enqueue_script('global-theme-js');
	osc_enqueue_script('bootstrap-theme-js');
	osc_register_script('bootstrap-theme-js', osc_current_web_theme_js_url('bootstrap.min.js'), 'jquery');
	osc_enqueue_script('select-theme-js');
	osc_register_script('select-theme-js', osc_current_web_theme_js_url('select.js'), 'jquery');
	osc_enqueue_script('checkbox-theme-js');
	osc_register_script('checkbox-theme-js', osc_current_web_theme_js_url('checkbox.js'), 'jquery');
?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<?php osc_run_hook('osclasswizards_head'); ?>

<?php if( osc_get_canonical() != '' ) { ?>
<!-- canonical -->
<link rel="canonical" href="<?php echo osc_get_canonical(); ?>"/>
<!-- /canonical -->
<?php } ?>
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="Fri, Jan 01 1970 00:00:00 GMT" />
<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<?php echo osclasswizards_favicon(); ?>
<link href="<?php echo osc_current_web_theme_url('js/jquery-ui/jquery-ui-1.10.2.custom.min.css') ; ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    var osclasswizards = window.osclasswizards || {};
    osclasswizards.base_url = '<?php echo osc_base_url(true); ?>';
    osclasswizards.langs = <?php echo json_encode($js_lang); ?>;
    osclasswizards.fancybox_prev = '<?php echo osc_esc_js( __('Previous image','osclasswizards')) ?>';
    osclasswizards.fancybox_next = '<?php echo osc_esc_js( __('Next image','osclasswizards')) ?>';
    osclasswizards.fancybox_closeBtn = '<?php echo osc_esc_js( __('Close','osclasswizards')) ?>';
</script>
<link href="<?php echo osc_current_web_theme_url('css/bootstrap.min.css') ; ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo osc_current_web_theme_url('css/main.css') ; ?>" rel="stylesheet" type="text/css" />
<?php if(osc_get_preference('rtl_view', 'osclasswizards_theme') == "1") { ?>
<link href="<?php echo osc_current_web_theme_url('css/rtl.css') ; ?>" rel="stylesheet" type="text/css" />
<?php } ?>
<link href="<?php echo osc_current_web_theme_url('css/apps.css') ; ?>" rel="stylesheet" type="text/css" />

<link href="<?php echo osc_current_web_theme_url('css/mobile.css') ; ?>" rel="stylesheet" type="text/css" />
<?php osc_run_hook('header') ; ?>
