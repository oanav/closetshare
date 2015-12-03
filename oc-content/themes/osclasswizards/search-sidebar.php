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
     $category = __get("category");
     if(!isset($category['pk_i_id']) ) {
         $category['pk_i_id'] = null;
     }

?>

<div class="col-sm-4 col-md-3">
  <aside id="sidebar">
    <div class="block">
      <h2>
        <?php _e('Advanced Search', 'osclasswizards') ; ?>
      </h2>
      <section>
        <div class="filters">
          <form action="<?php echo osc_base_url(true); ?>" method="get" class="nocsrf">
            <input type="hidden" name="page" value="search"/>
            <input type="hidden" name="sOrder" value="<?php echo osc_search_order(); ?>" />
            <input type="hidden" name="iOrderType" value="<?php $allowedTypesForSorting = Search::getAllowedTypesForSorting() ; echo $allowedTypesForSorting[osc_search_order_type()]; ?>" />
            <?php foreach(osc_search_user() as $userId) { ?>
            <input type="hidden" name="sUser[]" value="<?php echo $userId; ?>"/>
            <?php } ?>
            <fieldset class="first">
              <h3>
                <?php _e('Your search', 'osclasswizards'); ?>
              </h3>
              <div class="row">
                <input class="input-text" type="text" name="sPattern"  id="query" value="<?php echo osc_esc_html(osc_search_pattern()); ?>" />
              </div>
            </fieldset>
            <fieldset>
              <h3>
                <?php _e('City', 'osclasswizards'); ?>
              </h3>
              <div>
                <input class="input-text" type="text" id="sCity" name="sCity" value="<?php echo osc_esc_html(osc_search_city()); ?>" />
              </div>
            </fieldset>
                    <fieldset>
              <h3>
                <?php _e('Region', 'osclasswizards'); ?>
              </h3>
              <div>
                <input class="input-text" type="text" id="sRegion" name="sRegion" value="<?php echo osc_esc_html(osc_search_region()); ?>" />
              </div>
            </fieldset>
            <?php if( osc_images_enabled_at_items() ) { ?>
            <fieldset>
              <h3>
                <?php _e('Show only', 'osclasswizards') ; ?>
              </h3>
              <div class="checkbox">
                <input type="checkbox" name="bPic" id="withPicture" value="1" <?php echo (osc_search_has_pic() ? 'checked' : ''); ?> />
                <label for="withPicture">
                  <?php _e('listings with pictures', 'osclasswizards') ; ?>
                </label>
              </div>
            </fieldset>
            <?php } ?>
            <?php if( osc_price_enabled_at_items() ) { ?>
            <fieldset>
              <div class="price-slice">
                <h3>
                  <?php _e('Price', 'osclasswizards') ; ?>
                </h3>
                <ul class="row">
                  <li class="col-md-6"> <span>
                    <?php _e('Min', 'osclasswizards') ; ?>
                    :</span>
                    <input class="input-text" type="text" id="priceMin" name="sPriceMin" value="<?php echo osc_esc_html(osc_search_price_min()); ?>" size="6" maxlength="6" />
                  </li>
                  <li class="col-md-6"> <span>
                    <?php _e('Max', 'osclasswizards') ; ?>
                    :</span>
                    <input class="input-text" type="text" id="priceMax" name="sPriceMax" value="<?php echo osc_esc_html(osc_search_price_max()); ?>" size="6" maxlength="6" />
                  </li>
                </ul>
              </div>
            </fieldset>
            <?php } ?>
            <div class="plugin-hooks">
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
        foreach($aCategories as $cat_id) { ?>
            <input type="hidden" name="sCategory[]" value="<?php echo osc_esc_html($cat_id); ?>"/>
            <?php } ?>
            
            <div class="actions">
              <button type="submit" class="btn btn-success">
              <?php _e('Apply', 'osclasswizards') ; ?>
              </button>
            </div>
          </form>
        </div>
      </section>
    </div>
    <div class="block">
      <h2>
        <?php _e('Refine category', 'osclasswizards') ; ?>
      </h2>
      <section>
        <div class="search_filter">
          <?php osclasswizards_sidebar_category_search($category['pk_i_id']); ?>
        </div>
      </section>
    </div>
    <div class="block">
      <h2>
        <?php _e('Subscribe to this search', 'osclasswizards') ; ?>
      </h2>
      <section>
        <?php osc_alert_form(); ?>
      </section>
    </div>
  </aside>
</div>
