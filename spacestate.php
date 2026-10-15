<?php

	require("include/config.inc.php");
	require("include/classes/db/db.php");
	require("include/classes/spacenotifier/spacenotifier.php");

	header("Content-Type: application/json");
	header("Access-Control-Allow-Origin: *");
	header("Cache-Control: no-cache");

	$db = DB::get();

	$spacenotifier = new SpaceNotifier();

	$spacestate = $spacenotifier->status($db);

	$state = array(
		"state"	=> $spacestate[0]->state,
	);

	echo json_encode($state, JSON_NUMERIC_CHECK);

?>
