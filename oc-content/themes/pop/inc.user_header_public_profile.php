<?php
$lat = -34.397;
$long = 150.644;
if(osc_user_latitude()!='')       $lat = osc_user_latitude();
if(osc_user_longitude()!='')    $long = osc_user_longitude();
?>

<script src="https://maps.googleapis.com/maps/api/js?v=3"></script>
<script type="text/javascript">
    function initialize() {
        var lat = <?php echo $lat;?>;
        var long = <?php echo $long;?>;
        var mapOptions = {
            center: new google.maps.LatLng(lat, long),
            zoom: 11,
            disableDefaultUI: true,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"),
                mapOptions);
    }

    $(document).ready(function (event) {
        initialize();
    });
</script>

<div id="map_canvas" style="width:100%; height:300px;  z-index: -1;"></div>

<div class="wrapper container-user-card">
    <div class="user-card">
             <?php 
        $fbUser = OSCFacebook::newInstance()->getFBUser(osc_item_user_id());
        if($fbUser) {
            $user_picture_url = "https://graph.facebook.com/". $fbUser . "/picture";
        } else {
            $user_picture_url =  osc_current_web_theme_url('images/seller-default.png');
        }
        ?>
            <img class="user-avatar" src="<?php echo $user_picture_url ?>" />
            <?php /* <img class="user-avatar" src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim(osc_user_email()))); ?>?s=120&d=<?php echo osc_current_web_theme_url('images/user_default.gif'); ?>" /> */ ?>
            <div class="name"><?php echo osc_highlight(osc_user_name(),120); ?></div>
            <ul id="user_data">
               
             <li class="email">
                <i class="fa fa-mail"></i>
                <a href="<?php echo osc_user_email(); ?>"><?php echo osc_user_email(); ?></a></li>

                   <?php if( osc_user_website() !== '' ) { ?>
             <li class="website">
                <i class="fa fa-globe"></i>
                <a href="<?php echo osc_user_website(); ?>"><?php echo osc_user_website(); ?></a></li>
            <?php } ?>
          
                <li class="share-links">
                        <a href="<?php echo pop_facebook_share_url(); ?>" class="share-icon facebook-icon"></a>
                        <a href="<?php echo pop_twitter_share_url(); ?>" class="share-icon twitter-icon"></a>
                        <a href="<?php echo osc_esc_html(pop_gplus_share_url()); ?>" class="share-icon googleplus-icon"></a>
                        <a href="<?php echo pop_email_share_url(); ?>" class="share-icon email-icon"></a>
                </li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>
