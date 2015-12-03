<?php if (!defined('OC_ADMIN') || OC_ADMIN!==true) exit('Access is not allowed.'); ?>
<style>
    p.code {
        padding: 8px;
        background-color: #F3F3F3;
        border: 1px solid #DDD;
    }
    p.code span{
        display: block;
    }

    h2{ position:relative; }
    h2 span.anchor{ position:absolute; top:-80px;}
    a.gotop{
        font-size: 14px;
        font-style: italic;
        padding-left: 15px;
        text-decoration: underline;
        cursor:pointer;
    }
    #settings_form ul {
        list-style-type: disc;
    }
    #content-page ul li {
        padding: 4px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $('a.gotop').click(function(){
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        });
    });
</script>
<div id="settings_form" style="padding-left: 15px; padding-right: 15px;">
    <h2><?php _e('Plugin information', 'voting') ; ?></h2>
    <p>
        <?php _e('This plugin adds a rating system and allows users to vote among them the quality of the item and quality sellers', 'voting') ; ?>.
        </p>
    <p>
        <ul>
            <li><?php _e('Easy plugin configuration.', 'voting') ; ?></li>
            <li><?php _e('Vote items, can be enabled and disabled. It can be configured what kind of users can vote items, registered users only or guest too', 'voting') ; ?></li>
            <li><?php _e('Vote users, can be enabled and disabled. Only registered users can vote sellers', 'voting') ; ?></li>
            <li><?php _e('Allows to show the best rated items or users at frontend, adding some extra code at your template', 'voting') ; ?>.</li>
        </ul>
    </p>

    <hr>

    <h2><?php _e('Frequently asked questions', 'voting'); ?></h2>
    <ul>
        <li><a href="#show_best_rated"><?php _e('How can I show best rated listings or users?', 'voting') ;?></a></li>
        <li><a href="#change_place_votes"><?php _e('How can I change where votes are displayed?', 'voting') ;?></a></li>
        <li><a href="#rating_on_user_dash"><?php _e('How can I show user rating on user dashboard?', 'voting') ;?></a></li>
        <li><a href="#rating_on_user_pubprof"><?php _e('How can I show user rating on public user profile?', 'voting') ;?></a></li>
        <li><a href="#rating_templates"><?php _e('How to change the way the votes are displayed?', 'voting'); ?></a></li>
    </ul>

    <hr>


    <h2><span class="anchor" id="show_best_rated"></span><?php _e('How can I show the best rated listings or users?', 'voting') ;?><a class="gotop"><?php _e('Start of page', 'voting'); ?></a></h2>
    You can display the best rated listings or users list, wherever you want
    <p><?php _e('You can display the best rated listings or users list, wherever you want', 'voting') ; ?>.</p>
    <p><?php _e('By adding this line of code, you can show the listings or users at main web page, in the sidebar', 'voting') ; ?></p>

    <p><b><?php _e('Listings', 'voting');?></b></p>
    <p class="code">
        <?php echo htmlentities('<?php'); ?> echo_best_rated(<b>NUMBER_OF_ITEMS</b>); ?><br>
    </p>
    <p><i><?php _e('Note: replace NUMBER_OF_ITEMS with a number of items you want to list', 'voting') ; ?></i></p>
    <em><?php _e('Edit main.php (located under root theme folder)', 'voting') ; ?></em>
    <p class="code">
        <span style="padding-left: 10px;"><?php echo htmlentities('<div id="sidebar">'); ?></span>
        <span style="padding-left: 30px;"><?php echo htmlentities('<div class="navigation">'); ?></span>
        <span style="padding-left: 50px;"><?php echo htmlentities('<?php'); ?> echo_best_rated(3); ?></span>
        <span style="padding-left: 50px;">...</span>
        <span style="padding-left: 30px;"><?php echo htmlentities('</div>'); ?></span>
        <span style="padding-left: 10px;"><?php echo htmlentities('</div>'); ?></span>
    </p>

    <p><b><?php _e('Users', 'voting');?></b></p>

    <p class="code"><span><?php echo htmlentities('<?php'); ?> echo_users_best_rated(<b>NUMBER_OF_USERS</b>); ?></span></p>
    <p><i><?php _e('Note: replace NUMBER_OF_USERS with a number of users you want to list', 'voting') ; ?></i></p>
    <em><?php _e('Edit main.php (located under root theme folder)', 'voting') ; ?></em>
    <p class="code">
        <span style="padding-left: 10px;"><?php echo htmlentities('<div id="sidebar">'); ?></span>
        <span style="padding-left: 30px;"><?php echo htmlentities('<div class="navigation">'); ?></span>
        <span style="padding-left: 50px;"><?php echo htmlentities('<?php'); ?> echo_users_best_rated(3); ?></span>
        <span style="padding-left: 50px;">...</span>
        <span style="padding-left: 30px;"><?php echo htmlentities('</div>'); ?></span>
        <span style="padding-left: 10px;"><?php echo htmlentities('</div>'); ?></span>
    </p>

    <hr/>

    <h2><span class="anchor" id="change_place_votes"></span><?php _e('How can I change the place where the votes are displayed?', 'voting') ; ?><a class="gotop"><?php _e('Start of page', 'voting'); ?></a></h2>
    <p><b><?php _e('By default', 'voting');?>, <?php _e('Vote section', 'voting');?></b> <?php _e('is added below item description, however if you need to change its place, follow these steps:' ,'voting' ) ; ?></p>
    <p><b><?php _e('Items', 'voting') ; ?></b></p>

    <p><?php _e('You need to add this line at end of functions.php (located under root theme folder) :', 'voting' ) ; ?><br></p>
    <p class="code"><span><?php echo htmlentities('<?php'); ?> osc_remove_hook('item_detail', 'voting_item_detail'); ?></span></p>

    <p><?php _e('Now you can call function', 'voting'); ?> <span class="code">voting_item_detail()</span> <?php _e('directly where you want <b>into item page</b>', 'voting');?>.</p>

    <p class="code"><span><?php echo htmlentities('<?php'); ?> voting_item_detail(); ?></span></p>

    <p><b><?php _e('Users', 'voting') ; ?></b></p>

    <p><?php _e('You need to add this line at end of functions.php (located under root theme folder) :', 'voting' ) ; ?><br></p>
    <p class="code"><span><?php echo htmlentities('<?php'); ?> osc_remove_hook('item_detail', 'voting_item_detail_user'); ?></span></p>

    <p><?php _e('Now you can call function', 'voting'); ?> voting_item_detail_user() <?php _e('directly where you want <b>into item page</b>', 'voting');?>.</p>

    <p class="code"><span><?php echo htmlentities('<?php'); ?> voting_item_detail_user(); ?></span></p>

    <hr/>

    <h2><span class="anchor" id="rating_on_user_dash"></span><?php _e('How can I show user rating on user dashboard?', 'voting') ;?><a class="gotop"><?php _e('Start of page', 'voting'); ?></a></h2>
    <p><?php _e('You can show user ratings on User Dashboard by passing as argument the user id', 'voting');?> (user-dashboard.php)</p>
    <p class="code"><?php echo htmlentities('<?php'); ?> voting_item_detail_user( osc_logged_user_id() ); ?></p>

    <hr/>

    <h2><span class="anchor" id="rating_on_user_pubprof"></span><?php _e('How can I show user rating on public user profile?', 'voting') ; ?><a class="gotop"><?php _e('Start of page', 'voting'); ?></a></h2>
    <p><?php _e('You can show user ratings on User public profile by passing as argument the user id', 'voting');?> (user-public-profile.php)</p>
    <p class="code"><?php echo htmlentities('<?php'); ?> voting_item_detail_user( osc_user_id() ); ?></p>

    <hr/>

    <h2><span class="anchor" id="rating_templates"></span><?php _e('How to change the way the votes are displayed?', 'voting'); ?><a class="gotop"><?php _e('Start of page', 'voting'); ?></a></h2>

    <p><h3><?php _e('If you want to modify the templates, you can find them in the plugin folder', 'voting');?>.</h3></p>
    <p><b>view_votes.php</b> <?php _e('Template rating items', 'voting') ; ?></p>
    <p><b>view_votes_user.php</b> <?php _e('Template rating users', 'voting') ; ?></p>
    <br>
    <p><b>set_results.php</b>  <?php _e('Template best rated items', 'voting') ; ?></p>
    <p><b>set_results_user.php</b>  <?php _e('Template best rated users', 'voting') ; ?></p>

    <hr/>

</div>