<?php

if (Params::getParam('id') != '') {
    $id    = Params::getParam('id');

    if ( osc_is_web_user_logged_in() ) {
        //check if the item is not already in the watchlist
        $conn   = getConnection();
        $detail = $conn->osc_dbFetchResult("SELECT * FROM %st_item_watchlist WHERE fk_i_item_id = %d and fk_i_user_id = %d", DB_TABLE_PREFIX, $id, osc_logged_user_id());

        //If nothing returned then we can process
        if (!isset($detail['fk_i_item_id'])) {
            $conn = getConnection();
            $conn->osc_dbExec("INSERT INTO %st_item_watchlist (fk_i_item_id, fk_i_user_id) VALUES (%d, '%d')", DB_TABLE_PREFIX, $id, osc_logged_user_id());
            $title = __('Remove from watchlist','watchlist');
            echo '<a class="watchlist full" id="' . $id . '"><span title="' . $title . '"></span>'.
            $title  . '</a>';
        } else { // remove from watchlist
            $conn = getConnection();
            $conn->osc_dbExec("DELETE FROM %st_item_watchlist WHERE fk_i_item_id = '%d'", DB_TABLE_PREFIX, $id);
            $title =  __('Add to watchlist', 'watchlist');
            echo '<a class="watchlist empty" id="' . $id . '"><span title="' . $title . '"></span>'.
            $title . '</a>';
        }

        
    } else {
        //error user is not login in
        //echo '<a href="' . osc_user_login_url() . '">' . __('Please login', 'watchlist') . '</a>';
        
    }
}

?>