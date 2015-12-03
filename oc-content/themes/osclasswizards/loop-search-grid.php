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
    $type = 'items';
    if(View::newInstance()->_exists('listType')){
        $type = View::newInstance()->_get('listType');
    }
?>
<div id="listing-card-list" class=" listing-card-list listings_grid listings_grids">
    <?php
        $i = 0;
        
        //latest items
        if($type == 'latestItems'){
            $listcount = 0;
        while ( osc_has_latest_items() ) {
            if($listcount%3 == 0)
            {
                if($listcount !=0) echo '</ul>';
                echo '<ul class="row">';
            }
            $listcount++;
    ?>
    <?php $size = explode('x', osc_thumbnail_dimensions()); ?>
    <li class="col-sm-6 col-md-3 <?php if(osc_item_is_premium()){ echo ' premium'; } ?>">
        <div class="listing-card">
            <?php if( osc_images_enabled_at_items() ) { ?>
            <?php if(osc_count_item_resources()) { ?>
            <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="img-responsive"></a>
            <?php } else { ?>
            <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="img-responsive"></a>
            <?php } ?>
            <?php } ?>
            <div class="info">
                <div class="detail_info">
                    <h4><a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><?php echo osc_item_title() ; ?></a><span><?php _e('Premium','osclasswizards');?></span></h4>
                    <div class="listing-attributes">
                        <?php if( osc_price_enabled_at_items() ) { ?>
                        <div class="currency-value">
                            <?php echo osc_format_price(osc_item_price()); ?>
                        </div>
                        <?php } ?>
                        <div class="location">
                            <?php echo osc_item_city(); ?>
                            <?php if( osc_item_region()!='' ) { ?>
           (<?php echo osc_item_region(); ?>)
                            <?php } ?>
                        </div>

                    </div>


                </div>
                <?php $admin = false; ?>
                <?php if($admin){ ?>
                <span class="admin-options"> <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow">
                        <?php _e('Edit item', 'osclasswizards'); ?>
                    </a> <span>|</span> <a class="delete" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'osclasswizards')); ?>')" href="<?php echo osc_item_delete_url();?>">
                        <?php _e('Delete', 'osclasswizards'); ?>
                    </a>
                    <?php if(osc_item_is_inactive()) {?>
                    <span>|</span> <a href="<?php echo osc_item_activate_url();?>">
                        <?php _e('Activate', 'osclasswizards'); ?>
                    </a>
                    <?php } ?>
                </span>
                <?php } ?>
            </div>
        </div>
    </li>
    <?php
        
            }
        } 
        
        // premium items
        elseif($type == 'premiums'){
            $listcount = 0;
            while ( osc_has_premiums() ) {
            if($listcount%3 == 0)
            {
                if($listcount !=0) echo '</ul>';
                echo '<ul class="row">';
            }
            $listcount++;
    ?>
    <?php $size = explode('x', osc_thumbnail_dimensions()); ?>
    <li class="col-sm-6 col-md-4 premium">
        <div class="listing-card">
            <?php if( osc_images_enabled_at_items() ) { ?>
            <?php if(osc_count_premium_resources()) { ?>
            <a class="listing-thumb" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img class="img-responsive" src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
            <?php } else { ?>
            <a class="listing-thumb" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img class="img-responsive" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
            <?php } ?>
            <?php } ?>
            <div class="info">
                <div class="detail_info">
                    <h4><a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><?php echo osc_item_title() ; ?></a><span><?php _e('Premium','osclasswizards');?></span></h4>
                    <div class="listing-attributes">
                        <?php if( osc_price_enabled_at_items() ) { ?>
                        <div class="currency-value">
                            <?php echo osc_format_price(osc_item_price()); ?>
                        </div>
                        <?php } ?>
                        <div class="location">
                            <?php echo osc_item_city(); ?>
                            <?php if( osc_item_region()!='' ) { ?>
           (<?php echo osc_item_region(); ?>)
                            <?php } ?>
                        </div>

                    </div>

                </div>
                <?php $admin = false; ?>
                <?php if($admin){ ?>
                <span class="admin-options"> <a href="<?php echo osc_premium_edit_url(); ?>" rel="nofollow">
                        <?php _e('Edit item', 'osclasswizards'); ?>
                    </a> <span>|</span> <a class="delete" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'osclasswizards')); ?>')" href="<?php echo osc_premium_delete_url();?>">
                        <?php _e('Delete', 'osclasswizards'); ?>
                    </a>
                    <?php if(osc_premium_is_inactive()) {?>
                    <span>|</span> <a href="<?php echo osc_premium_activate_url();?>">
                        <?php _e('Activate', 'osclasswizards'); ?>
                    </a>
                    <?php } ?>
                </span>
                <?php } ?>
            </div>
        </div>
    </li>
    <?php
            }
        }
        else {
            $listcount = 0;
            while(osc_has_items()) {
        if($listcount%3 == 0)
        {
            if($listcount !=0) echo '</ul>';
            echo '<ul class="row">';
        }
        $listcount++;
        $admin = false;
                if(View::newInstance()->_exists("listAdmin")){
                    $admin = true;
                }
    ?>
    <?php $size = explode('x', osc_thumbnail_dimensions()); ?>
    <li class="col-sm-6 col-md-4 <?php if(osc_item_is_premium()){ echo ' premium'; } ?>">
        <div class="listing-card">
            <?php if( osc_images_enabled_at_items() ) { ?>
            <?php if(osc_count_item_resources()) { ?>
            <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="img-responsive"></a>
            <?php } else { ?>
            <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="img-responsive"></a>
            <?php } ?>
            <?php } ?>
            <div class="info">
                <div class="detail_info">
                    <h4><a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><?php echo osc_item_title() ; ?></a><span><?php _e('Premium','osclasswizards');?></span></h4>
                    <div class="listing-attributes">
                        <?php if( osc_price_enabled_at_items() ) { ?>
                        <div class="currency-value">
                            <?php echo osc_format_price(osc_item_price()); ?>
                        </div>
                        <?php } ?>
                        <div class="location">
                            <i class="fa fa-map-marker"></i>
                            <?php echo osc_item_city(); ?>
                            <?php if( osc_item_region()!='' ) { ?>
           (<?php echo osc_item_region(); ?>)
                            <?php } ?>
                        </div>

                    </div>

                </div>
                <!--<a href="<?php echo osc_user_public_profile_url( osc_item_user_id() ); ?>">
                    <div class="listing-seller">
                        <div class="listing-seller-avatar" style="background-image: url('<?php echo osc_current_web_theme_url('images/user_default.gif'); ?>')"></div>
                        <span class="seller-name"><?php echo osc_item_contact_name(); ?></span>
                        <span class="seller-listings"><?php echo osc_item_user_count_items(); ?> <?php _e('items', 'osclasswizards'); ?></span>
                    </div>
                </a>-->
                <?php if($admin){ ?>
                <span class="admin-options"> <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow">
                        <?php _e('Edit item', 'osclasswizards'); ?>
                    </a> <span>|</span> <a class="delete" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'osclasswizards')); ?>')" href="<?php echo osc_item_delete_url();?>">
                        <?php _e('Delete', 'osclasswizards'); ?>
                    </a>
                    <?php if(osc_item_is_inactive()) {?>
                    <span>|</span> <a href="<?php echo osc_item_activate_url();?>">
                        <?php _e('Activate', 'osclasswizards'); ?>
                    </a>
                    <?php } ?>
                </span>
                <?php } ?>
            </div>
        </div>
    </li>
    <?php
              }
        }
    ?>
</div>
