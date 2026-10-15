<?php

	require("include/config.inc.php");
	require("include/classes/db/db.php");
	require("include/classes/spacenotifier/spacenotifier.php");

	$db = DB::get();

	$spacenotifier = new SpaceNotifier();

	$spacestate = $spacenotifier->status($db);

	switch($spacestate[0]->state) {
		case "open":
			echo '<html><head></head><body style="text-align: center; background-color: white; color: #29b3e7; font-weight: bold; font-family:Monaco,fixed; font-size: 13px; margin:0px;padding:2px;"><nobr>We\'re Open</nobr></body></html>';
			break;
		case "closed":
			echo '<html><head></head><body style="text-align: center; background-color: white; color: #29b3e7; font-weight: bold; font-family:Monaco,fixed; font-size: 13px; margin:0px;padding:2px;"><nobr>We\'re Closed</nobr></body></html>';
			break;
	}

?>
