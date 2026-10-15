<?php
require("../include/config.inc.php");
require("../include/classes/db/db.php");

function getExport() {
        $db = DB::get();

        $export = $db->query("SELECT DAYNAME(timestamp), HOUR(timestamp) as Hour, COUNT(HOUR(timestamp)) as Opens, state FROM state GROUP BY DAYNAME(timestamp), HOUR(timestamp) ORDER BY DAYNAME(timestamp);");

        return $export;
}



var_dump( getExport() );
?>
