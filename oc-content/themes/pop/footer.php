</div><!-- main -->
</div>

<div class="back-to-top md-icon" title="<?php _e('Back to top','pop')?>">keyboard_arrow_up</div>

<div class="clear"></div>
<div id="footer">
    <div class="footer-wrapper container">
        <div class="row">
            <ul class="col-sm-3 col-md-3">
                <?php if( osc_users_enabled() ) { ?>
                <?php if( osc_is_web_user_logged_in() ) { ?>
                <li><a href="<?php echo osc_user_dashboard_url(); ?>">
                    <?php _e('My account', 'pop'); ?>
                </a>
                </li>
                <li>
                    <a href="<?php echo osc_user_logout_url(); ?>">
                        <?php _e('Log out', 'pop'); ?>
                    </a>
                </li>
                <?php } else { ?>
                <li><a href="<?php echo osc_user_login_url(); ?>">
                    <?php _e('Log in', 'pop'); ?>
                </a>
                </li>
                <?php if(osc_user_registration_enabled()) { ?>
                <li><a href="<?php echo osc_register_account_url(); ?>">
                    <?php _e('Register for a free account', 'pop'); ?>
                </a>
                </li>
                <?php } ?>
                <?php } ?>
                <?php } ?>
                <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
                <li><a href="<?php echo osc_item_post_url_in_category(); ?>">
                    <?php _e("Publish your ad for free", 'pop');?>
                </a></li>
                <?php } ?>
            </ul>
            <ul class="col-sm-3 col-md-3">
                <?php
                osc_reset_static_pages();
                while (osc_has_static_pages()) {
                ?>
                <li><a href="<?php echo osc_static_page_url(); ?>"><?php echo osc_static_page_title(); ?></a></li>
                <?php
                }
                ?>
                <li><a href="<?php echo osc_contact_url(); ?>"><?php _e('Contact', 'pop'); ?></a></li>
            </ul>
            <ul class="share-links col-sm-3 col-md-3">
                <li><a href="<?php echo osc_esc_html(pop_facebook_share_url()); ?>" class="share-icon facebook-icon"></a></li>
                <li><a href="<?php echo osc_esc_html(pop_twitter_share_url()); ?>" class="share-icon twitter-icon"></a></li>
                <li><a href="<?php echo osc_esc_html(pop_gplus_share_url()); ?>" class="share-icon googleplus-icon"></a></li>
            </ul>
        </div>
    </div>


</div>
<!-- footer -->

<?php osc_run_hook('footer'); ?>
<div id="dialog-delete-item" title="<?php echo osc_esc_html(__('Delete listing', 'pop')); ?>">
    <?php _e('Are you sure you want to delete this listing?', 'pop'); ?>
</div>
<script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('salvattore.min.js')?>"></script>
<script>
    $("#dialog-delete-item").dialog({
        autoOpen: false,
        modal: true,
        width: 350
    });
</script>

<script>
    // fix bootstrap dropdown
    $('a.dropdown-toggle, .dropdown-menu a').on('touchstart', function (e) {
        e.stopPropagation();
    });

<?php if( osc_is_search_page() ) { ?>
    var masonry = $('.masonry').masonry(
            { "columnWidth": 250, "itemSelector": ".item", "gutter": 20, "stamp": ".stamp" }
    );
<?php } else { ?>
    var masonry = $('.masonry').masonry(
            { "columnWidth": 250, "itemSelector": ".item", "gutter": 20 }
    );
<?php } ?>
    // layout Masonry again after all images have loaded
    masonry.imagesLoaded(function () {
        masonry.masonry();
    });

    (function (window, document) {
        var menu = document.getElementById('menu'),
                WINDOW_CHANGE_EVENT = ('onorientationchange' in window) ? 'orientationchange' : 'resize';

        function toggleHorizontal() {
            [].forEach.call(
                    document.getElementById('menu').querySelectorAll('.custom-can-transform'),
                    function (el) {
                        el.classList.toggle('pure-menu-horizontal');
                    }
            );
        }
        ;

        function toggleMenu() {
            // set timeout so that the panel has a chance to roll up
            // before the menu switches states
            if (menu.classList.contains('open')) {
                setTimeout(toggleHorizontal, 500);
            }
            else {
                toggleHorizontal();
            }
            menu.classList.toggle('open');
            document.getElementById('toggle').classList.toggle('x');
        }
        ;

        function closeMenu() {
            if (menu.classList.contains('open')) {
                toggleMenu();
            }
        }

        document.getElementById('toggle').addEventListener('click', function (e) {
            toggleMenu();
        });



        window.addEventListener(WINDOW_CHANGE_EVENT, closeMenu);
    })(this, this.document);

</script>

<script type="text/javascript">
    var sUrl = '<?php echo osc_update_search_url(array('sPattern' => ' ')); ?>';
    var sUrl = '<?php echo osc_search_url(); ?>';
    var sQuery = '-';
    function doSearch(_class) {
        var go;
            <?php if(osc_rewrite_enabled()) { ?>
        var new_pattern_permalinks = "/pattern," + encodeURIComponent($('form.' + _class + ' input[name=sPattern]').val());
        go = sUrl + new_pattern_permalinks;
            <?php } else { ?>
        var new_pattern = "&sPattern=" + encodeURIComponent($('form.' + _class + ' input[name=sPattern]').val());
        go = sUrl + new_pattern;
            <?php } ?>
        window.location.href = go;
    }
    $('.icon-search').click(function () {
        $(this).parent('form').submit();
    });

    function confirmDel(url) {
        swal({
            title: "<?php echo __('Delete item', 'pop')?>",
        text: "<?php echo osc_esc_js(__('This action can not be undone. Are you sure you want to continue?', 'pop')); ?>",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Delete", confirmButtonColor: "#DD6B55",
        closeOnConfirm: false
    },
        function () { location.href = url; }
        );
}
</script>
</body>
</html>
