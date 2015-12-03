<?php
/* DEFINES */
define('POP_THEME_VERSION', '0.1');
if (!osc_get_preference('keyword_placeholder', 'pop_theme')) {
    osc_set_preference('keyword_placeholder', __('ie. PHP Programmer', 'pop'), 'pop_theme');
}
osc_register_script('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.pack.js'), array('jquery'));
osc_enqueue_style('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.css'));
osc_enqueue_script('fancybox');

osc_enqueue_style('font-awesome', osc_current_web_theme_url('css/font-awesome-4.1.0/css/font-awesome.min.css'));
// used for date/dateinterval custom fields
osc_enqueue_script('php-date');
if (!OC_ADMIN) {
    osc_enqueue_style('fine-uploader-css', osc_assets_url('js/fineuploader/fineuploader.css'));
    osc_enqueue_style('pop-fine-uploader-css', osc_current_web_theme_url('css/ajax-uploader.css'));
}
osc_enqueue_script('jquery-fineuploader');

osc_register_script('jquery-bxslider', osc_current_web_theme_js_url('jquery.bxslider.js'));
osc_register_script('jquery-metadata', osc_current_web_theme_js_url('jquery.metadata.js'));
osc_register_script('bootstrap-js', osc_current_web_theme_js_url('bootstrap.js'));
osc_enqueue_script('bootstrap-js');


/* FUNCTIONS */
// install options
if (!function_exists('pop_theme_install')) {

    function pop_theme_install() {
        osc_set_preference('keyword_placeholder', __('Search ...', 'pop'), 'pop_theme');
        osc_set_preference('version', POP_THEME_VERSION, 'pop_theme');
        osc_set_preference('footer_link', '1', 'pop_theme');
        osc_set_preference('donation', '0', 'pop_theme');
        osc_set_preference('pop_max_premium', '2', 'pop_theme');
        osc_set_preference('logo', '', 'pop_theme');
        osc_reset_preferences();
    }

}

// uninstall
if (!function_exists('pop_theme_delete')) {
    function pop_theme_delete() {
        Preference::newInstance()->delete(array('s_section' => 'pop_theme'));
    }
}
osc_add_hook('theme_delete_pop', 'pop_theme_delete' );

// update options
if (!function_exists('pop_theme_update')) {

    function pop_theme_update() {

    }

}


if (!function_exists('check_install_pop_theme')) {

    function check_install_pop_theme() {
        $current_version = osc_get_preference('version', 'pop_theme');
        //check if current version is installed or need an update<
        if (!$current_version) {
            pop_theme_install();
        } else if ($current_version < POP_THEME_VERSION) {
            pop_theme_update();
        }
    }

}

if (!function_exists('pop_add_body_class_construct')) {

    function pop_add_body_class_construct($classes) {
        $popBodyClass = popBodyClass::newInstance();
        $classes = array_merge($classes, $popBodyClass->get());
        return $classes;
    }

}

if (!function_exists('pop_body_class')) {

    function pop_body_class($echo = true) {
        /**
         * Print body classes.
         *
         * @param string $echo Optional parameter.
         * @return print string with all body classes concatenated
         */
        osc_add_filter('pop_bodyClass', 'pop_add_body_class_construct');
        $classes = osc_apply_filter('pop_bodyClass', array());
        if ($echo && count($classes)) {
            echo 'class="' . implode(' ', $classes) . '"';
        } else {
            return $classes;
        }
    }

}
if (!function_exists('pop_add_body_class')) {

    function pop_add_body_class($class) {
        /**
         * Add new body class to body class array.
         *
         * @param string $class required parameter.
         */
        $popBodyClass = popBodyClass::newInstance();
        $popBodyClass->add($class);
    }

}
if (!function_exists('pop_nofollow_construct')) {

    /**
     * Hook for header, meta tags robots nofollos
     */
    function pop_nofollow_construct() {
        echo '<meta name="robots" content="noindex, nofollow, noarchive" />' . PHP_EOL;
        echo '<meta name="googlebot" content="noindex, nofollow, noarchive" />' . PHP_EOL;
    }

}
if (!function_exists('pop_follow_construct')) {

    /**
     * Hook for header, meta tags robots follow
     */
    function pop_follow_construct() {
        echo '<meta name="robots" content="index, follow" />' . PHP_EOL;
        echo '<meta name="googlebot" content="index, follow" />' . PHP_EOL;
    }

}
/* logo */
if (!function_exists('logo_header')) {

    function logo_header() {
        $logo = osc_get_preference('logo', 'pop_theme');
        $html = '<a class="logo" href="' . osc_base_url() . '"><img border="0" alt="' . osc_page_title() . '" src="' . pop_logo_url() . '" /></a>';
        if ($logo != '' && file_exists(osc_uploads_path() . $logo)) {
            return $html;
        } else {
            return $html;
            return '<a href="' . osc_base_url() . '">' . osc_page_title() . '</a>';
        }
    }

}
/* logo */
if (!function_exists('pop_logo_url')) {

    function pop_logo_url() {
        $logo = osc_get_preference('logo', 'pop_theme');

        if ($logo!='') {
            return osc_uploads_url($logo);
        }
        return osc_current_web_theme_url('images/compact-logo.png');
    }

}
if (!function_exists('pop_draw_item')) {

    function pop_draw_item($class = false, $admin = false, $premium = false) {
        $filename = 'loop-single';
        if ($premium) {
            $filename .='-premium';
        }
        require WebThemes::newInstance()->getCurrentThemePath() . $filename . '.php';
    }

}
if (!function_exists('pop_show_as')) {

    function pop_show_as() {

        $p_sShowAs = Params::getParam('sShowAs');
        $aValidShowAsValues = array('list', 'gallery');
        if (!in_array($p_sShowAs, $aValidShowAsValues)) {
            $p_sShowAs = pop_default_show_as();
        }

        return $p_sShowAs;
    }

}
if (!function_exists('pop_default_show_as')) {

    function pop_default_show_as() {
        return getPreference('defaultShowAs@all', 'pop_theme');
    }

}
if (!function_exists('pop_draw_categories_list')) {

    function pop_draw_categories_list() {
        ?>
        <?php
        if (!osc_is_home_page()) {
            echo '<div class="resp-wrapper">';
        }
        ?>
        <?php
        //cell_3
        $total_categories = osc_count_categories();
        $col1_max_cat = ceil($total_categories / 3);

        osc_goto_first_category();
        $i = 0;

        while (osc_has_categories()) {
            ?>
            <?php
            if ($i % $col1_max_cat == 0) {
                if ($i > 0) {
                    echo '</div>';
                }
                if ($i == 0) {
                    echo '<div class="cell_3 first_cel">';
                } else {
                    echo '<div class="cell_3">';
                }
            }
            ?>
            <ul class="r-list">
                <li>
                    <h1>
                        <?php
                        $_slug = osc_category_slug();
                        $_url = osc_search_category_url();
                        $_name = osc_category_name();
                        $_total_items = osc_category_total_items();
                        if (osc_count_subcategories() > 0) {
                            ?>
                            <span class="collapse resp-toogle"><i class="fa fa-caret-right fa-lg"></i></span>
                        <?php } ?>
                        <?php if ($_total_items > 0) { ?>
                            <a class="category <?php echo $_slug; ?>" href="<?php echo $_url; ?>"><?php echo $_name; ?></a> <span>(<?php echo $_total_items; ?>)</span>
                        <?php } else { ?>
                            <a class="category <?php echo $_slug; ?>" href="#"><?php echo $_name; ?></a> <span>(<?php echo $_total_items; ?>)</span>
                        <?php } ?>
                    </h1>
                    <?php if (osc_count_subcategories() > 0) { ?>
                        <ul>
                            <?php while (osc_has_subcategories()) { ?>
                                <li>
                                    <?php if (osc_category_total_items() > 0) { ?>
                                        <a class="category sub-category <?php echo osc_category_slug(); ?>" href="<?php echo osc_search_category_url(); ?>"><?php echo osc_category_name(); ?></a> <span>(<?php echo osc_category_total_items(); ?>)</span>
                                    <?php } else { ?>
                                        <a class="category sub-category <?php echo osc_category_slug(); ?>" href="#"><?php echo osc_category_name(); ?></a> <span>(<?php echo osc_category_total_items(); ?>)</span>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
            </ul>
            <?php
            $i++;
        }
        echo '</div>';
        ?>
        <?php
        if (!osc_is_home_page()) {
            echo '</div>';
        }
        ?>
        <?php
    }

}
if (!function_exists('pop_search_number')) {

    /**
     *
     * @return array
     */
    function pop_search_number() {
        $search_from = ((osc_search_page() * osc_default_results_per_page_at_search()) + 1);
        $search_to = ((osc_search_page() + 1) * osc_default_results_per_page_at_search());
        if ($search_to > osc_search_total_items()) {
            $search_to = osc_search_total_items();
        }

        return array(
            'from' => $search_from,
            'to' => $search_to,
            'of' => osc_search_total_items()
        );
    }

}
/*
 * Helpers used at view
 */
if (!function_exists('pop_item_title')) {

    function pop_item_title() {
        $title = osc_item_title();
        foreach (osc_get_locales() as $locale) {
            if (Session::newInstance()->_getForm('title') != "") {
                $title_ = Session::newInstance()->_getForm('title');
                if (@$title_[$locale['pk_c_code']] != "") {
                    $title = $title_[$locale['pk_c_code']];
                }
            }
        }
        return $title;
    }

}
if (!function_exists('pop_item_description')) {

    function pop_item_description() {
        $description = osc_item_description();
        foreach (osc_get_locales() as $locale) {
            if (Session::newInstance()->_getForm('description') != "") {
                $description_ = Session::newInstance()->_getForm('description');
                if (@$description_[$locale['pk_c_code']] != "") {
                    $description = $description_[$locale['pk_c_code']];
                }
            }
        }
        return $description;
    }

}
if (!function_exists('osc_item_deactivate_url')) {
    function osc_item_deactivate_url($secret = '', $id = '') {
        if ($id == '') { $id = osc_item_id(); };
        
        return osc_base_url(true) . '?page=item&action=deactivate&id=' . $id . ($secret != '' ? '&secret=' . $secret : '');
    }
}

if (!function_exists('related_listings')) {

    function related_listings() {
        View::newInstance()->_exportVariableToView('items', array());

        $mSearch = new Search();
        $mSearch->addCategory(osc_item_category_id());
        $mSearch->addRegion(osc_item_region());
        $mSearch->addItemConditions(sprintf("%st_item.pk_i_id < %s ", DB_TABLE_PREFIX, osc_item_id()));
        $mSearch->limit('0', '3');

        $aItems = $mSearch->doSearch();
        $iTotalItems = count($aItems);
        if ($iTotalItems == 3) {
            View::newInstance()->_exportVariableToView('items', $aItems);
            return $iTotalItems;
        }
        unset($mSearch);

        $mSearch = new Search();
        $mSearch->addCategory(osc_item_category_id());
        $mSearch->addItemConditions(sprintf("%st_item.pk_i_id != %s ", DB_TABLE_PREFIX, osc_item_id()));
        $mSearch->limit('0', '3');

        $aItems = $mSearch->doSearch();
        $iTotalItems = count($aItems);
        if ($iTotalItems > 0) {
            View::newInstance()->_exportVariableToView('items', $aItems);
            return $iTotalItems;
        }
        unset($mSearch);

        return 0;
    }

}

if (!function_exists('osc_is_contact_page')) {

    function osc_is_contact_page() {
        if (Rewrite::newInstance()->get_location() === 'contact') {
            return true;
        }

        return false;
    }

}

if (!function_exists('get_breadcrumb_lang')) {

    function get_breadcrumb_lang() {
        $lang = array();
        $lang['item_add'] = __('Publish a listing', 'pop');
        $lang['item_edit'] = __('Edit your listing', 'pop');
        $lang['item_send_friend'] = __('Send to a friend', 'pop');
        $lang['item_contact'] = __('Contact publisher', 'pop');
        $lang['search'] = __('Search results', 'pop');
        $lang['search_pattern'] = __('Search results: %s', 'pop');
        $lang['user_dashboard'] = __('Dashboard', 'pop');
        $lang['user_dashboard_profile'] = __("%s's profile", 'pop');
        $lang['user_account'] = __('Account', 'pop');
        $lang['user_items'] = __('Listings', 'pop');
        $lang['user_alerts'] = __('Alerts', 'pop');
        $lang['user_profile'] = __('Update account', 'pop');
        $lang['user_change_email'] = __('Change email', 'pop');
        $lang['user_change_username'] = __('Change username', 'pop');
        $lang['user_change_password'] = __('Change password', 'pop');
        $lang['login'] = __('Login', 'pop');
        $lang['login_recover'] = __('Recover password', 'pop');
        $lang['login_forgot'] = __('Change password', 'pop');
        $lang['register'] = __('Create a new account', 'pop');
        $lang['contact'] = __('Contact', 'pop');
        return $lang;
    }

}

if (!function_exists('user_dashboard_redirect')) {

    function user_dashboard_redirect() {
        $page = Params::getParam('page');
        $action = Params::getParam('action');
        if ($page == 'user' && $action == 'dashboard') {
            if (ob_get_length() > 0) {
                ob_end_flush();
            }
            header("Location: " . osc_user_list_items_url(), TRUE, 301);
        }
    }

    osc_add_hook('init', 'user_dashboard_redirect');
}

if (!function_exists('get_user_menu')) {

    function get_user_menu() {
        $options = array();
        //$options[] = array(
        //    'name' => __('Public Profile'),
        //    'url' => osc_user_public_profile_url(),
        //    'class' => 'opt_publicprofile'
        //);
        $options[] = array(
            'name' => __('My listings', 'pop'),
            'url' => osc_user_list_items_url(),
            'class' => 'opt_items'
        );
       
        $options[] = array(
            'name' => __('Account settings', 'pop'),
            'url' => osc_user_profile_url(),
            'class' => 'opt_account'
        );
       
        $options[] = array(
            'name' => __('Change password', 'pop'),
            'url' => osc_change_user_password_url(),
            'class' => 'opt_change_password'
        );
         $options[] = array(
            'name' => __('Search watchlist', 'pop'),
            'url' => osc_user_alerts_url(),
            'class' => 'opt_alerts'
        ); 
        $options[] = array(
            'name' => __('Delete account', 'pop'),
            'url' => '#',
            'class' => 'opt_delete_account'
        );


        return $options;
    }

}

if (!function_exists('delete_user_js')) {

    function delete_user_js() {
        $location = Rewrite::newInstance()->get_location();
        $section = Rewrite::newInstance()->get_section();
        if (($location === 'user' && in_array($section, array('dashboard', 'profile', 'alerts', 'change_email', 'change_username', 'change_password', 'items'))) || (Params::getParam('page') === 'custom' && Params::getParam('in_user_menu') == true )) {
            osc_enqueue_script('delete-user-js');
        }
    }

    osc_add_hook('header', 'delete_user_js', 1);
}

if (!function_exists('user_info_js')) {

    function user_info_js() {
        $location = Rewrite::newInstance()->get_location();
        $section = Rewrite::newInstance()->get_section();

        if ($location === 'user' && in_array($section, array('dashboard', 'profile', 'alerts', 'change_email', 'change_username', 'change_password', 'items'))) {
            $user = User::newInstance()->findByPrimaryKey(Session::newInstance()->_get('userId'));
            View::newInstance()->_exportVariableToView('user', $user);
            ?>
            <script type="text/javascript">
                var pop = window.pop || {};
                pop.user = {};
                pop.user.id = '<?php echo osc_user_id(); ?>';
                pop.user.secret = '<?php echo osc_user_field("s_secret"); ?>';
            </script>
            <?php
        }
    }

    osc_add_hook('header', 'user_info_js');
}

function theme_pop_actions_admin() {
    //if(OC_ADMIN)
    if (Params::getParam('file') == 'oc-content/themes/pop/admin/settings.php') {
        if (Params::getParam('donation') == 'successful') {
            osc_set_preference('donation', '1', 'pop_theme');
            osc_reset_preferences();
        }
    }

    switch (Params::getParam('subaction')) {
        case('color-update'):
            /* theme color staff here */
            $aParams = Params::getParamsAsArray();
            unset($aParams['page']);
            unset($aParams['action']);
            unset($aParams['file']);
            unset($aParams['CSRFName']);
            unset($aParams['CSRFToken']);


            osc_set_preference('pop-theme-colors', json_encode($aParams), 'pop_theme');
            osc_add_flash_ok_message(__('Theme settings updated correctly', 'pop'), 'admin');
            osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/pop/admin/color_settings.php'));
            break;
        case('color-restore');
            $aParams = pop_getColorScheme(true);
            osc_set_preference('pop-theme-colors', json_encode($aParams), 'pop_theme');
            osc_add_flash_ok_message(__('Theme settings updated correctly', 'pop'), 'admin');
            osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/pop/admin/color_settings.php'));
            break;
        default:
            break;
    }

    switch (Params::getParam('action_specific')) {
        case('settings'):
            $footerLink = Params::getParam('footer_link');

            osc_set_preference('pop_max_premium', Params::getParam('pop_max_premium'), 'pop_theme');
            osc_set_preference('keyword_placeholder', Params::getParam('keyword_placeholder'), 'pop_theme');
            osc_set_preference('footer_link', ($footerLink ? '1' : '0'), 'pop_theme');

            osc_set_preference('header-728x90', trim(Params::getParam('header-728x90', false, false, false)), 'pop_theme');
            osc_set_preference('search-results-300x250', trim(Params::getParam('search-results-300x250', false, false, false)), 'pop_theme');
            osc_set_preference('item-detail-300x250', trim(Params::getParam('item-detail-300x250', false, false, false)), 'pop_theme');

            osc_add_flash_ok_message(__('Theme settings updated correctly', 'pop'), 'admin');
            osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/pop/admin/settings.php'));
            break;
        case('upload_logo'):
            $package = Params::getFiles('logo');
            if ($package['error'] == UPLOAD_ERR_OK) {
                $img = ImageResizer::fromFile($package['tmp_name']);
                $ext = $img->getExt();
                $logo_name = 'pop_logo';
                $logo_name .= '.' . $ext;
                $path = osc_uploads_path() . $logo_name;


                move_uploaded_file($package['tmp_name'], $path);

                osc_set_preference('logo', $logo_name, 'pop_theme');

                osc_add_flash_ok_message(__('The logo image has been uploaded correctly', 'pop'), 'admin');
            } else {
                osc_add_flash_error_message(__("An error has occurred, please try again", 'pop'), 'admin');
            }
            osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/pop/admin/header.php'));
            break;
        case('remove'):
            $logo = osc_get_preference('logo', 'pop_theme');
            $path = osc_uploads_path() . $logo;
            if (file_exists($path)) {
                @unlink($path);
                osc_delete_preference('logo', 'pop_theme');
                osc_reset_preferences();
                osc_add_flash_ok_message(__('The logo image has been removed', 'pop'), 'admin');
            } else {
                osc_add_flash_error_message(__("Image not found", 'pop'), 'admin');
            }
            osc_redirect_to(osc_admin_render_theme_url('oc-content/themes/pop/admin/header.php'));
            break;
    }
}

function pop_redirect_user_dashboard() {
    if ((Rewrite::newInstance()->get_location() === 'user') && (Rewrite::newInstance()->get_section() === 'dashboard')) {
        header('Location: ' . osc_user_list_items_url());
        exit;
    }
}

function pop_delete() {
    Preference::newInstance()->delete(array('s_section' => 'pop'));
}

osc_add_hook('init', 'pop_redirect_user_dashboard', 2);
osc_add_hook('init_admin', 'theme_pop_actions_admin');
osc_add_hook('theme_delete_pop', 'pop_delete');
osc_admin_menu_appearance(__('Theme settings', 'pop'), osc_admin_render_theme_url('oc-content/themes/pop/admin/settings.php'), 'settings_pop');
osc_admin_menu_appearance(__('Header logo', 'pop'), osc_admin_render_theme_url('oc-content/themes/pop/admin/header.php'), 'header_pop');
osc_admin_menu_appearance(__('Color settings', 'pop'), osc_admin_render_theme_url('oc-content/themes/pop/admin/color_settings.php'), 'settings_color_pop');
/**

  TRIGGER FUNCTIONS

 */
check_install_pop_theme();
if (osc_is_home_page()) {
    osc_add_hook('inside-main', 'pop_draw_categories_list');
} else if (osc_is_static_page() || osc_is_contact_page()) {
    osc_add_hook('before-content', 'pop_draw_categories_list');
}

if (osc_is_home_page() || osc_is_search_page()) {
    pop_add_body_class('has-searchbox');
}

function pop_sidebar_category_search($catId = null) {
    $aCategories = array();
    if ($catId == null) {
        $aCategories[] = Category::newInstance()->findRootCategoriesEnabled();
    } else {
        // if parent category, only show parent categories
        $aCategories = Category::newInstance()->toRootTree($catId);
        end($aCategories);
        $cat = current($aCategories);
        // if is parent of some category
        $childCategories = Category::newInstance()->findSubcategoriesEnabled($cat['pk_i_id']);
        if (count($childCategories) > 0) {
            $aCategories[] = $childCategories;
        }
    }

    if (count($aCategories) == 0) {
        return "";
    }

    pop_print_sidebar_category_search($aCategories, $catId);
}

function pop_print_sidebar_category_search($aCategories, $current_category = null, $i = 0) {
    $class = '';
    if (!isset($aCategories[$i])) {
        return null;
    }

    if ($i === 0) {
        $class = 'class="category"';
    }

    $c = $aCategories[$i];
    $i++;
    if (!isset($c['pk_i_id'])) {
        echo '<ul ' . $class . '>';
        if ($i == 1) {
            echo '<li><a href="' . osc_esc_html(osc_update_search_url(array('sCategory' => null, 'iPage' => null))) . '">' . __('All categories', 'pop') . "</a></li>";
        }
        foreach ($c as $key => $value) {
            ?>
            <li>
                <a id="cat_<?php echo osc_esc_html($value['pk_i_id']); ?>" href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory' => $value['pk_i_id'], 'iPage' => null))); ?>">
                    <?php
                    if (isset($current_category) && $current_category == $value['pk_i_id']) {
                        echo '<strong>' . $value['s_name'] . '</strong>';
                    } else {
                        echo $value['s_name'];
                    }
                    ?>
                </a>

            </li>
            <?php
        }
        if ($i == 1) {
            echo "</ul>";
        } else {
            echo "</ul>";
        }
    } else {
        ?>
        <ul <?php echo $class; ?>>
            <?php if ($i == 1) { ?>
                <li><a href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory' => null, 'iPage' => null))); ?>"><?php _e('All categories', 'pop'); ?></a></li>
            <?php } ?>
            <li>
                <a id="cat_<?php echo osc_esc_html($c['pk_i_id']); ?>" href="<?php echo osc_esc_html(osc_update_search_url(array('sCategory' => $c['pk_i_id'], 'iPage' => null))); ?>">
                    <?php
                    if (isset($current_category) && $current_category == $c['pk_i_id']) {
                        echo '<strong>' . $c['s_name'] . '</strong>';
                    } else {
                        echo $c['s_name'];
                    }
                    ?>
                </a>
                <?php pop_print_sidebar_category_search($aCategories, $current_category, $i); ?>
            </li>
            <?php if ($i == 1) { ?>
            <?php } ?>
        </ul>
        <?php
    }
}

function pop_search_filters() {?>
      <form id="filterForm" name="filterForm" action="<?php echo osc_base_url(true); ?>" method="get" class="nocsrf">
        <input type="hidden" name="page" value="search" />
        <input type="hidden" name="sOrder" value="<?php echo osc_search_order(); ?>" />
        <input type="hidden" name="iOrderType" value="<?php $allowedTypesForSorting = Search::getAllowedTypesForSorting() ; echo $allowedTypesForSorting[osc_search_order_type()]; ?>" />
        <?php foreach(osc_search_user() as $userId) { ?>
        <input type="hidden" name="sUser[]" value="<?php echo $userId; ?>" />
        <?php } ?>
        <fieldset class="form-group first">
            <h6>
                <?php _e('Search text', 'pop'); ?>
            </h6>
            <input class="input-text" type="text" name="sPattern" id="query" value="<?php echo osc_esc_html(osc_search_pattern()); ?>" />
        </fieldset>
       
        <fieldset class="form-group">
            <h6>
                <?php _e('Region', 'pop'); ?>
            </h6>
            <div>
                <?php
                            $sCountries = osc_get_countries();
                            $countryId = $sCountries[0]['pk_c_code'];
                            $sRegions = osc_get_regions($countryId);
                    ?>
               <?php //pop_region_autocomplete($sRegions); ?>
                 <input type="hidden" id="countryId" name="countryId" value="<?php echo $countryId; ?>" />
                  <input class="input-text" type="text" id="region" name="sRegion" value="<?php echo osc_esc_html(osc_search_region()); ?>" />
                <input type="hidden" id="regionId" name="regionId" />
            </div>
        </fieldset>
         <fieldset class="form-group">
            <h6>
                <?php _e('City', 'pop'); ?>
            </h6>
            <div>
                <input class="input-text" type="text" id="city" name="sCity" value="<?php echo osc_esc_html(osc_search_city()); ?>" />
                 <input type="hidden" id="cityId" name="cityId" />
            </div>
        </fieldset>
        <?php if( osc_images_enabled_at_items() ) { ?>
        <fieldset class="form-group">
            <div class="checkbox">
                <input type="checkbox" name="bPic" id="withPicture" value="1" <?php echo (osc_search_has_pic() ? 'checked' : ''); ?> />
                <label for="withPicture">
                    <?php _e('Listings with pictures', 'pop') ; ?>
                </label>
            </div>
        </fieldset>
        <?php } ?>
        <?php if( osc_price_enabled_at_items() ) { ?>
        <fieldset class="form-group">
            <div class="price-slice">
                <h6>
                    <?php _e('Price', 'pop') ; ?>
                </h6>
                <ul class="row">
                    <li class="col-md-6"> <span>
                            <?php _e('Min', 'pop') ; ?>
                   :</span>
                        <input class="input-text" type="text" id="priceMin" name="sPriceMin" value="<?php echo osc_esc_html(osc_search_price_min()); ?>" size="6" maxlength="6" />
                    </li>
                    <li class="col-md-6"> <span>
                            <?php _e('Max', 'pop') ; ?>
                   :</span>
                        <input class="input-text" type="text" id="priceMax" name="sPriceMax" value="<?php echo osc_esc_html(osc_search_price_max()); ?>" size="6" maxlength="6" />
                    </li>
                </ul>
            </div>
        </fieldset>
        <?php } ?>
          <div class="form-group plugin-hooks">
            <?php
            if(osc_search_category_id()) {
                osc_run_hook('search_form', osc_search_category_id()) ;
            } else {
                osc_run_hook('search_form') ;
            }
            ?>
        </div>
        <?php
            $aCategories = osc_search_category();
            foreach($aCategories as $cat_id) {
        ?>
        <input type="hidden" name="sCategory[]" value="<?php echo osc_esc_html($cat_id); ?>" />
        <?php } ?>

        <div class="actions">
            <button type="submit" class="btn btn-primary">
                <?php _e('Apply', 'pop') ; ?>
            </button>
            <a class="clear" onclick="formReset($('#filterForm'))">
            <i class="fa fa-times"></i><?php echo _e('Clear filters', 'pop')?></a>
        </div>
    </form>
<?php }

 function item_comments() {
         if( osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments() ) { ?>
        <div id="comments" class="box">
            <?php if( osc_count_item_comments() >= 1 ) { ?>
            <h2>
                <?php _e('Comments', 'pop'); ?> (<?php echo osc_count_item_comments()?>)
            </h2>
            <?php
                }
                
            ?>
         
            <?php CommentForm::js_validation(); ?>
            <?php if( osc_count_item_comments() >= 1 ) { ?>
            <div class="comments_list">
                <?php while ( osc_has_item_comments() ) { ?>
                <div class="comment">
                    
                     <div class="user-avatar" style="background-image: url('<?php echo osc_current_web_theme_url('images/seller-default.png'); ?>')"></div>
                    <?php if(osc_comment_author_name()) { ?>
                    <h4><em><?php echo osc_comment_author_name(); ?>:</em></h4>
                    <?php } else { ?>
                    <h4><em><?php echo osc_comment_author_email(); ?>:</em></h4>
                    <?php } ?>
                    <div class="date">
                    <? echo osc_comment_pub_date(); ?>
                    </div>
                    <p class="body"><?php echo nl2br( osc_comment_body() ); ?> </p>
                    <?php if ( osc_comment_user_id() && (osc_comment_user_id() == osc_logged_user_id()) ) { ?>
                    <a rel="nofollow" href="<?php echo osc_delete_comment_url(); ?>" title="<?php _e('Delete your comment', 'pop'); ?>">
                            <?php _e('Delete', 'pop'); ?>
                        </a>
                    <?php } ?>
                </div>
                <?php } ?>
                <div class="pagination">
                    <?php echo osc_comments_pagination(); ?>
                </div>
            </div>
            <?php } ?>
            <div class="comment_form">
               
                <h2>
                    <?php _e('Leave your comment', 'pop'); ?>
                </h2>
                <div class="resp-wrapper">
                     <ul id="comment_error_list" class="error_list">
                    </ul>
                    <form action="<?php echo osc_base_url(true); ?>" method="post" name="comment_form" id="comment_form">
                        <fieldset>
                            <input type="hidden" name="action" value="add_comment" />
                            <input type="hidden" name="page" value="item" />
                            <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
                            <?php if(osc_is_web_user_logged_in()) { ?>
                            <input type="hidden" name="authorName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
                            <input type="hidden" name="authorEmail" value="<?php echo osc_logged_user_email();?>" />
                            <?php } else { ?>
                            <div class="form-group col-md-6">
                                <label class="control-label" for="authorName">
                                    <?php _e('Name', 'pop'); ?>
                                </label>
                                <div class="controls">
                                    <?php CommentForm::author_input_text(); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label" for="authorEmail">
                                    <?php _e('Email', 'pop'); ?>
                                </label>
                                <div class="controls">
                                    <?php CommentForm::email_input_text(); ?>
                                </div>
                            </div>
                            <?php }; ?>

                            <div class="form-group col-md-12">
                                <label class="control-label" for="body">
                                    <?php _e('Comment', 'pop'); ?>
                                </label>
                                <div class="controls textarea">
                                    <?php CommentForm::body_input_textarea(); ?>
                                </div>
                            </div>
                            <div class="actions col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <?php _e('Send', 'pop'); ?>
                                </button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>
 <?php }

/**

  CLASSES

 */
class popBodyClass {

    /**
     * Custom Class for add, remove or get body classes.
     *
     * @param string $instance used for singleton.
     * @param array $class.
     */
    private static $instance;
    private $class;

    private function __construct() {
        $this->class = array();
    }

    public static function newInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function add($class) {
        $this->class[] = $class;
    }

    public function get() {
        return $this->class;
    }

}

/**

  HELPERS

 */
if (!function_exists('osc_uploads_url')) {

    function osc_uploads_url($item = '') {
        return osc_base_url() . 'oc-content/uploads/' . $item;
    }

}

/*

  ads  SEARCH

 */
if (!function_exists('search_ads_listing_top_fn')) {

    function search_ads_listing_top_fn() {
        if (osc_get_preference('search-results-top-728x90', 'pop') != '') {
            echo '<div class="clear"></div>' . PHP_EOL;
            echo '<div class="ads_728">' . PHP_EOL;
            echo osc_get_preference('search-results-top-728x90', 'pop');
            echo '</div>' . PHP_EOL;
        }
    }

}
//osc_add_hook('search_ads_listing_top', 'search_ads_listing_top_fn');

if (!function_exists('search_ads_listing_medium_fn')) {

    function search_ads_listing_medium_fn() {
        if (osc_get_preference('search-results-middle-728x90', 'pop') != '') {
            echo '<div class="clear"></div>' . PHP_EOL;
            echo '<div class="ads_728">' . PHP_EOL;
            echo osc_get_preference('search-results-middle-728x90', 'pop');
            echo '</div>' . PHP_EOL;
        }
    }

}
osc_add_hook('search_ads_listing_medium', 'search_ads_listing_medium_fn');



/* pop theme */
osc_add_hook('posted_item', 'pop_listing_location_img');
osc_add_hook('edited_item', 'pop_listing_location_img');
osc_add_hook('user_register_completed', 'pop_user_update_lat_long');
osc_add_hook('user_edit_completed', 'pop_user_update_lat_long');

function pop_listing_location_img($aItem) {
    $location_string = pop_get_listing_location_string($aItem);
    $url = 'http://maps.googleapis.com/maps/api/staticmap?center=' . urlencode($location_string) . '&zoom=15&size=640x200&scale=1';
    $img_path = osc_uploads_path() . $aItem['pk_i_id'] . '_map.png';
    file_put_contents($img_path, file_get_contents($url));
}

function pop_user_update_lat_long($userId) {
    $user = User::newInstance()->findByPrimaryKey($userId);
    $lat = 41.298336;
    $long = 2.084683;
    $location_string = pop_get_listing_location_string($user);
    if ($location_string == '') {
        $aCountries = osc_get_countries();
        $country = $aCountries[0];
        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $country['s_name'] . "&sensor=true_or_false";
    } else {
        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($location_string) . "&sensor=true_or_false";
    }
    $content = file_get_contents($url);
    if (json_encode($content)) {
        $json = json_decode($content, true);
        if (isset($json['results'][0]['geometry']['location']['lat'])) {
            $lat = $json['results'][0]['geometry']['location']['lat'];
            $long = $json['results'][0]['geometry']['location']['lng'];
        }
    }
    User::newInstance()->update(
        array('d_coord_lat' => $lat, 'd_coord_long' => $long), array('pk_i_id' => $userId));
}

/* helpers pop theme */

function pop_get_listing_map_image($item_id) {
    return osc_uploads_url($item_id . '_map.png');
}

function pop_get_listing_location_string($aItem) {
    $aux_item = View::newInstance()->_get('item');
    View::newInstance()->_exportVariableToView('item', $aItem);

    $location = array();
    if (osc_item_city_area() !== '') {
        $location[] = osc_item_city_area();
    }
    if (osc_item_city() !== '') {
        $location[] = osc_item_city();
    }
    if (osc_item_region() !== '') {
        $location[] = osc_item_region();
    }
    if (osc_item_country() !== '') {
        $location[] = osc_item_country();
    }

    View::newInstance()->_exportVariableToView('item', $aux_item);
    return implode(', ', $location);
}

function pop_get_user_location_string($user) {
    $aux_user = View::newInstance()->_get('user');
    View::newInstance()->_exportVariableToView('user', $user);

    $location = array();
    if (osc_user_city_area() !== '') {
        $location[] = osc_user_city_area();
    }
    if (osc_user_city() !== '') {
        $location[] = osc_user_city();
    }
    if (osc_user_region() !== '') {
        $location[] = osc_user_region();
    }
    if (osc_user_country() !== '') {
        $location[] = osc_user_country();
    }

    View::newInstance()->_exportVariableToView('user', $aux_user);
    return implode(', ', $location);
}

function pop_facebook_share_url() {
    if (osc_is_public_profile()) {
        $url = osc_user_public_profile_url();
    } else if (osc_is_ad_page()) {
        $url = osc_item_url();
    } else {
        $url = osc_base_url();
    }
      $fb = "javascript:window.open('http://facebook.com/sharer/sharer.php?u='+encodeURIComponent('" . $url  . "') , '_blank', 'width=400,height=500');void(0);";
    return $fb;
}

function pop_twitter_share_url() {
    if (osc_is_public_profile()) {
        $text = sprintf(__("%1\$s: %2$", 'pop'), osc_page_title(), osc_user_public_profile_url());
    } else
    if (osc_is_ad_page()) {
        $text = sprintf(__("%1\$s: %2$", 'pop'), osc_page_title(), osc_item_url());
    } else {
        $text = sprintf(__("%1\$s.$", 'pop'), osc_base_url());
    }
    $tw = "javascript:window.open('http://twitter.com/share?text='+encodeURIComponent('" . urldecode($text) . "'), '_blank', 'width=400,height=500');void(0);";
    return $tw;
}
function pop_gplus_share_url() {
    if (osc_is_public_profile()) {
        $url = osc_user_public_profile_url();
    } else if (osc_is_ad_page()) {
        $url = osc_item_url();
    } else {
        $url = osc_base_url();
    }
        $gp = "javascript:window.open('https://plus.google.com/share?url='+encodeURIComponent('" . $url . "') , '_blank', 'width=400,height=500');void(0);";
    
    return $gp;
}
function pop_pinterest_share_url() {
    $p = "javascript:window.open('https://pinterest.com/pin/create/button/?url='+encodeURIComponent('".osc_resource_url()."')+'&media='+encodeURIComponent('".osc_item_url()."'), '_blank', 'width=400,height=500');void(0);";
    return $p;
}

function pop_email_share_url() {
    if (osc_is_public_profile()) {
        $subject = (sprintf(__("Check out this profile with interesting products at %s.", 'pop'), osc_page_title()));
        $body = (sprintf(__('Take a look at %1$s\'s profile on %2$s', 'pop'), osc_user_public_profile_url(), osc_page_title()));
    }
    if (osc_is_ad_page()) {
        $subject = (sprintf(__("Check out what I just found < %s >", 'pop'), osc_item_title()));
        $body = (sprintf(__('Take a look at %s', 'pop'), osc_item_url()));
    }
    return 'mailto:?body=' . $body . '&subject=' . $subject;
}

/* openGraph meta tags */

function pop_meta_image() {
    $url = pop_logo_url();
    // listing
    if (osc_is_ad_page()) {

        if (osc_has_item_resources()) {
            $url = osc_resource_thumbnail_url();
        }
    }
    return (osc_apply_filter('pop_meta_image_filter', $url));
}

/* ajax scroll pagination */

function pop_ajax_scroll() {
    osc_current_web_theme_path('inc.script.php');
}

osc_add_hook('footer', 'pop_ajax_scroll');

function pop_ajax_load_more() {
    $array = Params::getParamsAsArray();

    if ($array['_page'] == 'user' ) {
        if($array['_action'] == 'pub_profile') {
            if($array['username']!='') {
                $_user = User::newInstance()->findByUsername($array['username']);
                $array['id'] = $_user['pk_i_id'];
            }
            $params['author'] = $array['id'];
            $params['results_per_page'] = isset($array['_offset']) ? $array['_offset'] : osc_default_results_per_page_at_search();
            $params['page'] = isset($array['iPage']) ? $array['iPage']-1 : 0;
        }
        if($array['_action'] == 'items') {
            $params['author'] = osc_logged_user_id();
            $params['results_per_page'] = 10;  // core default
            $params['page'] = isset($array['iPage']) ? $array['iPage']-1 : 0;
        }
        osc_query_item($params);
        $result = View::newInstance()->_get('customItems');
        echo _pop_print_listing_card($result);
        exit;
    }

    if ($array['_page'] == 'search' || $array['_page'] == '') {
        if(osc_rewrite_enabled()) {
            if(REL_WEB_URL!='/') {
                $base_url = str_replace(REL_WEB_URL, '', osc_base_url());
            } else {
                $base_url = osc_base_url();
            }
            $_SERVER['REQUEST_URI'] = preg_replace('|^' . $base_url . '|', '', osc_search_url(Params::getParamsAsArray()));

            osc_add_hook('before_html', 'pop_ob_start_');
            osc_add_hook('after_html', 'pop_ob_clean_');
            osc_add_hook('after_search', 'pop_echo_pop_print_listing_card');
        }
        require_once(osc_lib_path() . 'osclass/controller/search.php');
        $do = new CWebSearch();
        $do->doModel();
        exit;
    }
}

osc_add_hook('ajax_load_more_listing', 'pop_ajax_load_more');
if(!osc_rewrite_enabled()) {
    osc_add_hook('before_html', 'pop_ob_start');
    osc_add_hook('after_html', 'pop_ob_clean');
}
function pop_ob_start() {
    if (Params::getParam('page') == 'search' && Params::getParam('hook') == 'load_more_listing') {
        ob_start();
    }
}
function pop_ob_clean() {
    if (Params::getParam('page') == 'search' && Params::getParam('hook') == 'load_more_listing') {
        ob_clean();
    }
}

function pop_ob_start_() {
    ob_start();
}
function pop_ob_clean_() {
    ob_clean();
    ob_get_flush();
}

function _pop_print_listing_card($aItems = null) {
    ob_end_flush();
    ob_start();
    if (Params::getParam('_page') == 'search' || Params::getParam('_page') == '') {
        // get premium ads
        $max = osc_get_preference('pop_max_premium', 'pop_theme');
        osc_get_premiums($max);
        if (osc_count_premiums() > 0) {
            while (osc_has_premiums()) {
                pop_draw_item('', false, true);
            }
        }
    }
    if ($aItems !== null) {
        View::newInstance()->_exportVariableToView('items', $aItems);
    }
    while (osc_has_items()) {
        $admin = false;
        if (View::newInstance()->_exists("listAdmin")) {
            $admin = true;
        }
        pop_draw_item('', $admin);
    }
    $html = ob_get_contents();
    ob_clean();
    return $html;
}

function pop_echo_pop_print_listing_card() {
    echo _pop_print_listing_card();
}

function pop_redirect_404($header_text = '') {
    if ($header_text != '') {
        View::newInstance()->_exportVariableToView('pop_404_header_text', $header_text);
    }
    Rewrite::newInstance()->set_location('error');
    header('HTTP/1.1 404 Not Found');
    osc_current_web_theme_path('404.php');
    exit;
}

function pop_init_config() {  
    // block send_friend, send_friend_post
    if (Params::getParam('action') == 'send_friend' || Params::getParam('action') == 'send_friend_post') {
        pop_redirect_404();
    }

    if (Params::getParam('action') == 'pub_profile' || Params::getParam('action') == 'items') {
        Params::setParam('itemsPerPage', osc_default_results_per_page_at_search());
    }
    if(!osc_rewrite_enabled()) {
        if (Params::getParam('page') == 'search' && Params::getParam('hook') == 'load_more_listing') {
            // no stdio at search page, only via ajax
            osc_add_hook('after_search', 'pop_echo_pop_print_listing_card');
        }
    }
}

        function related_listings() {
            View::newInstance()->_exportVariableToView('items', array());
            $mSearch = new Search();
            $mSearch->addCategory(osc_item_category_id());
            $mSearch->addItemConditions(sprintf("%st_item.pk_i_id != %s ", DB_TABLE_PREFIX, osc_item_id()));
            $mSearch->limit('0', '3');
            $aItems = $mSearch->doSearch();
            $iTotalItems = count($aItems);
            if( $iTotalItems > 0 ) {
                View::newInstance()->_exportVariableToView('items', $aItems);
                return $iTotalItems;
            }
            unset($mSearch);
            return 0;
        }

function location_autocomplete() {
    ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#countryName').attr( "autocomplete", "off" );
        $('#region').attr( "autocomplete", "off" );
        $('#city').attr( "autocomplete", "off" );

        $('#countryName').on('keyup.autocomplete', function(){
            $('#countryId').val('');
            $( this ).autocomplete({
                source: "<?php echo osc_base_url(true); ?>?page=ajax&action=location_countries",
                minLength: 0,
                select: function( event, ui ) {
                    $('#countryId').val(ui.item.id);
                    $('#regionId').val('');
                    $('#region').val('');
                    $('#cityId').val('');
                    $('#city').val('');
                }
            });
        });


        $('#region').on('keyup.autocomplete', function(){
            $('#regionId').val('');
            if($('#countryId').val()!='' && $('#countryId').val()!=undefined) {
                var country = $('#countryId').val();
            } else {
                var country = $('#country').val();
            }
            $( this ).autocomplete({
                source: "<?php echo osc_base_url(true); ?>?page=ajax&action=location_regions&country="+country,
                minLength: 2,
                select: function( event, ui ) {
                    $('#cityId').val('');
                    $('#city').val('');
                    $('#regionId').val(ui.item.id);
                }
            });
        });

        $('#city').on('keyup.autocomplete', function(){
            $('#cityId').val('');
            if($('#regionId').val()!='' && $('#regionId').val()!=undefined) {
                var region = $('#regionId').val();
            } else {
                var region = $('#region').val();
            }
            $( this ).autocomplete({
                source: "<?php echo osc_base_url(true); ?>?page=ajax&action=location_cities&region="+region,
                minLength: 2,
                select: function( event, ui ) {
                    $('#cityId').val(ui.item.id);
                }
            });
        });

        $('.ui-autocomplete').css('zIndex', 10000);


    });
</script>
<?php
}

osc_add_hook('init', 'pop_init_config');

function pop_draw_ad($preference) {
    if (osc_get_preference($preference, 'pop_theme') != '') {
        ?>
        <div class="item ad">
            <div class="ad-results">
                <?php echo osc_get_preference($preference, 'pop_theme'); ?>
            </div>
        </div>
        <?php
    }
}

/* theme colors */

function pop_custom_styles() {
    $p = pop_getColorScheme();
//return '';
    echo '<style>';
    echo '.custom-wrapper { background-color: #' . $p['mainColor'] . '}' .
        '#menu .pure-menu-horizontal .pure-menu-item a.btn-round  {   background-color: #'.$p['headerButtonBG'].'; color: #'.$p['headerButtonText'].'; }',
        '#menu .pure-menu-horizontal .pure-menu-item a.btn-round:hover  {   background-color: #'.$p['headerButtonHoverBG'].'; color: #'.$p['headerButtonHoverText'].';} ',
        'body { background-color: #'.$p['backgroundColor'].'; }',
        '.btn-round:hover { background-color: #'.$p['mainColor'].'; }',
        '.masonry .item .listing-attributes .listing-price { color: #'.$p['mainColor'].'; }',
        '.stamp.sidebar .collections a.active { color: #'.$p['mainColor'].'; }',
        '.custom-wrapper { background-color: #'.$p['mainColor'].'; }',
        '.dropdown-menu>li>a:hover, .dropdown-menu>li>a:focus { background-color: #'.$p['mainColor'].'; }',
        '.ui-widget-header { background: #'.$p['mainColor'].'; border: 1px solid gray; }',
        '.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { background: #'.$p['mainColor'].'; border: 1px solid gray; color:white!important;} ',
        '.masonry .item.premium {border:1px solid #'. $p['premiumBackgroundColor'].';background-color: #'.$p['premiumBorderColor'].';}'
        ;
    echo '</style>';
}

function pop_admin_enqueue_assets() {
    if (Params::getParam('file') == 'oc-content/themes/pop/admin/color_settings.php' && Params::getParam('page') == 'appearance' && Params::getParam('action') == 'render') {
        osc_enqueue_style('pop_admin_css', osc_base_url() . 'oc-content/themes/pop/admin/css/admin.css');
        osc_enqueue_script('colorpicker');
        osc_enqueue_style('colorpicker', osc_assets_url('js/colorpicker/css/colorpicker.css'));
    }
}

osc_add_hook('init_admin', 'pop_admin_enqueue_assets');
if (!function_exists('pop_getColorScheme')) {

    function pop_getColorScheme($default = false) {

        $schemes = array();
        $sColor = osc_get_preference('pop-theme-colors', 'pop_theme');
        if($default || ($default==false && $sColor=='')) {
            $schemes['default'] = array();
            // header
            $schemes['default']['headerBG'] = '35C3D9';
            // header buttons
            $schemes['default']['headerButtonBG'] = 'f9f9f9';
            $schemes['default']['headerButtonText'] = '555555';
            $schemes['default']['headerButtonHoverBG'] = 'E9E2FF';
            $schemes['default']['headerButtonHoverText'] = '555555';
            // body content
            $schemes['default']['backgroundColor'] = 'ededed';
            $schemes['default']['mainColor'] = '35C3D9';
            // item premium
            $schemes['default']['premiumBackgroundColor'] = 'FFDF00';
            $schemes['default']['premiumBorderColor'] = 'FFF9B8';
        } else {
            $aColor = json_decode($sColor, true);
            foreach($aColor as $_key => $_color) {
                $schemes['default'][$_key] = $_color;
            }
        }
        return $schemes['default'];
    }
}




?>