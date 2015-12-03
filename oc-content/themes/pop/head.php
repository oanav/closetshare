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
    'delete' => __('Delete', 'pop'),
    'cancel' => __('Cancel', 'pop')
);

osc_enqueue_script('jquery');
osc_enqueue_script('jquery-ui');
osc_register_script('global-theme-js', osc_current_web_theme_js_url('global.js'), 'jquery');
osc_register_script('delete-user-js', osc_current_web_theme_js_url('delete_user.js'), 'jquery-ui');
osc_enqueue_script('global-theme-js');
osc_register_script('ajaxload-js', osc_current_web_theme_js_url('ajax-load.js'));
osc_enqueue_script('ajaxload-js');
osc_register_script('location-js', osc_current_web_theme_js_url('location.js'));

osc_register_script('imagesloaded-js', osc_current_web_theme_js_url('imagesloaded.pkgd.min.js'));
osc_enqueue_script('imagesloaded-js');
osc_register_script('imgLiquid-js', osc_current_web_theme_js_url('imgLiquid-min.js'));
//osc_enqueue_script('imgLiquid-js');
osc_register_script('imagefill-js', osc_current_web_theme_js_url('jquery-imagefill.js'));
osc_enqueue_script('imagefill-js');
osc_register_script('masonry-js', osc_current_web_theme_js_url('masonry.pkgd.min.js'));
osc_enqueue_script('masonry-js');
osc_register_script('materialize-js', osc_current_web_theme_js_url('materialize.min.js'));
osc_enqueue_script('materialize-js');
osc_register_script('sweetalert', osc_current_web_theme_js_url('sweetalert/sweetalert.min.js'));
osc_enqueue_script('sweetalert');


 osc_register_script('salvattore-js', osc_current_web_theme_js_url('salvattore.min.js'));

?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<title><?php echo meta_title(); ?></title>
<meta name="title" content="<?php echo osc_esc_html(meta_title()); ?>" />
<?php if (meta_description() != '') { ?>
    <meta name="description" content="<?php echo osc_esc_html(meta_description()); ?>" />
<?php } ?>
<?php if (meta_keywords() != '') { ?>
    <meta name="keywords" content="<?php echo osc_esc_html(meta_keywords()); ?>" />
<?php } ?>
<?php if (osc_get_canonical() != '') { ?>
    <!-- canonical -->
    <link rel="canonical" href="<?php echo osc_get_canonical(); ?>"/>
    <!-- /canonical -->
<?php } ?>
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="Fri, Jan 01 1970 00:00:00 GMT" />

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<!-- favicon -->
<link rel="shortcut icon" href="<?php echo osc_current_web_theme_url('favicon/favicon-48.png'); ?>" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo osc_current_web_theme_url('favicon/favicon-144.png'); ?>" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo osc_current_web_theme_url('favicon/favicon-114.png'); ?>" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo osc_current_web_theme_url('favicon/favicon-72.png'); ?>" />
<link rel="apple-touch-icon-precomposed" href="<?php echo osc_current_web_theme_url('favicon/favicon-57.png'); ?>" />
<!-- /favicon -->

<meta name="msvalidate.01" content="F758CB20C5DA2423684B3C83F75FD10F" />

<?php /* openGrapth meta tags */ ?>
<meta property="og:type" content="website">
<meta property="og:image" content="<?php echo pop_meta_image(); ?>">
<meta property="og:title" content="<?php echo osc_esc_html(meta_title()); ?>">
<meta property="og:description" content="<?php echo osc_esc_html(meta_description()); ?>">

<link href="<?php echo osc_current_web_theme_url('js/jquery-ui/jquery-ui-1.10.2.custom.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo osc_current_web_theme_url('js/sweetalert/sweetalert.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo osc_current_web_theme_url('fonts/font-awesome-4.3.0/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

<script type="text/javascript">
    var pop = window.pop || {};
    pop.base_url = '<?php echo osc_base_url(true); ?>';
    pop.langs = <?php echo json_encode($js_lang); ?>;
    pop.fancybox_prev = '<?php echo osc_esc_js(__('Previous image', 'pop')) ?>';
    pop.fancybox_next = '<?php echo osc_esc_js(__('Next image', 'pop')) ?>';
    pop.fancybox_closeBtn = '<?php echo osc_esc_js(__('Close', 'pop')) ?>';
</script>
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('css/pure-min.css'); ?>" type=text/css">
<!--[if lte IE 8]>
    <link rel="stylesheet" href="<?php echo osc_current_web_theme_url('css/grids-responsive-old-ie-min.css'); ?>">
<![endif]-->
<!--[if gt IE 8]><!-->
<link rel="stylesheet" href="<?php echo osc_current_web_theme_url('css/grids-responsive-min.css'); ?>">
<!--<![endif]-->
<link href="<?php echo osc_current_web_theme_url('css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />

<link href="<?php echo osc_current_web_theme_url('sass/main.css'); ?>" rel="stylesheet" type="text/css" />

<?php osc_run_hook('header'); ?>