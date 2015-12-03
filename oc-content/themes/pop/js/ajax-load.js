

	(function($) {

	$.fn.scrollPagination = function(options) {
		
		var settings = { 
			url 	: '',
			nop     : 8, // The number of posts per scroll to be loaded
			iPage  : 0, // Initial offset, begins at 0 in this case
			total_pages: 1,
			error   : 'No More Content to Load', // When the user reaches the end this is the message that is
										// displayed. You can change this if you want.
			delay   : 3000, // When you scroll down the posts will load after a delayed amount of time.
						   // This is mainly for usability concerns. You can alter this as you see fit
			scroll  : true // The main bit, if set to false posts will not load as the user scrolls. 
						   // but will still load if the user clicks.
		}
		
		// Extend the options so they work with the plugin
		if(options) {
			$.extend(settings, options);
		}
		
		// For each so that we keep chainability.
		return this.each(function() {		
			
			// Some variables 
			$this = $(this);
			$settings = settings;
			var busy = false; // Checks if the scroll action is happening 
							  // so we don't run it multiple times
			
			$('.loading').hide();
			if($settings.scroll == true) $('a.load-more').hide();

 //var url = '<?php echo osc_ajax_hook_url('load_more_listing' ). $sParams; ?>&iPage=' + scroll_iPage;
    //     var jqxhr = $.ajax({
    //         type: "POST",
    //         url: url,
    //         dataType: 'html',
    //         beforeSend: function( xhr ) {
    //             $('#js-load-more-listings').hide();
    //             $('#js-load-more-listings-loading').show();
    //         },
    //         statusCode: {
    //             404: function() {
    //               $('#js-load-more-listings').hide();
    //               $('#js-load-more-listings-loading').hide();

    //             }
    //           },
    //         success: function (data) {
    //             var html = $.parseHTML(data);
    //           //  $("#results").append( html );
    //             if(scroll_iPage==total_pages) {
    //                 $('.wrapper-more-listings').hide();
    //             } else {
    //                 scroll_iPage++;
    //             }
    // var grid = document.querySelector('#grid');
    // salvattore.appendElements(grid, html);
            
    //         }
    //     });

			function getData() {
 				var url = $settings.url+"&iPage="+$settings.iPage;
				  $('a.load-more').hide();
                 $('.loading').show();
				// Post data to ajax.php
				$.post(url, {
						
				}, function(data) {
                 $('.loading').hide();
						
					// If there is no data returned, there are no more posts to be shown. Show error
					if(data == "") { 
						$this.find('.loading-bar').html($settings.error);	
					}
					else {
						if($settings.iPage < $settings.total_pages && $settings.scroll == false) $('a.load-more').show();
						
						$settings.iPage++; 
							
						var html = $.parseHTML(data);
						var grid = document.querySelector('#grid');
    					salvattore.appendElements(grid, html);
						
						// No longer busy!	
						busy = false;
					}	
						
				});
					
			}	
			
			//getData(); // Run function initially
			
			// If scrolling is enabled
			if($settings.scroll == true) {
				// .. and the user is scrolling
				$(window).scroll(function() {
					
					// Check the user is at the bottom of the element
					if($(window).scrollTop() + $(window).height() > $this.height() - 100 && !busy) {
						if($settings.iPage <= $settings.total_pages) {

						busy = true;
						
						// Run the function to fetch the data inside a delay
						// This is useful if you have content in a footer you
						// want the user to see.
						setTimeout(function() {
							
							getData();
							
						}, $settings.delay);
						}
							
					}	

				});
			}
			
			// Also content can be loaded by clicking the loading bar/
			$this.find('.loading-bar a.load-more').click(function() {
			
				if(busy == false) {
					busy = true;
					getData();
				}
			
			});
			
		});
	}

})(jQuery);


