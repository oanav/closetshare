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
    osc_add_hook('header','osclasswizards_nofollow_construct');
    osc_enqueue_script('jquery-validate');
    osclasswizards_add_body_class('item item-post');
    $action = 'item_add_post';
    $edit = false;
    if(Params::getParam('action') == 'item_edit'){
        $action = 'item_edit_post';
        $edit = true;
    }
?>
<?php osc_current_web_theme_path('header.php') ; ?>
<?php ItemForm::location_javascript_new(); ?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="wraps">
            <div class="title">
                <h1>
                    <?php _e('Publish a listing', 'osclasswizards'); ?>
                </h1>
            </div>
            <ul id="error_list">
            </ul>
            <form name="item" action="<?php echo osc_base_url(true);?>" method="post" enctype="multipart/form-data" id="item-post">
                <fieldset>
                    <input type="hidden" name="action" value="<?php echo $action; ?>" />
                    <input type="hidden" name="page" value="item" />
                    <?php if($edit){ ?>
                    <input type="hidden" name="id" value="<?php echo osc_item_id();?>" />
                    <input type="hidden" name="secret" value="<?php echo osc_item_secret();?>" />
                    <?php } ?>
                    <h2>
                        <?php _e('General Information', 'osclasswizards'); ?>
                    </h2>
                    <div class="form-group">
                        <label class="control-label" for="select_1">
                            <?php _e('Category', 'osclasswizards'); ?>
                        </label>
                        <div class="controls">
                            <?php  if ( osc_count_categories() ) { ?>
                            <?php osc_categories_select('catId', null, __('Select a category', 'osclasswizards')) ; ?>
                            <?php  } ?>
                            <?php //ItemForm::category_select(null, null, __('Select a category', 'osclasswizards')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="title[<?php echo osc_locale_code(); ?>]">
                            <?php _e('Title', 'osclasswizards'); ?>
                        </label>
                        <div class="controls">
                            <?php ItemForm::title_input('title',osc_locale_code(), osc_esc_html( osclasswizards_item_title() )); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="description[<?php echo osc_locale_code(); ?>]">
                            <?php _e('Description', 'osclasswizards'); ?>
                        </label>
                        <div class="controls">
                            <?php ItemForm::description_textarea('description',osc_locale_code(), osc_esc_html( osclasswizards_item_description() )); ?>
                        </div>
                    </div>
                    <?php if( osc_price_enabled_at_items() ) { ?>
                    <div class="form-group form-group-price">
                        <label class="control-label" for="price">
                            <?php _e('Price', 'osclasswizards'); ?>
                        </label>
                        <div class="controls">


                            <ul class="row">

                                <li class="col-sm-5 col-md-5"><?php ItemForm::price_input_text(); ?></li>
                                <li class="col-sm-7 col-md-7"><?php ItemForm::currency_select(); ?></li>

                            </ul>








                        </div>
                    </div>
                    <div id="plugin-hook"></div>
                    <div class="box">
                        <h2>
                            <?php _e("Images", 'osclasswizards'); ?>
                        </h2>
                        <?php } ?>
                        <?php
                            if( osc_images_enabled_at_items() ) {
                                                       ItemForm::ajax_photos();
                                                    }
                        ?>
                    </div>
                    <div class="box location">
                        <h2>
                            <?php _e('Listing Location', 'osclasswizards'); ?>
                        </h2>
                        <div class="row">
                        <div class="form-group col-md-12">
                            <label class="control-label" for="country">
                                <?php _e('Country', 'osclasswizards'); ?>
                            </label>
                            <div class="controls">
                                <?php ItemForm::country_select(osc_get_countries(), osc_user()); ?>
                            </div>
                        </div>
                            </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="region">
                                <?php _e('Region', 'osclasswizards'); ?>
                            </label>
                            <div class="controls">
                                <?php ItemForm::region_text(osc_user()); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="city">
                                <?php _e('City', 'osclasswizards'); ?>
                            </label>
                            <div class="controls">
                                <?php ItemForm::city_text(osc_user()); ?>
                            </div>
                        </div>
                            </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="cityArea">
                                <?php _e('City Area', 'osclasswizards'); ?>
                            </label>
                            <div class="controls">
                                <?php ItemForm::city_area_text(osc_user()); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="address">
                                <?php _e('Address', 'osclasswizards'); ?>
                            </label>
                            <div class="controls">
                                <?php ItemForm::address_text(osc_user()); ?>
                            </div>
                        </div>
                            </div>
                    </div>
                    <!-- seller info -->
                    <?php if(!osc_is_web_user_logged_in() ) { ?>
                    <div class="box seller_info">
                        <h2>
                            <?php _e("Seller's information", 'osclasswizards'); ?>
                        </h2>
                        <div class="form-group">
                            <label class="control-label" for="contactName">
                                <?php _e('Name', 'osclasswizards'); ?>
                            </label>
                            <div class="controls">
                                <?php ItemForm::contact_name_text(); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="contactEmail">
                                <?php _e('E-mail', 'osclasswizards'); ?>
                            </label>
                            <div class="controls">
                                <?php ItemForm::contact_email_text(); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="controls checkbox">
                                <?php ItemForm::show_email_checkbox(); ?>
                                <label for="showEmail">
                                    <?php _e('Show e-mail on the listing page', 'osclasswizards'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                        if($edit) {
                            ItemForm::plugin_edit_item();
                        } else {
                            ItemForm::plugin_post_item();
                        }
                    ?>
                    <div class="form-group">
                        <?php if( osc_recaptcha_items_enabled() ) { ?>
                        <div class="controls">
                            <?php osc_show_recaptcha(); ?>
                        </div>
                        <?php }?>
                        <div class="controls">
                            <button type="submit" class="btn btn-success btn-publish">
                                <?php if($edit) { _e("Update", 'osclasswizards'); } else { _e("Publish", 'osclasswizards'); } ?>
                            </button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
            $('#price').bind('hide-price', function(){
                $('.form-group-price').hide();
            });
            $('#price').bind('show-price', function(){
                $('.form-group-price').show();
            });
    <?php if(osc_locale_thousands_sep()!='' || osc_locale_dec_point() != '') { ?>
    $().ready(function(){
        $("#price").blur(function(event) {
            var price = $("#price").prop("value");
            <?php if(osc_locale_thousands_sep()!='') { ?>
            while(price.indexOf('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>')!=-1) {
                price = price.replace('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>', '');
            }
            <?php }; ?>
            <?php if(osc_locale_dec_point()!='') { ?>
            var tmp = price.split('<?php echo osc_esc_js(osc_locale_dec_point())?>');
            if(tmp.length>2) {
                price = tmp[0]+'<?php echo osc_esc_js(osc_locale_dec_point())?>'+tmp[1];
            }
            <?php }; ?>
            $("#price").prop("value", price);
        });
    });
    <?php }; ?>
</script>
<?php osc_current_web_theme_path('footer.php'); ?>
