<?php
$sQuery = osc_esc_js(__("What are you looking for?", 'pop'));
?>

<script type="text/javascript">
    var sQuery = '<?php echo $sQuery; ?>';

    $(document).ready(function () {
        if ($('form.search-404 input[name=sPattern]').val() == sQuery) {
            $('form.search-404 input[name=sPattern]').css('color', 'gray');
        }
        $('form.search-404 input[name=sPattern]').click(function () {
            if ($('form.search-404 input[name=sPattern]').val() == sQuery) {
                $('form.search-404 input[name=sPattern]').val('');
                $('form.search-404 input[name=sPattern]').css('color', '');
                $('form.search-404 input[name=sPattern]').css('background', '');
            }
        });

        $('form.search-404 input[name=sPattern]').blur(function () {
            if ($('form.search-404 input[name=sPattern]').val() == '') {
                $('form.search-404 input[name=sPattern]').val(sQuery);
                $('form.search-404 input[name=sPattern]').css('color', 'gray');
                $('form.search-404 input[name=sPattern]').css('background', '');
            }
        });
        $('.btn-search-404').click(function () {
            $(this).parent('form').submit();
        });
    });
</script>

<form action="<?php echo osc_base_url(true); ?>" method="get" class="search search-404 nocsrf" onsubmit="javascript:return doSearch('search-404');">
    <input type="hidden" name="page" value="search" />
    <fieldset class="main">
        <input type="text" name="sPattern"  id="query" value="<?php echo osc_esc_html(osc_search_pattern()); ?>" placeholder="<?php echo $sQuery; ?>" />
        <button type="submit" class="btn-search-404"><?php _e('Search', 'pop'); ?></button>
    </fieldset>
</form>