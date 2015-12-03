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
<div id="sidebar">

    <?php if( osc_get_preference('sidebar-300x250', 'osclasswizards_theme') != '') {?>
    <!-- sidebar ad 350x250 -->
    <div class="ads_300">
        <?php echo osc_get_preference('sidebar-300x250', 'osclasswizards_theme'); ?>
    </div>
    <!-- /sidebar ad 350x250 -->
    <?php } ?>

    <?php
        
        
        $location = array();
            if( osc_item_city_area() !== '' ) {
                $location[] = osc_item_city_area();
            }
            if( osc_item_city() !== '' ) {
                $location[] = osc_item_city();
            }
            if( osc_item_region() !== '' ) {
                $location[] = osc_item_region();
            }
            if( osc_item_country() !== '' ) {
                $location[] = osc_item_country();
            }
    ?>
    <h1 class="title item-title"> <?php echo osc_item_title(); ?></h1>
    <div class="item-header">
        <?php if(osc_is_web_user_logged_in() && osc_logged_user_id()==osc_item_user_id()) { ?>
        <div id="edit_item_view" class="toolbar">
            <div class="state pull-right">
                <?php if(osc_item_is_inactive()) {?>
                <span class=" inactive"><?php _e('Inactive','osclasswizards')?></span>
                <a class="link active" href="<?php echo osc_item_activate_url();?>">
                    <?php _e('Activate', 'osclasswizards'); ?>
                </a>
                <?php } else { ?>
                <span class=" active"><?php _e('Active','osclasswizards')?></span>
                <a class="link inactive" href="<?php echo osc_item_deactivate_url();?>">
                    <?php _e('Deactivate', 'osclasswizards'); ?>
                </a>
                <?php } ?>
            </div>
            <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow">
                <?php _e('Edit', 'osclasswizards'); ?>
            </a>
            <span> | </span>
            <a onclick="confirmDel('<?php echo osc_item_delete_url(); ?>')" rel="nofollow">
                <?php _e('Delete', 'osclasswizards'); ?>
            </a>
        </div>
        <?php } ?>

        <div id="item-price">
            <?php if( osc_price_enabled_at_items() ) { ?>
            <?php _e('Price', 'osclasswizards');?>: <?php echo osc_item_formated_price(); ?>
            <?php } ?>
        </div>
        <div class="item-date">
            <i class="fa fa-calendar"></i>
            <?php
                if ( osc_item_pub_date() !== '' ) { 
                    printf( __('%1$s', 'osclasswizards'),osc_format_date( osc_item_pub_date() ) ); 
                    }
            ?>
        </div>
        <?php if (count($location)>0) { ?>
        <div id="item_location">
            <i class="fa fa-map-marker"></i>
            <?php echo implode(', ', $location); ?>
        </div>
        <?php }; ?>




        <?php osc_run_hook('item_detail', osc_item() ); ?>
    </div>
    <div class="item-details">
        <div id="custom_fields">
            <?php if( osc_count_item_meta() >= 1 ) { ?>
            <div class="meta_list">
                <?php while ( osc_has_item_meta() ) { ?>
                <?php if(osc_item_meta_value()!='') { ?>
                <div class="meta">
                    <strong><?php echo osc_item_meta_name(); ?>:</strong> <?php echo osc_item_meta_value(); ?>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <h4> <?php _e('Description', 'osclasswizards'); ?> :</h4>
        <div>
            <?php echo osc_item_description(); ?>
        </div>
    </div>

    <div class="listing-seller">
        <div class="listing-seller-avatar" style="background-image: url('<?php echo osc_current_web_theme_url('images/user_default.gif'); ?>')"></div>
        <?php if( osc_item_user_id() != null ) { ?>
        <a href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>"><?php echo osc_item_contact_name(); ?></a>

        <?php } else { ?>
        <div class="seller-name">
            <?php echo osc_item_contact_name(); ?>
        </div>
        <?php } ?>
        <div class="seller-listings">
            <?php echo osc_item_user_count_items(); ?> <?php _e('items', 'osclasswizards'); ?>
        </div>
    </div>
    <p class="contact_button">
        <?php if( !osc_item_is_expired () ) { ?>
        <?php if( !( ( osc_logged_user_id() == osc_item_user_id() ) && osc_logged_user_id() != 0 ) ) { ?>
        <?php     if(osc_reg_user_can_contact() && osc_is_web_user_logged_in() || !osc_reg_user_can_contact() ) { ?>
        <a id="contact_btn" class="ui-button ui-button-middle ui-button-main resp-toogle">
            <?php _e('Contact seller', 'osclasswizards'); ?>
        </a>
        <?php     } ?>
        <?php     } ?>
        <?php } ?>

        <?php if(function_exists('watchlist')){ watchlist(); } ?>
    </p>

    <?php if(!osc_is_web_user_logged_in() || osc_logged_user_id()!=osc_item_user_id()) { ?>
    <form action="<?php echo osc_base_url(true); ?>" method="post" name="mask_as_form" id="mask_as_form">
        <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />
        <input type="hidden" name="as" value="spam" />
        <input type="hidden" name="action" value="mark" />
        <input type="hidden" name="page" value="item" />
        <select name="as" id="as" class="mark_as" onchange="markAs()">
            <option><?php _e("Mark as...", 'osclasswizards'); ?></option>
            <option value="spam"><?php _e("Mark as spam", 'osclasswizards'); ?></option>
            <option value="badcat"><?php _e("Mark as misclassified", 'osclasswizards'); ?></option>
            <option value="repeated"><?php _e("Mark as duplicated", 'osclasswizards'); ?></option>
            <option value="expired"><?php _e("Mark as expired", 'osclasswizards'); ?></option>
            <option value="offensive"><?php _e("Mark as offensive", 'osclasswizards'); ?></option>
        </select>
    </form>
    <script>
        function markAs(){
            document.mask_as_form.submit();
        }
    </script>
    <?php } ?>

    <div id="useful_info">
        <h2>
            <?php _e('Useful information', 'osclasswizards'); ?>
        </h2>
        <ul>
            <li>
                <?php _e('Avoid scams by acting locally or paying with PayPal', 'osclasswizards'); ?>
            </li>
            <li>
                <?php _e('Never pay with Western Union, Moneygram or other anonymous payment services', 'osclasswizards'); ?>
            </li>
            <li>
                <?php _e('Don\'t buy or sell outside of your country. Don\'t accept cashier cheques from outside your country', 'osclasswizards'); ?>
            </li>
            <li>
                <?php _e('This site is never involved in any transaction, and does not handle payments, shipping, guarantee transactions, provide escrow services, or offer "buyer protection" or "seller certification"', 'osclasswizards'); ?>
            </li>
        </ul>
    </div>

</div><!-- /sidebar -->
<script>
    $("#contact").dialog({
        modal: true,
        autoOpen: false,
        width: 560
        });
     $( "#contact_btn" ).on( "click", function() {
      $("#contact").dialog('open');
    });
</script>