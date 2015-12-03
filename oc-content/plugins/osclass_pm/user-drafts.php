<?php
$conn = getConnection();
$newPMdrafts = $conn->osc_dbFetchResults("SELECT * FROM %st_pm_drafts WHERE sender_id  = '%d' ORDER BY pm_id DESC", DB_TABLE_PREFIX, osc_logged_user_id());
$countPMdrafts = count($newPMdrafts);
?>
<div class="content user_account">
    <div id="main">
    </div>
</div>