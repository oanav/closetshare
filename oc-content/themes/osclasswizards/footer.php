<?php
    /*
     *      Osclass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2014 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */
?>
</div>
</div>
<!-- content -->
<?php osc_run_hook('after-main'); ?>
</div>
<!-- footer -->
<?php osc_show_widgets('footer');?>
<footer id="footer">
    <div class="container">
        <div class="footer">

            <ul>
                <?php if( osc_users_enabled() ) { ?>
                <?php if( osc_is_web_user_logged_in() ) { ?>
                <li> <?php echo sprintf(__('Hi %s', 'osclasswizards'), osc_logged_user_name() . '!'); ?> <strong><a href="<?php echo osc_user_dashboard_url(); ?>"> |
                            <?php _e('My account', 'osclasswizards'); ?>
                        </a></strong> <a href="<?php echo osc_user_logout_url(); ?>"> |
                        <?php _e('Log out', 'osclasswizards'); ?>
                    </a> </li>
                <?php } else { ?>
                <li><a href="<?php echo osc_user_login_url(); ?>">
                        <?php _e('Log in', 'osclasswizards'); ?>
                    </a></li>
                <?php if(osc_user_registration_enabled()) { ?>
                <li> <a href="<?php echo osc_register_account_url(); ?>">
                        <?php _e('Register for a free account', 'osclasswizards'); ?>
                    </a> </li>
                <?php } ?>
                <?php } ?>
                <?php } ?>
                <?php if( osc_users_enabled() || ( !osc_users_enabled() && !osc_reg_user_post() )) { ?>
                <li> <a href="<?php echo osc_item_post_url_in_category(); ?>">
                        <?php _e("Publish your ad for free", 'osclasswizards');?>
                    </a> </li>
                <?php } ?>
                <?php
                    osc_reset_static_pages();
                    while( osc_has_static_pages() ) {
                ?>
                <li> <a href="<?php echo osc_static_page_url(); ?>"><?php echo osc_static_page_title(); ?></a> </li>
                <?php
                    }
                ?>
                <li> <a href="<?php echo osc_contact_url(); ?>">
                        <?php _e('Contact', 'osclasswizards'); ?>
                    </a> </li>
            </ul>

        </div>
    </div>
</footer>
<?php osc_run_hook('footer'); ?>
<script type="text/javascript">
       
    $(document).ready(function(){$(".toggle").click(function(){$(".links").slideToggle(500);return false;});});
    
    $(document).ready(function(){$(".language span").click(function(){$(".language ul").slideToggle(500);return false;});});
    
        $(document).ready(function(){
        var callbacks_list = $('');
        $('.checkbox input').on('ifCreated ifClicked ifChanged ifChecked ifUnchecked ifDisabled ifEnabled ifDestroyed', function(event){
          callbacks_list.prepend('');
        }).iCheck({
          checkboxClass: 'square',
          radioClass: 'circle',
          increaseArea: '20%'
        });
      });
    
    $(document).ready(function() {
        //user profile page
        $("#cityId").attr('disabled',false);
    
        //fancyselect
        $('#sCategory, #sRegion, #catId, #currency, #countryId, #as, #b_company, #regionId, #cityId').fancySelect();
    
        //item publish page
        $('#catId').fancySelect().on('change.fs', function() {
            var cat_id = $("#catId").val();
            var url = '<?php echo osc_base_url(true);?>';
            var result = '';
            if(cat_id != '') {
                if(catPriceEnabled[cat_id] == 1) {
                    $("#price").closest("div").show();
                } else {
                    $("#price").closest("div").hide();
                    $('#price').val('') ;
                }
                $.ajax({
                    type: "POST",
                    url: url,
                    data: 'page=ajax&action=runhook&hook=item_form&catId=' + cat_id,
                    dataType: 'html',
                    success: function(data){
                        $("#plugin-hook").html(data);
                    }
                });
            }
        });
    
        //user profile page
        $('#regionId').fancySelect().on('change.fs', function() {
            var pk_c_code = $(this).val();
            var url = '<?php echo osc_base_url(true);?>?page=ajax&action=cities&regionId=' + pk_c_code;
            var result = '';
            if(pk_c_code != '') {
                $("#cityId").attr('disabled',false);
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    success: function(data){
                        var length = data.length;
                        if(length > 0) {
                            result += '<option selected value="">Select a city...</option>';
                            for(key in data) {
                                result += '<option value="' + data[key].pk_i_id + '">' + data[key].s_name + '</option>';
                            }
                            $("#city").before('<select name="cityId" id="cityId" ></select>');
                            $("#city").remove();
                        } else {
                            result += '<option value="">No results</option>';
                            $("#cityId").before('<input type="text" name="city" id="city" />');
                            $("#cityId").remove();
                        }
                        $("#cityId").html(result);
                        $('#cityId').trigger('update.fs');
                    }
                });
            } else {
                    $("#cityId").attr('disabled',true);
                }
        });
    });	
</script>
</body></html>