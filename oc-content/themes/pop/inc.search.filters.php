    <form id="filterForm" name="filterForm" action="<?php echo osc_base_url(true); ?>" method="get" class="nocsrf">
        <input type="hidden" name="page" value="search" />
        <input type="hidden" name="sOrder" value="<?php echo osc_search_order(); ?>" />
        <input type="hidden" name="iOrderType" value="<?php $allowedTypesForSorting = Search::getAllowedTypesForSorting() ; echo $allowedTypesForSorting[osc_search_order_type()]; ?>" />
        <?php foreach(osc_search_user() as $userId) { ?>
        <input type="hidden" name="sUser[]" value="<?php echo $userId; ?>" />
        <?php } ?>
       <!-- <fieldset class="form-group">
            <label> <?php _e('Category', 'pop')?></label>
            <?php osc_categories_select('Scategory', $category) ?>
        </fieldset>-->
        <fieldset class="form-group">
            <label>
                <?php _e('Key words', 'pop'); ?>
            </label>
            <input class="input-text" type="text" name="sPattern" id="query" value="<?php echo osc_esc_html(osc_search_pattern()); ?>" />
        </fieldset>
       
        <fieldset class="form-group">
            <label>
                <?php _e('Region', 'pop'); ?>
            </label>
            <div>
                <?php
                $sCountries = osc_get_countries();
                $countryId = $sCountries[0]['pk_c_code'];
                $sRegions = osc_get_regions($countryId);
                ?>
               <?php location_autocomplete($sRegions); ?>
                 <input type="hidden" id="countryId" name="countryId" value="<?php echo $countryId; ?>" />
                  <input class="input-text" type="text" id="region" name="sRegion" value="<?php echo osc_esc_html(osc_search_region()); ?>" />
                <input type="hidden" id="regionId" name="regionId" />
            </div>
        </fieldset>
       <!--  <fieldset class="form-group">
            <label>
                <?php _e('City', 'pop'); ?>
            </label>
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
        <?php } ?>-->
        <?php if( osc_price_enabled_at_items() ) { ?>
        <fieldset class="form-group price">
                <label>
                    <?php _e('Price', 'pop') ; ?>
                </label>
                <div class="">
                
                        <input class="input-text" type="text" id="priceMin" name="sPriceMin" value="<?php echo osc_esc_html(osc_search_price_min()); ?>" size="6" maxlength="6" placeholder="Min"/>
                        <input class="input-text" type="text" id="priceMax" name="sPriceMax" value="<?php echo osc_esc_html(osc_search_price_max()); ?>" size="6" maxlength="6" placeholder="Max" />
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

        <a class="clear" onclick="formReset($('#filterForm'))">
            <i class="fa fa-times"></i><?php echo _e('Clear filters', 'pop')?></a>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <?php _e('Apply filters', 'pop') ; ?>
            </button>
        <!-- <a href="#" class="sub_button" >
                <i class="fa fa-star-o"></i>
                <?php _e('Save search', 'pop'); ?></a>-->
          
        </div>
           
    </form>
<script type="text/javascript">
$(document).ready(function(){
    $(".sub_button").click(function(){
        $.post('<?php echo osc_base_url(true); ?>', {email:$("#alert_email").val(), userid:$("#alert_userId").val(), alert:$("#alert").val(), page:"ajax", action:"alerts"},
            function(data){
                if(data==1) { swal('<?php echo osc_esc_js(__('You have sucessfully subscribed to the alert', 'pop')); ?>'); }
                else if(data==-1) { swal('<?php echo osc_esc_js(__('Invalid email address', 'pop')); ?>'); }
                else { swal('<?php echo osc_esc_js(__('Could not subscribe to this alert', 'pop')); ?>');
                };
        });
        return false;
    });
});
</script>