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
<div class="listing-card-list listings_grid listings_grids" id="listing-card-list">

    <?php
        $i = 0;
        
        
            $listcount = 0;
            while(osc_has_items()) {
            if($listcount%3 == 0)
            {
            echo '</ul><ul class="row">';
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
                <?php if($admin){ ?>

                <div class="admin-options">
                    <div class="pull-right">
                        <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow">
                            <?php _e('Edit item', 'osclasswizards'); ?>
                        </a>
                        <span>|</span>
                        <a class="delete" onclick="confirmDel('<?php echo osc_item_delete_url();?>')">
                            <?php _e('Delete', 'osclasswizards'); ?>
                        </a>
                    </div>
                    <div class="state">
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
                    
                    <div class="stats"><?php echo osc_item_views(); ?> <?php echo _e('views','osclasswizards')?></div>

                </div>
                <?php } ?>
            </div>
        </div>
    </li>
    <?php
        }
        
    ?>
 </ul>
</div>
