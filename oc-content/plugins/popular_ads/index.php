<?php
/*
Plugin Name: Popular Ads
Plugin URI: http://www.osclass.org
Description: Determines and displays the most popular active ads
Version: 1.1
Author: Jesse - TurbineJesse@gmail.com
Author URI: http://www.osclass.org/
Short Name: popular_ads
*/




function popular_ads_install() {
      	osc_set_preference('popularads_num_ads', '5', 'plugin-popular_ads', 'INTEGER');
}



function popular_ads_uninstall() {
	osc_delete_preference('popularads_num_ads', 'plugin-popular_ads');
}




// Admin menu :: Help page
function popular_ads_admin_help() {
    echo '<h3><a href="#">Popular Ads</a></h3>
    <ul>
	<li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin_config.php') . '">&raquo; ' . __('Configure', 'Popular Ads') . '</a><li>
	<li><a href="' . osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . 'admin_help.php') . '">&raquo; ' . __('Help', 'Popular Ads') . '</a><li>
    </ul>';
}




// HELPER - retreives preference for number of ads to display
function popular_ads_num_ads() {
    return(osc_get_preference('popularads_num_ads', 'plugin-popular_ads')) ;
}





// function for displaying text on the Item page
function popular_ads_start() {

    $num_ads = popular_ads_num_ads(); // SETS HOW MANY POPULAR ADS TO DISPLAY


    $conn = getConnection();
    $results=$conn->osc_dbFetchResults("SELECT fk_i_item_id, i_num_views FROM %st_item_stats ORDER BY fk_i_item_id ASC", DB_TABLE_PREFIX);

    if(count($results)>0){
	foreach($results as $result){
	    $view_count[$result['fk_i_item_id']] += $result['i_num_views']; // Add-up all item views stored in database
	}

	arsort($view_count); // sorts array by highest number of item views first

	foreach($view_count as $item_id=>$views)
	{
	    $result=$conn->osc_dbFetchResult("SELECT fk_i_user_id, fk_i_category_id, dt_pub_date, dt_mod_date, f_price, b_active, i_price, fk_c_currency_code, b_premium, s_secret FROM %st_item WHERE pk_i_id = %d", DB_TABLE_PREFIX, $item_id); //Get active status of item

	    if($result['b_active']==1){ //if active...
	        //echo 'Item ID: '.$item_id.' Views: '.$views.'<br>'; // display only if item is active
		$index++;

		// get description
	        $desc=$conn->osc_dbFetchResult("SELECT fk_c_locale_code, s_title, s_description FROM %st_item_description WHERE fk_i_item_id = %d", DB_TABLE_PREFIX, $item_id); //Get active status of item
	        $location=$conn->osc_dbFetchResult("SELECT fk_c_country_code, s_country, fk_i_region_id, s_region, fk_i_city_id, s_city FROM %st_item_location WHERE fk_i_item_id = %d", DB_TABLE_PREFIX, $item_id); //Get active status of item

		// store the data in an array...
		$item_array[] =   array('fk_i_user_id'=>$result['fk_i_user_id'],
					'fk_i_category_id'=>$result['fk_i_category_id'],
					'dt_pub_date'=>$result['dt_pub_date'],
					'dt_mod_date'=>$result['dt_mode_date'],
					'f_price'=>$result['f_price'],
					'fk_i_item_id'=>$item_id,
					'pk_i_id'=>$item_id,
					'b_active'=>$result['b_active'],
					'i_price'=>$result['i_price'],
					'fk_c_currency_code'=>$result['fk_c_currency_code'],
					'b_premium'=>$result['b_premium'],
					'fk_c_locale_code'=>$desc['fk_c_locale_code'],
					's_title'=>$desc['s_title'],
					's_description'=>$desc['s_description'],
					'fk_c_country_code'=>$location['fk_c_country_code'],
					's_country'=>$location['s_country'],
					'fk_i_region_id'=>$location['fk_i_region_id'],
					's_region'=>$location['s_region'],
					'fk_i_city_id'=>$location['fk_i_city_id'],
					's_city'=>$location['s_city'],
					's_secret'=>$result['s_secret'],
					'locale'=>array('en_US'=>array('fk_i_item_id'=>$item_id,
									'fk_c_locale_code'=>$desc['fk_c_locale_code'],
									's_title'=>$desc['s_title'],
									's_description'=>$desc['s_description'],
									's_what'=>$desc['s_what']
									)
							)				
					);
    	    }
	    if($index>=$num_ads) break; // limit number of ads to display
	}

	GLOBAL $stored_items;
	$stored_items = View::newInstance()->_get('item') ; //save existing item array
	View::newInstance()->_exportVariableToView('items', $item_array);


    } else echo 'No Results.';
}






function popular_ads_end(){
GLOBAL $stored_items;
   View::newInstance()->_exportVariableToView('items', $stored_items); //restore original item array
}





function pop_ad_style(){
   	echo '<link href="' . osc_base_url() . "oc-content/plugins/popular_ads/pop_ads_style.css" . '" rel="stylesheet" type="text/css" />';
}

   
    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'popular_ads_install') ;

    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'popular_ads_uninstall') ;


    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), '') ;

    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', '') ;

    // Include our style sheet in the header
    osc_add_hook('header', 'pop_ad_style');

    // Add the Help page to the admin menu
    osc_add_hook('admin_menu', 'popular_ads_admin_help');
    
?>