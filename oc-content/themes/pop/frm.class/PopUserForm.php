<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');
 class PopUserForm extends Form {
     static public function location_javascript($path = 'front') {
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#countryId").on("change",function() {
            var pk_c_code = $(this).val();
            <?php if($path=="admin") { ?>
                var url = '<?php echo osc_admin_base_url(true)."?page=ajax&action=regions&countryId="; ?>' + pk_c_code;
            <?php } else { ?>
                var url = '<?php echo osc_base_url(true)."?page=ajax&action=regions&countryId="; ?>' + pk_c_code;
            <?php }; ?>
            var result = '';

            if(pk_c_code != '') {

                $("#regionId").attr('disabled',false);
                $("#cityId").attr('disabled',true);
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    success: function(data){
                        var length = data.length;
                        if(length > 0) {
                            result += '<option value=""><?php _e("Select a region..."); ?></option>';
                            for(key in data) {
                                result += '<option value="' + data[key].pk_i_id + '">' + data[key].s_name + '</option>';
                            }
                            if($('#regionId').size()>0) {
                                $("#regionId").parent('.select-box').before('<input type="text" name="region" id="region" />');
                                $("#regionId").parent('.select-box').remove();
                            }
                            $("#region").before('<select name="regionId" id="regionId" ></select>');
                            $("#region").remove();

                            if($('#cityId').size()>0) {
                                $("#cityId").parent('.select-box').before('<input type="text" name="city" id="city" />');
                                $("#cityId").parent('.select-box').remove();
                            }
                            $("#city").before('<select name="cityId" id="cityId" ></select>');
                            $("#city").remove();

                        } else {
                            result += '<option value=""><?php _e('No results') ?></option>';
                            if($('#regionId').size()>0) {
                                $("#regionId").parent('.select-box').before('<input type="text" name="region" id="region" />');
                                $("#regionId").parent('.select-box').remove();
                            }
                            if($('#cityId').size()>0) {
                                $("#cityId").parent('.select-box').before('<input type="text" name="city" id="city" />');
                                $("#cityId").parent('.select-box').remove();
                            }
                        }
                        $("#regionId").html(result);
                        $("#cityId").html('<option selected value=""><?php _e("Select a city..."); ?></option>');

                        $('select:not(div.select-box>select)').each(function() {
                            selectUi($(this));
                        });
                      }
                 });
             } else {
                 // add empty select
                 $("#region").before('<select name="regionId" id="regionId" ><option value=""><?php _e("Select a region..."); ?></option></select>');
                 $("#region").remove();

                 $("#city").before('<select name="cityId" id="cityId" ><option value=""><?php _e("Select a city..."); ?></option></select>');
                 $("#city").remove();

                 if( $("#regionId").length > 0 ){
                     $("#regionId").html('<option value=""><?php _e("Select a region..."); ?></option>');
                 } else {
                     $("#region").before('<select name="regionId" id="regionId" ><option value=""><?php _e("Select a region..."); ?></option></select>');
                     $("#region").remove();
                 }
                 if( $("#cityId").length > 0 ){
                     $("#cityId").html('<option value=""><?php _e("Select a city..."); ?></option>');
                 } else {
                     $("#city").before('<select name="cityId" id="cityId" ><option value=""><?php _e("Select a city..."); ?></option></select>');
                     $("#city").remove();
                 }

                $("#regionId").attr('disabled',true);
                $("#cityId").attr('disabled',true);
                $('select:not(div.select-box>select)').each(function() {
                    selectUi($(this));
                });
             }
        });

        $("#regionId").live("change",function() {
            var pk_c_code = $(this).val();
            <?php if($path=="admin") { ?>
                var url = '<?php echo osc_admin_base_url(true)."?page=ajax&action=cities&regionId="; ?>' + pk_c_code;
            <?php } else { ?>
                var url = '<?php echo osc_base_url(true)."?page=ajax&action=cities&regionId="; ?>' + pk_c_code;
            <?php }; ?>

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

                            result += '<option selected value=""><?php _e("Select a city..."); ?></option>';
                            for(key in data) {
                                result += '<option value="' + data[key].pk_i_id + '">' + data[key].s_name + '</option>';
                            }

                            if($('#cityId').size()>0) {
                                $("#cityId").parent('.select-box').before('<input type="text" name="city" id="city" />');
                                $("#cityId").parent('.select-box').remove();
                            }

                            $("#city").before('<select name="cityId" id="cityId" ></select>');
                            $("#city").remove();
                        } else {
                            result += '<option value=""><?php _e('No results') ?></option>';
                            if($('#cityId').size()>0) {
                                $("#cityId").parent('.select-box').before('<input type="text" name="city" id="city" />');
                                $("#cityId").parent('.select-box').remove();
                            }
                        }
                        $("#cityId").html(result);
                        $('select:not(div.select-box>select)').each(function() {
                            selectUi($(this));
                        });
                    }
                 });
             } else {
                $("#cityId").attr('disabled',true);
             }
        });


        if( $("#regionId").attr('value') == "") {
            $("#cityId").attr('disabled',true);
        }

        if( $("#countryId").prop('type').match(/select-one/) ) {
            if( $("#countryId").attr('value') == "") {
                $("#regionId").attr('disabled',true);
            }
        }
    });
</script>
    <?php
        }
    }