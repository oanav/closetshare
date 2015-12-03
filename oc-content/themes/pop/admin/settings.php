<?php
?>
<?php if ( (!defined('ABS_PATH')) ) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if ( !OC_ADMIN ) exit('User access is not allowed.'); ?>
<?php if( !osc_get_preference('footer_link', 'pop_theme') && !osc_get_preference('donation', 'pop_theme') ) { ?>
<form name="_xclick" action="https://www.paypal.com/in/cgi-bin/webscr" method="post" class="nocsrf">
    <input type="hidden" name="cmd" value="_donations">
    <input type="hidden" name="rm" value="2">
    <input type="hidden" name="business" value="info@osclass.org">
    <input type="hidden" name="item_name" value="Osclass project">
    <input type="hidden" name="return" value="http://osclass.org/paypal/">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="lc" value="US" />
    <input type="hidden" name="custom" value="<?php echo osc_admin_render_theme_url('oc-content/themes/pop/admin/settings.php'); ?>&donation=successful&source=pop">
    <div id="flashmessage" class="flashmessage flashmessage-inline flashmessage-warning" style="color: #505050; display: block; ">
        <p><?php _e('I would like to contribute to the development of Osclass with a donation of', 'pop'); ?> <select name="amount" class="select-box-medium">
            <option value="50">50$</option>
            <option value="25">25$</option>
            <option value="10" selected>10$</option>
            <option value="5">5$</option>
            <option value=""><?php _e('Custom', 'pop'); ?></option>
        </select><input type="submit" class="btn btn-mini" name="submit" value="<?php echo osc_esc_html(__('Donate', 'pop')); ?>"></p>
    </div>
</form>
<?php } ?>
<h2 class="render-title <?php echo (osc_get_preference('footer_link', 'pop_theme') ? '' : 'separate-top'); ?>"><?php _e('Theme settings', 'pop'); ?></h2>
<form action="<?php echo osc_admin_render_theme_url('oc-content/themes/pop/admin/settings.php'); ?>" method="post" class="nocsrf">
    <input type="hidden" name="action_specific" value="settings" />
    <fieldset>
        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"><?php _e('Search placeholder', 'pop'); ?></div>
                <div class="form-controls"><input type="text" class="xlarge" name="keyword_placeholder" value="<?php echo osc_esc_html( osc_get_preference('keyword_placeholder', 'pop_theme') ); ?>"></div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Footer link', 'pop'); ?></div>
                <div class="form-controls">
                    <div class="form-label-checkbox"><input type="checkbox" name="footer_link" value="1" <?php echo (osc_get_preference('footer_link', 'pop_theme') ? 'checked' : ''); ?> > <?php _e('I want to help Osclass by linking to <a href="http://osclass.org/" target="_blank">osclass.org</a> from my site with the following text:', 'pop'); ?></div>
                    <span class="help-box"><?php _e('This website is proudly using the <a title="Osclass web" href="http://osclass.org/">classifieds scripts</a> software <strong>Osclass</strong>', 'pop'); ?></span>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"><?php _e('Premium ads per page', 'pop'); ?></div>
                <div class="form-controls"><input type="text" class="small" name="pop_max_premium" value="<?php echo osc_esc_html( osc_get_preference('pop_max_premium', 'pop_theme') ); ?>"></div>
            </div>
        </div>
    </fieldset>

    <h2 class="render-title"><?php _e('Ads management', 'pop'); ?></h2>
    <div class="form-row">
        <div class="form-label"></div>
        <div class="form-controls">
            <p><?php _e('In this section you can configure your site to display ads and start generating revenue.', 'pop'); ?><br/><?php _e('If you are using an online advertising platform, such as Google Adsense, copy and paste here the provided code for ads.', 'pop'); ?></p>
        </div>
    </div>
    <fieldset>
        <div class="form-horizontal">
            <div class="form-row">
                <div class="form-label"><?php _e('Header 728x90', 'pop'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="header-728x90"><?php echo osc_esc_html( osc_get_preference('header-728x90', 'pop_theme') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This ad will be shown at the top of your website, next to the site title and above the search results. Note that the size of the ad has to be 728x90 pixels.', 'pop'); ?></div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Search results 300x250', 'pop'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="search-results-300x250"><?php echo osc_esc_html( osc_get_preference('search-results-300x250', 'pop_theme') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This ad will be shown as a listing in the search page results of your website. Note that the size of the ad has to be 300x350 pixels.', 'pop'); ?></div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-label"><?php _e('Listing detail 300x250', 'pop'); ?></div>
                <div class="form-controls">
                    <textarea style="height: 115px; width: 500px;" name="item-detail-300x250"><?php echo osc_esc_html( osc_get_preference('item-detail-300x250', 'pop_theme') ); ?></textarea>
                    <br/><br/>
                    <div class="help-box"><?php _e('This ad will be shown at the right sidebar of your website, on the product detail page. Note that the size of the ad has to be 300x350 pixels.', 'pop'); ?></div>
                </div>
            </div>
            <div class="form-actions">
                <input type="submit" value="<?php _e('Save changes', 'pop'); ?>" class="btn btn-submit">
            </div>
        </div>
    </fieldset>
</form>