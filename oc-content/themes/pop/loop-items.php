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
    $i = 0;
    if ($type == 'latestItems') {
        while (osc_has_latest_items()) {?>
            <?php   pop_draw_item($class); ?>
            <?php $i++; 
        }
    } elseif ($type == 'premiums') {
        while (osc_has_premiums()) {?>
            <?php   pop_draw_item($class,TRUE,FALSE); ?>
            <?php $i++; 
            if ($i == 3) { // preferencia cuantos listings destacados ?
                break;
            }
        }
    } else {
        while (osc_has_items()) {
            $admin = false;
            if (View::newInstance()->_exists("listAdmin")) {
                $admin = true;
            }?>
            <?php   pop_draw_item('', $admin); ?>
            <?php $i++;
        }
    }
    ?>

