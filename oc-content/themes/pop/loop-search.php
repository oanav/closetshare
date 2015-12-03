<?php
$class='';
$loopClass = '';
$type = 'items';
if (View::newInstance()->_exists('listType')) {
    $type = View::newInstance()->_get('listType');
}
if (View::newInstance()->_exists('listClass')) {
    $loopClass = View::newInstance()->_get('listClass');
}
?>


    <?php
 

    // get premium ads
    if(!osc_is_list_items() &&
        !osc_is_public_profile()
        ) {
        $max = osc_get_preference('pop_max_premium', 'pop_theme');
        osc_get_premiums($max);
        if (osc_count_premiums() > 0) {
            while (osc_has_premiums()) { ?>
            <?php   pop_draw_item($class, false, true); ?>
            <?php $i++;
               
            }
        }
    }

    $i = 0;
    if ($type == 'latestItems') {
        while (osc_has_latest_items()) {?>
            <?php   pop_draw_item($class); ?>
            <?php $i++;
        }
    } elseif ($type == 'premiums') {
        while (osc_has_premiums()) {?>
            <?php   pop_draw_item($class,FALSE,TRUE); ?>
            <?php $i++;
            if ($i == 3) { // preferencia cuantos listings destacados ?
                break;
            }
        }
    } else {
        while (osc_has_items()) {
            $i++;
            $admin = false;
            if (View::newInstance()->_exists("listAdmin")) {
                $admin = true;
            }?>
            <?php   pop_draw_item('', $admin); ?>
            <?php $i++;
        }
    }
    pop_draw_ad('search-results-300x250');
    ?>



                        


