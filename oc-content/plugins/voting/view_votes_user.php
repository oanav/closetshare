<?php
    if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');
           $_userId = null;
           if( isset($vote['userId']) ) {
               $_userId = $vote['userId'];
           } else if(Params::getParam('userId')!=''){
               $_userId = Params::getParam('userId');
           }
           if($_userId==null) {
               exit;
           }
           $path = osc_base_url().'/oc-content/plugins/'.  osc_plugin_folder(__FILE__);
?>
<div class="votes_stars">
    <?php if( $vote['can_vote'] ) { ?>
    <div class="votes_vote">
        <div class="votes_star">
            <span id="">
                <a href="#" rel="nofollow"  class="aPvu vote1"></a>
                <a href="#" rel="nofollow"  class="aPvu vote2"></a>
                <a href="#" rel="nofollow"  class="aPvu vote3"></a>
                <a href="#" rel="nofollow"  class="aPvu vote4"></a>
                <a href="#" rel="nofollow"  class="aPvu vote5"></a>
            </span>
        </div>
        <img style="position: inherit;width: inherit;border: none;" width="1" height="19" alt="" src="<?php echo $path; ?>/img/ico_separator.gif">
    </div>
    <?php } ?>
    <div class="votes_results">
        <?php
            $avg_vote = $vote['vote'];
            if($avg_vote==5) {
                $tooltip  = __('Essential', 'voting');
            } else if($avg_vote>=4 && $avg_vote<5) {
                $tooltip = __('Very interesting', 'voting');
            } else if($avg_vote>=3 && $avg_vote<4) {
                $tooltip = __('Interesting', 'voting');
            } else if($avg_vote>=2 && $avg_vote<3) {
                $tooltip = __('Uninteresting', 'voting');
            } else if($avg_vote>=1 && $avg_vote<2) {
                $tooltip = __('Without interest', 'voting');
            } else {
                $tooltip = __('Without information', 'voting');
            }
        ?>
        <img title="<?php echo $tooltip; ?>" src="<?php voting_star(1, $avg_vote); ?>">
        <img title="<?php echo $tooltip; ?>" src="<?php voting_star(2, $avg_vote); ?>">
        <img title="<?php echo $tooltip; ?>" src="<?php voting_star(3, $avg_vote); ?>">
        <img title="<?php echo $tooltip; ?>" src="<?php voting_star(4, $avg_vote); ?>">
        <img title="<?php echo $tooltip; ?>" src="<?php voting_star(5, $avg_vote); ?>">
        <span style="float:left; padding-right: 4px; padding-left: 4px;font-size: .85em">
            <?php echo $vote['total'];?> <?php _e('votes', 'voting');?></span>
    </div>
</div>