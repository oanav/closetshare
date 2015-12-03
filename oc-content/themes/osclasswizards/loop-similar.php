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
    
?>
<ul class="listing-card-list" id="listing-card-list">


    <?php
        while(osc_has_items()) {
        
    ?>
    <?php $size = explode('x', osc_thumbnail_dimensions()); ?>
    <li class="listing-card <?php if(osc_item_is_premium()){ echo ' premium'; } ?>">
        <?php if( osc_images_enabled_at_items() ) { ?>
        <div class="row">
            <div class="col-sm-5 col-md-6">
                <?php if(osc_count_item_resources()) { ?>
                <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="img-responsive"></a>
                <?php } else { ?>
                <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="img-responsive"></a>
                <?php } ?>
                <?php } ?>
            </div>
            <div class="col-sm-7 col-md-6">
                <div class="info">
                    <div class="detail_info">
                        <h4><a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><?php echo osc_item_title() ; ?></a><span>
                                <?php _e('Premium','osclasswizards');?>
                            </span></h4>
                        <div class="listing-attributes">

                            <div class="location">
                                <i class="fa fa-map-marker"></i>
                                <?php echo osc_item_city(); ?>
                                <?php if( osc_item_region()!='' ) { ?>
             (<?php echo osc_item_region(); ?>)
                                <?php } ?>
                            </div>
                            <div class="price">
                            <?php if( osc_price_enabled_at_items() ) { ?>
                            <strong><?php _e('Price','osclasswizards')?>: </strong>
                            <span class="currency-value"> <?php echo osc_format_price(osc_item_price()); ?></span>
                            <?php } ?>
                                </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </li>
    <?php
        
        }
    ?>
</ul>
