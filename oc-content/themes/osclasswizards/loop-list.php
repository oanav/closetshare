<?php /* * Osclass – software for creating and publishing online classified * advertising platforms * * Copyright (C) 2014 OSCLASS * * This program is free software: you can redistribute it and/or * modify it under the terms of the GNU Affero General Public License * as published by the Free Software Foundation, either version 3 of * the License, or (at your option) any later version. * * This program is distributed in the hope that it will be useful, but * WITHOUT ANY WARRANTY; without even the implied warranty of * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the * GNU Affero General Public License for more details. * * You should have received a copy of the GNU Affero General Public * License along with this program. If not, see <http://www.gnu.org/licenses/>. */ ?>
<?php $type='items' ; if(View::newInstance()->_exists('listType')){ $type = View::newInstance()->_get('listType'); } ?>

<ul class="listing-card-list" id="listing-card-list">
    <?php $i=0 ; //latest items if($type=='latestItems' ){ while ( osc_has_latest_items() ) { ?>
    <?php $size=e xplode( 'x', osc_thumbnail_dimensions()); ?>
    <li class="listing-card <?php if(osc_item_is_premium()){ echo ' premium'; } ?>">
        <?php if( osc_images_enabled_at_items() ) { ?>
        <div class="row">
            <div class="col-sm-4 col-md-3">
                <?php if(osc_count_item_resources()) { ?>
                <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="img-responsive"></a>
                <?php } else { ?>
                <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="img-responsive"></a>
                <?php } ?>
                <?php } ?>
            </div>
            <div class="col-sm-8 col-md-9">
                <div class="info">
                    <div class="detail_info">
                        <h4><a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><?php echo osc_item_title() ; ?></a><span>
              <?php _e('Premium','osclasswizards');?>
              </span></h4>
                        <div class="listing-attributes"> <span class="category"><strong>
              <?php _e('Category','osclasswizards');?>
              :</strong> <?php echo osc_item_category() ; ?></span> - <span class="location"><strong>
              <?php _e('Location', 'osclasswizards');?>
              :</strong> <?php echo osc_item_city(); ?>
              <?php if( osc_item_region()!='' ) { ?>
              (<?php echo osc_item_region(); ?>)
              <?php } ?>
              </span>
                            <span class="currency-value"><strong>
              <?php _e('Price','osclasswizards');?>
              :</strong> <?php echo osc_format_price(osc_item_price()); ?></span>
                            <?php } ?>
                        </div>
                        <p>
                            <?php echo osc_highlight( osc_item_description() ,250) ; ?>
                        </p>
                    </div>
                    <?php $admin=f alse; ?>
                    <?php if($admin){ ?>
                    <span class="admin-options"> <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow">
          <?php _e('Edit item', 'osclasswizards'); ?>
          </a> <span>|</span>
                    <a class="delete" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'osclasswizards')); ?>')" href="<?php echo osc_item_delete_url();?>">
                        <?php _e( 'Delete', 'osclasswizards'); ?>
                    </a>
                    <?php if(osc_item_is_inactive()) {?>
                    <span>|</span>
                    <a href="<?php echo osc_item_activate_url();?>">
                        <?php _e( 'Activate', 'osclasswizards'); ?>
                    </a>
                    <?php } ?>
                    </span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </li>
    <?php } } // premium items elseif($type=='premiums' ){ while ( osc_has_premiums() ) { ?>
    <?php $size=e xplode( 'x', osc_thumbnail_dimensions()); ?>
    <li class="listing-card premium">
        <?php if( osc_images_enabled_at_items() ) { ?>
        <?php if(osc_count_premium_resources()) { ?>
        <a class="listing-thumb" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
        <?php } else { ?>
        <a class="listing-thumb" href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_premium_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>"></a>
        <?php } ?>
        <?php } ?>
        <div class="listing-detail">
            <div class="listing-cell">
                <div class="listing-data">
                    <div class="listing-basicinfo">
                        <a href="<?php echo osc_premium_url() ; ?>" title="<?php echo osc_esc_html(osc_premium_title()) ; ?>">
                            <?php echo osc_premium_title() ; ?>
                        </a>
                        <div class="listing-attributes"> <span class="category"><strong>
              <?php _e('Category','osclasswizards');?>
              :</strong> <?php echo osc_premium_category() ; ?></span> - <span class="location"><strong>
              <?php _e('Location', 'osclasswizards');?>
              :</strong> <?php echo osc_premium_city(); ?>
              <?php if(osc_premium_region()!='') { ?>
              (<?php echo osc_premium_region(); ?>)
              <?php } ?>
              </span>
                            <span class="currency-value"><strong>
              <?php _e('Price','osclasswizards');?>
              :</strong> <?php echo osc_format_price(osc_premium_price()); ?></span>
                            <?php } ?>
                        </div>
                        <p>
                            <?php echo osc_highlight( osc_premium_description(), 250 ); ?>
                        </p>
                    </div>
                    <?php $admin=f alse; ?>
                    <?php if($admin){ ?>
                    <span class="admin-options"> <a href="<?php echo osc_premium_edit_url(); ?>" rel="nofollow">
          <?php _e('Edit item', 'osclasswizards'); ?>
          </a> <span>|</span>
                    <a class="delete" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'osclasswizards')); ?>')" href="<?php echo osc_premium_delete_url();?>">
                        <?php _e( 'Delete', 'osclasswizards'); ?>
                    </a>
                    <?php if(osc_premium_is_inactive()) {?>
                    <span>|</span>
                    <a href="<?php echo osc_premium_activate_url();?>">
                        <?php _e( 'Activate', 'osclasswizards'); ?>
                    </a>
                    <?php } ?>
                    </span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </li>
    <?php } } else { while(osc_has_items()) { $admin=f alse; if(View::newInstance()->_exists("listAdmin")){ $admin = true; } ?>
    <?php $size=e xplode( 'x', osc_thumbnail_dimensions()); ?>
    <li class="listing-card <?php if(osc_item_is_premium()){ echo ' premium'; } ?>">
        <?php if( osc_images_enabled_at_items() ) { ?>
        <div class="row">
            <div class="col-sm-4 col-md-3">
                <?php if(osc_count_item_resources()) { ?>
                <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_resource_thumbnail_url(); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="img-responsive"></a>
                <?php } else { ?>
                <a class="listing-thumb" href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" title="" alt="<?php echo osc_esc_html(osc_item_title()) ; ?>" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="img-responsive"></a>
                <?php } ?>
                <?php } ?>
            </div>
            <div class="col-sm-8 col-md-9">
                <div class="info">
                    <div class="detail_info">
                        <h4><a href="<?php echo osc_item_url() ; ?>" title="<?php echo osc_esc_html(osc_item_title()) ; ?>"><?php echo osc_item_title() ; ?></a><span>
              <?php _e('Premium','osclasswizards');?>
              </span></h4>
                        <div class="listing-attributes"> <span class="category"><strong>
              <?php _e('Category','osclasswizards');?>
              :</strong> <?php echo osc_item_category() ; ?></span> - <span class="location"><strong>
              <?php _e('Location', 'osclasswizards');?>
              :</strong> <?php echo osc_item_city(); ?>
              <?php if( osc_item_region()!='' ) { ?>
              (<?php echo osc_item_region(); ?>)
              <?php } ?>
              </span> 
                            <span class="currency-value"><strong>
              <?php _e('Price','osclasswizards');?>
              :</strong> <?php echo osc_format_price(osc_item_price()); ?></span>
                            <?php } ?>
                        </div>
                        <p>
                            <?php echo osc_highlight( osc_item_description() ,250) ; ?>
                        </p>
                    </div>
                    <?php if($admin){ ?>
                    <span class="admin-options"> <a href="<?php echo osc_item_edit_url(); ?>" rel="nofollow">
          <?php _e('Edit item', 'osclasswizards'); ?>
          </a> <span>|</span>
                    <a class="delete" onclick="javascript:return confirm('<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'osclasswizards')); ?>')" href="<?php echo osc_item_delete_url();?>">
                        <?php _e( 'Delete', 'osclasswizards'); ?>
                    </a>
                    <?php if(osc_item_is_inactive()) {?>
                    <span>|</span>
                    <a href="<?php echo osc_item_activate_url();?>">
                        <?php _e( 'Activate', 'osclasswizards'); ?>
                    </a>
                    <?php } ?>
                    </span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </li>
    <?php } } ?>
</ul>