jQuery(document).ready(function ($) {
    $(".watchlist").click(function () {
        var id = $(this).attr("id");
        if (id) {
            var dataString = 'id=' + id;
            var parent = $(this).parent();
            var $el = $(this);
            $el.fadeOut(500);
            $.ajax({
                type: "POST",
                url: watchlist_url,
                data: dataString,
                cache: false,

                success: function (response) {
                    if (response) {
                        parent.html(response);
                        //if($el.hasClass('full')) {
                        // $el.removeClass('full');
                        // $el.addClass('empty');
                    }
                    //else if($el.hasClass('empty')) {
                    //    $el.removeClass('empty');
                    //    $el.addClass('full');
                    //}
                    $el.fadeIn(500);

                }
            });
        }
    });
});