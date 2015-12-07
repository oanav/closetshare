 <form action="<?php echo osc_base_url(true); ?>" method="get" class="search quick-search nocsrf">
        <div class="container">
            <input type="hidden" name="page" value="search" />
                <div class="row">
                    <div class="col-md-4">
                            <input type="text" name="sPattern" id="query" class="input-text" value="" placeholder="<?php _e('Search...', 'pop'); ?>" />
                    </div>
                    <div class="col-md-3">
                        <div class=" selector">
                            <?php osc_categories_select('sCategory', null, __('Select a category', 'pop')) ; ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class=" selector">
                            <?php 
    $aCountries = osc_get_countries();
    $aRegions = osc_get_regions($aCountries[0]['pk_c_code']);
                            ?>
                            <?php ItemForm::region_select($aRegions); ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                            <button class="btn btn-primary btn_search">
                                <?php _e("Search", 'pop');?>
                            </button>
                    </div>
                </div>
                <div id="message-seach"></div>
        </div>
    </form>
