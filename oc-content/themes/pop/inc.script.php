<?php
$params = Params::getParamsAsArray();

if(isset($params['action'])) {
    $params['_action'] = isset($params['action']) ? $params['action'] : '';
}
$params['_page'] = isset($params['page']) ? $params['page'] : '';
unset($params['action']);
unset($params['page']);

foreach($params as $k => $v) {
    if(is_array($v)) {
        foreach($v as $_k => $_v) {
            $url_params[] = $k.sprintf('[%s]=%s', $_k, $_v);
        }
    } else {
        $url_params[] = sprintf('%s=%s', $k, $v);
    }
}
$sParams = '&'.implode('&', $url_params);
?>

<script>
var total_pages = <?php echo (osc_search_total_pages()!='') ? osc_search_total_pages() : 0; ?>;
    var scroll_iPage = 2;

$(document).ready(function() {

    $('#content_loadin').scrollPagination({
        url     : '<?php echo osc_ajax_hook_url('load_more_listing' ). $sParams; ?>',
        nop     : 8, // The number of posts per scroll to be loaded
        iPage  : scroll_iPage, 
        total_pages: total_pages,
        error   : '<span>No More Content to Load</span>', // When the user reaches the end this is the message that is
                                    // displayed. You can change this if you want.
        delay   : 3000, // When you scroll down the posts will load after a delayed amount of time.
                       // This is mainly for usability concerns. You can alter this as you see fit
        scroll  : true // The main bit, if set to false posts will not load as the user scrolls. 
                       // but will still load if the user clicks.
        
    });
    
});

    
    $('#js-load-more-listings').click(function () {
        var url = '<?php echo osc_ajax_hook_url('load_more_listing' ). $sParams; ?>&iPage=' + scroll_iPage;
        var jqxhr = $.ajax({
            type: "POST",
            url: url,
            dataType: 'html',
            beforeSend: function( xhr ) {
                $('#js-load-more-listings').hide();
                $('#js-load-more-listings-loading').show();
            },
            statusCode: {
                404: function() {
                  $('#js-load-more-listings').hide();
                  $('#js-load-more-listings-loading').hide();

                }
              },
            success: function (data) {
                var html = $.parseHTML(data);
              //  $("#results").append( html );
                if(scroll_iPage==total_pages) {
                    $('.wrapper-more-listings').hide();
                } else {
                    scroll_iPage++;
                }
    var grid = document.querySelector('#grid');
    salvattore.appendElements(grid, html);
               //masonry.append( html ).masonry( 'appended', html )
                //setTimeout(function(){ masonry.masonry(); }, 500);
            }
        });
        jqxhr.always(function () {
            $('#js-load-more-listings').show();
            $('#js-load-more-listings-loading').hide();
            //setTimeout(function(){ masonry.masonry(); }, 500);
        });
        return false;
    });
</script>
