<?php
    if(osc_is_web_user_logged_in() ) {
      $recipPMs = ModelPM::newInstance()->getRecipientMessages(osc_logged_user_id(), 1, 0, 'pm_id', 'DESC');
      $recipCount = count($recipPMs);
?>
<link rel="stylesheet" type="text/css" href="<?php echo osc_base_url() .'oc-content/plugins/osclass_pm/css/style.css'; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo osc_base_url() .'oc-content/plugins/osclass_pm/css/pmTables.css'; ?>" />
<script type="text/javascript" src="<?php echo osc_base_url() . 'oc-content/plugins/osclass_pm/js/jquery.dataTables.min.js'; ?>"></script>
<script type="text/javascript" charset="utf-8">
       $(document).ready(function() {
           $('#datatables_pm').dataTable( {
               "aaSorting": [[ 1, "desc" ]],
               "bStateSave": true,
               "sPaginationType": "full_numbers",
               "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0 ] }]
           } );
    
           $('#datatables_pm_outbox').dataTable( {
               "aaSorting": [[ 1, "desc" ]],
               "bStateSave": true,
               "sPaginationType": "full_numbers",
               "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0 ] }]
           } );
    
    
       $('#checkAll').change(function() {
       $(".delChecks").attr("checked", this.checked);
    });
    
    $(".delChecks").change(function() {
       $("#checkAll").attr("checked", $(".delChecks:checked").length == $(".delChecks").length);
    
    });
    
       } );
</script>
<script type="text/javascript" src="<?php echo osc_base_url() . 'oc-content/plugins/osclass_pm/js/jquery.ui.widget.js'; ?>"></script>
<script type="text/javascript" src="<?php echo osc_base_url() . 'oc-content/plugins/osclass_pm/js/jquery.ui.position.js'; ?>"></script>
<div class="row">
    <div id="sidebar" class="col-sm-4 col-md-3">
        <?php osclass_pm_user_menu() ?>
    </div>
    <div class="content user_account col-sm-8 col-md-9">
        <div id="main">
            <h2><?php _e('Inbox', 'osclass_pm'); ?></h2> <a href="<?php echo osc_base_url(true) . '?page=custom&file=osclass_pm/user-send.php&userId=0&mType=new';?>"><?php echo __('Send message to Admin ') . ' ' . pmAdmin(); ?></a><br /><br />
            <form action="<?php echo osc_base_url('oc-content/plugins/osclass_pm/user-proc.php') ; ?>" method="POST">
                <input type="hidden" name="page" value="custom" />
                <input type="hidden" name="file" value="osclass_pm/user-proc.php" />
                <input type="hidden" name="box" value="inbox" />
                <input type="hidden" name="option" value="delMessages" />
                <div class="dataTables_wrapper">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="datatables_pm">
                        <thead>
                        <tr>
                            <th width="4%"><input name="checkAll" id="checkAll" type="checkbox" /></th>
                            <th width="25%"><?php _e('Date','osclass_pm'); ?></th>
                            <th width="54%"><?php _e('Subject','osclass_pm'); ?></th>
                            <th><?php _e('From','osclass_pm'); ?></th>
                        </tr>
                  </thead>
                        <tbody>
                            <?php if($recipCount == 0) { ?>
                        <tr class="odd">
                            <td></td>
                            <td></td>
                            <td><?php _e('You have no messages', 'osclass_pm'); ?></td>
                            <td></td>
                        </tr>
                        <?php } else { ?>
                        <?php
                            $odd = 1;
                            foreach($recipPMs as $recipPM){
                               if($odd==1) {
                                  $odd_even = "odd";
                                  $odd = 0;
                                } else {
                                  $odd_even = "even";
                                  $odd = 1;
                                }
                                if($recipPM['recipNew'] == 1) {
                                   $styleNew = 'newPM';
                                } else {
                                   $styleNew = '';
                                }
                        ?>
                        <tr class="<?php echo $odd_even;?>">
                            <?php
                                if($recipPM['sender_id'] != 0) {
                                                             $user = User::newInstance()->findByPrimaryKey($recipPM['sender_id']);
                                                           } else{ $user['s_name'] = pmAdmin();}
                            ?>
                            <?php
                                if(strtotime(date('m/d/Y',strtotime($recipPM['message_date']))) === strtotime(date('m/d/Y'))){
                                    $messageDate = __('Today at ','osclass_pm') . osclass_pm_format_time($recipPM['message_date']);
                                } else {
                                    $messageDate = osc_format_date($recipPM['message_date']) . ', ' . osclass_pm_format_time($recipPM['message_date']);
                                }
                            ?>
                            <td class="pmCheckboxes"><input class="delChecks" type="checkbox" id="delete<?php echo $recipPM['pm_id']; ?>" name="pms[]" value="<?php echo $recipPM['pm_id']; ?>" /></td>
                            <td class="<?php echo $styleNew; ?>"><?php echo $messageDate; ?></td>
                            <td class="<?php echo $styleNew; ?>"><a class="mesLink" href="<?php echo osc_render_file_url(osc_plugin_folder(__FILE__) . 'user-messages.php&message=' . $recipPM['pm_id'] . '&box=inbox'); ?>"><?php echo $recipPM['pm_subject']; ?></a></td>
                            <td class="<?php echo $styleNew; ?>"><?php echo $user['s_name']; ?></td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                  </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2"><button class="pmDeleteButton" onclick="if (!confirm('<?php _e('Are you sure you want to delete all selected personal messages?','osclass_pm'); ?>')) return false;" type="submit"><?php _e('Remove Selected','osclass_pm'); ?></button></td>
                        </tr>
                  </tfoot>
                    </table>

                </div>
            </form>
        </div>
    </div>
</div>
<?php
     } else {
    Session::newInstance()->_setReferer(osc_user_login_url() . '&http_referer=' . osc_base_url(true) . '?page=custom&file=osclass_pm/user-inbox.php');
    // HACK TO DO A REDIRECT
?>
<script>location.href="<?php echo osc_user_login_url(); ?>"</script>
<?php } ?>
