<?php
// meta tag robots
osc_add_hook('header','pop_nofollow_construct');

pop_add_body_class('user user-profile');
osc_add_filter('meta_title_filter','custom_meta_title');
function custom_meta_title($data){
    return __('Search watchlist', 'pop');
}
osc_current_web_theme_path('header.php') ;
$osc_user = osc_user();
?>

<div class="container">
    <?php osc_current_web_theme_path('user-sidebar.php'); ?>
    <div class="user-content col-sm-8 col-md-9">
        <div class="header">
            <h1><?php _e('Search watchlist', 'pop'); ?></h1>
        </div>
        <?php if(osc_count_alerts() == 0) { ?>
        <h3><?php _e('You are not following any search yet', 'pop'); ?>.</h3>
        <?php } else { ?>
        <?php
                  $i = 1;
                  while(osc_has_alerts()) {

                      $alert = osc_alert();
                      //        echo osc_alert_search();
                      $_alert = array();

                      $a_c = json_decode(osc_alert_search(), true);

                      $search = new Search();
                      $search->setJsonAlert($a_c);

                      $_alert['dt_date'] = osc_alert_date();

                      // region
                      //        $_r = Region::newInstance()->findByPrimaryKey($a_c['regionId']);
                      //        if(isset($_r['s_name'])) {
                      //            $_alert['region']= $_r['s_name'];
                      //        }

                      $_alert['title'] = __('All listings', 'pop');
                      if($a_c['sPattern']!='') {
                          $_alert['title'] = ucfirst($a_c['sPattern']);
                          $a_c['sPattern'] = $a_c['sPattern'];
                      }

                      $_alert['categories'] = __('All categories', 'pop');
                      if(count($a_c['aCategories'])>0) {
                          $cat_id = array_shift( $a_c['aCategories'] );
                          $_c = Category::newInstance()->findByPrimaryKey($cat_id);
                          if(isset($_c['s_name'])) {
                              $_alert['categories'] = $_c['s_name'];
                              $a_c['category'] = $_c['s_slug'];
                          }
                      }
        ?>
        <div class="user-alerts">
            <div class="title-has-actions">
                <h3><?php echo $_alert['categories'] . ' | ' .  $a_c['sPattern']; ?></h3>
                <a href="#" class="unsubscribe" onclick="confirmDelete('#dialog-delete-alert','<?php echo osc_user_unsubscribe_alert_url(); ?>')"><?php _e('Unsubscribe', 'pop'); ?></a>
            </div>

            <div class="listings alert-items">
                <?php osc_current_web_theme_path('loop-items.php') ; ?>
                <?php if(osc_count_items() == 0) { ?>
                <br />
                0
           
                <?php _e('listings', 'pop'); ?>
                <?php } ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="divider"></div>
        <?php
                      $i++;
                  }
        ?>
        <?php  } ?>
    </div>
</div>
<div id="dialog-delete-alert" title="<?php echo osc_esc_html(__('Unsubscribe', 'pop')); ?>">
    <?php _e('Are you sure you want to unsubscribe from this search?', 'pop'); ?>
</div>

<script>
    $("#dialog-delete-alert").dialog({
        autoOpen: false,
        modal: true,
        width: 350
    });
</script>
<?php osc_current_web_theme_path('footer.php') ; ?>