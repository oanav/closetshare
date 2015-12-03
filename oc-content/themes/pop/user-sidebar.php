<div class="col-sm-4 col-md-3">

   <div id="sidebar">
        <div class="user-card">
             <?php 
        $fbUser = OSCFacebook::newInstance()->getFBUser(osc_logged_user_id());
        if($fbUser) {
            $user_picture_url = "https://graph.facebook.com/". $fbUser . "/picture";
        } else {
            $user_picture_url =  osc_current_web_theme_url('images/user_default.gif');
        }
        ?>
        <div class="user-avatar">
            <img  src="<?php echo $user_picture_url ?>" width="50" height="50" />
         </div>
            <div >
                <span class="name"><?php echo osc_logged_user_name(); ?></span>
                <a href="<?php echo osc_user_public_profile_url(osc_logged_user_id())?>"><?php _e('Public profile', 'pop')?></a>
            </div>
        </div>
       <div class="user-menu box">
    <?php echo osc_private_user_menu( get_user_menu() ); ?>
           </div>
</div>
</div>
<div id="dialog-delete-account" title="<?php echo osc_esc_html(__('Delete account', 'pop')); ?>">
<?php _e('Are you sure you want to delete your account?', 'pop'); ?>
</div>
<script>
    $("#dialog-delete-account").dialog({
        autoOpen: false,
        modal: true,
        width: 350
    });
</script>
