<div style="border: 5px solid #ccc; padding:10px; background: #eee;
	    -moz-border-radius:20px;
	    -webkit-border-radius:20px;
	    border-radius: 20px;">

	<?php $directory = osc_base_url() . 'oc-content/plugins/picture_order/'; ?>

	<img src="<?php echo $directory.'pdlogo.png'; ?>" width="250">


        <fieldset style="border-color:#ccc;">
	    <legend><h2>Popular Ads - Help</h2></legend>
	This plugin will allow you to display the "most popular ads" using standard OSClass Helper functions, just like the way "Latest Items" are displayed on the Main page.
	<br><br>
	To use the plugin, there are two functions that must be called before and after your "most popular ads" section. The two functions and the
	general format for them are:


	<pre style="background:white; border: 2px dashed #ccc;">
	<b>&lt;?php popular_ads_start(); ?&gt;</b>
	    .... write your code here ....
	<b>&lt;?php popular_ads_end(); ?&gt;</b></pre>

	<br><br>
	<h2>Basic Example:</h2>
	Here is a simple loop that will cycle through the entire array and display some information:

	<pre style="background:white; border: 2px dashed #ccc;">
	&lt;?php popular_ads_start(); ?&gt;
	    &lt;?php if( osc_count_items() &gt; 0) {
	        while ( osc_has_items() ) {
	            echo 'Item ID: '.osc_item_id().' Title: '.osc_item_title().' Views: '.osc_item_views().'&lt;br&gt;';
	        }
	    }
	    ?&gt;
	&lt;?php popular_ads_end(); ?&gt;
	</pre>

<br><br>
<h2>Complete Working Example:</h2>
This is a complete, working example taken directly from the "Latest Items" section on the Main page (BCute theme):

<pre style="background:white; border: 2px dashed #ccc;">
&lt;?php popular_ads_start(); ?&gt;
    &lt;div class=&quot;pop_ads&quot;&gt;
	&lt;h1&gt;&lt;strong&gt;&lt;?php _e('Most Popular Ads', 'bcute') ; ?&gt;&lt;/strong&gt;&lt;/h1&gt;
	    &lt;?php if( osc_count_items() == 0) { ?&gt;
		&lt;p class=&quot;empty&quot;&gt;&lt;?php _e('No Popular Ads', 'bcute') ; ?&gt;&lt;/p&gt;
	    &lt;?php } else { ?&gt;
		&lt;table border=&quot;0&quot; cellspacing=&quot;0&quot;&gt;
		    &lt;tbody&gt;
			&lt;?php $class = &quot;even&quot;; ?&gt;
			&lt;?php while ( osc_has_items() ) { ?&gt;
			&lt;tr class=&quot;&lt;?php echo $class. (osc_item_is_premium()?&quot; premium&quot;:&quot;&quot;) ; ?&gt;&quot;&gt;
			&lt;?php if( osc_images_enabled_at_items() ) { ?&gt;
			    &lt;td class=&quot;photo&quot;&gt;
				&lt;?php if( osc_item_is_premium() ){ ?&gt;
				&lt;div id=&quot;premium_img&quot;&gt;&lt;/div&gt;
				&lt;?php }?&gt;
				&lt;?php if( osc_count_item_resources() ) { ?&gt;
				    &lt;a href=&quot;&lt;?php echo osc_item_url() ; ?&gt;&quot;&gt;
					&lt;img src=&quot;&lt;?php echo osc_resource_thumbnail_url() ; ?&gt;&quot; width=&quot;75&quot; height=&quot;56&quot; title=&quot;&quot; alt=&quot;&quot; /&gt;
				    &lt;/a&gt;
				&lt;?php } else { ?&gt;
				    &lt;a href=&quot;&lt;?php echo osc_item_url() ; ?&gt;&quot;&gt;
					&lt;img src=&quot;&lt;?php echo osc_current_web_theme_url('images/no_photo.gif') ; ?&gt;&quot; alt=&quot;&quot; title=&quot;&quot;/&gt;
				    &lt;/a&gt;
				    &lt;?php } ?&gt;
			    &lt;/td&gt;
			&lt;?php } ?&gt;
			    &lt;td class=&quot;text&quot;&gt;
				&lt;div class=&quot;price-wrap&quot;&gt;&lt;span class=&quot;tag-head&quot;&gt;&lt;/span&gt;&lt;p class=&quot;price&quot;&gt;&lt;?php if( osc_price_enabled_at_items() ) echo osc_item_formated_price() ; ?&gt;&lt;/p&gt;&lt;/div&gt;
				&lt;h3&gt;&lt;a href=&quot;&lt;?php echo osc_item_url() ; ?&gt;&quot;&gt;&lt;?php echo osc_item_title() ; ?&gt;&lt;/a&gt;&lt;/h3&gt;
				&lt;p&gt;&lt;strong&gt;&lt;?php if( osc_price_enabled_at_items() ) { echo osc_item_formated_price() ; ?&gt; - &lt;?php } echo osc_item_city(); ?&gt; (&lt;?php echo osc_item_region();?&gt;) - &lt;?php echo osc_format_date(osc_item_pub_date()); ?&gt;&lt;/strong&gt;&lt;/p&gt;
				&lt;p&gt;&lt;?php echo osc_highlight( strip_tags( osc_item_description() ) ) ; ?&gt;&lt;/p&gt;
			    &lt;/td&gt;                                       
			&lt;/tr&gt;
			&lt;?php $class = ($class == 'even') ? 'odd' : 'even' ; ?&gt;
			&lt;?php } ?&gt;
		    &lt;/tbody&gt;
		&lt;/table&gt;
		&lt;?php if( osc_count_latest_items() == osc_max_latest_items() ) { ?&gt;
		    &lt;p class=&quot;see_more_link&quot;&gt;&lt;a href=&quot;&lt;?php echo osc_search_show_all_url();?&gt;&quot;&gt;&lt;strong&gt;&lt;?php _e(&quot;See all offers&quot;, 'modern'); ?&gt; &amp;raquo;&lt;/strong&gt;&lt;/a&gt;&lt;/p&gt;
		&lt;?php } ?&gt;
	    &lt;?php } ?&gt;
    &lt;/div&gt;
&lt;?php popular_ads_end(); ?&gt;
</pre>
<br><br>
Within the plugin folder is a CSS file that should have all the needed CSS for the above example. You may freely modify the CSS file for your own styling and format needs.
<br><br>
	</fieldset>





</div> <!-- end file-->