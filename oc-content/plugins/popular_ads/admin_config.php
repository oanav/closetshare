<?php
    $num_ads = '';
    if(Params::getParam('num_ads') != ''){
	$num_ads = Params::getParam('num_ads');
    } else{
	$num_ads = popular_ads_num_ads();
    }


    if( Params::getParam('option') == 'update' )
    {

	osc_set_preference('popularads_num_ads', $num_ads, 'plugin-popular_ads', 'INTEGER');

	osc_add_flash_ok_message(__('Number of ads to display successfully updated'),'admin');

	echo '<script>location.href="'.osc_admin_render_plugin_url('popular_ads/admin_config.php').'"</script>';

    }

?>


<div style="border: 5px solid #ccc; padding:10px; background: #eee;
	    -moz-border-radius:20px;
	    -webkit-border-radius:20px;
	    border-radius: 20px;">

        <fieldset style="border-color:#ccc;">
	    <legend><h2>Popular Ads - Configure</h2></legend>
There is currently only one option that needs to be set for this plugin, and that is the number of popular ads you wish to display.
<br><br>
How are popular ads determined? - They are based on the total number of active item/ad views. That means an item <i>must</i> be active in order to be included.
<br><br>

    <form name="adexpiration" action="<?php echo osc_admin_base_url(true); ?>" method="POST" enctype="multipart/form-data" >
	<input type="hidden" name="page" value="plugins" />
	<input type="hidden" name="action" value="renderplugin" />
	<input type="hidden" name="file" value="popular_ads/admin_config.php" />
	<input type="hidden" name="option" value="update" />
	    <b>Number of popular ads to display:</b> <input type="text" name="num_ads" id="num_ads" size="3" maxlength="3" value="<?php echo $num_ads; ?>" />
	    <br /><br />
	    <button type="submit">Submit</button>
    </form>
	</fieldset>



</div> <!-- end file-->