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
    // meta tag robots
    osc_add_hook('header','osclasswizards_follow_construct');
    osclasswizards_add_body_class('home');
    if(osclasswizards_show_as() == 'gallery'){
        $loop_template	=	'loop-grid.php';
        $listClass = 'listing-grid';
    }else{
        $loop_template	=	'loop-list.php';
        $listClass   = '';
    }
    
?>
<?php osc_current_web_theme_path('header.php') ; ?>
<?php osc_run_hook('inside-main'); ?>

<div class="content">
    <h1 class="title">
        <?php _e('Latest Listings', 'osclasswizards') ; ?>

    </h1>
    <div class="latest_ads">
        <?php if( osc_count_latest_items() == 0) { ?>
        <p class="empty">
            <?php _e("There aren't listings available at this moment", 'osclasswizards'); ?>
        </p>
        <?php } else { ?>


        <?php
             View::newInstance()->_exportVariableToView("listType", 'latestItems');
            View::newInstance()->_exportVariableToView("listClass",$listClass);
             osc_current_web_theme_path($loop_template);
        ?>
        <?php if( osc_count_latest_items() == osc_max_latest_items() ) { ?>
        <p class="see_more_link"><a href="<?php echo osc_search_show_all_url() ; ?>"> <strong>
                    <?php _e('See all listings', 'osclasswizards') ; ?>
     &raquo;</strong></a> </p>
        <?php } ?>
        <?php } ?>
    </div>
    <?php if( osc_get_preference('homepage-728x90', 'osclasswizards_theme') != "") { ?>
    <div class="ads_home">
        <?php echo osc_get_preference('homepage-728x90', 'osclasswizards_theme'); ?>
    </div>
    <?php } ?>
</div>
<?php osc_current_web_theme_path('footer.php') ; ?>
