<?php

$debug = false;

require("include/config.inc.php");
require("include/classes/db/db.php");

date_default_timezone_set("Europe/Amsterdam");

if($debug == true) { syslog(LOG_INFO, 'togglestate.php Connection received from ' . $_SERVER['REMOTE_ADDR']); }

if(isset($_GET['token']) || isset($_GET['user']) || isset($_GET['state'])) {

	if($debug == true) { syslog(LOG_INFO, 'togglestate.php Everything set for ' . $_SERVER['REMOTE_ADDR']); }

	$token		=	$_GET['token'];
	$user		=	$_GET['user'];
	$state		=	$_GET['state'];
	$ip		=	$_SERVER['REMOTE_ADDR'];

	$currentstate = getState();

	if($currentstate[0]->state === $state) {
		echo "ALLREADY TOGGLED TO THIS STATE";
		if($debug == true) { syslog(LOG_INFO, 'togglestate.php Allready toggled to ' . $state . ' for client : ' .$_SERVER['REMOTE_ADDR']); }
	} else {
		$toggler = findToggler($token);

		if($toggler[0]->ip == $ip) {
		
			switch($state) {
				case "open":
					setState($user,$toggler[0]->method,"open");
					echo "SUCCESS";
					if($debug == true) { syslog(LOG_INFO, 'togglestate.php Space is now open ' . $_SERVER['REMOTE_ADDR']); }
					break;
				case "closed":
					setState($user,$toggler[0]->method,"closed");
					echo "SUCCESS";
					if($debug == true) { syslog(LOG_INFO, 'togglestate.php Space is now closed ' . $_SERVER['REMOTE_ADDR']); }
					break;
				default:
					header('Location: https://www.pixelbar.nl/');
					break;
			}
		} else {
			header('Location: https://www.pixelbar.nl/');
			if($debug == true) { syslog(LOG_INFO, 'togglestate.php Invalid Toggle from ' . $_SERVER['REMOTE_ADDR']); }
		}
	}
} else {
	header('Location: https://www.pixelbar.nl/');
	if($debug == true) { syslog(LOG_INFO, 'togglestate.php Not all variables set from ' . $_SERVER['REMOTE_ADDR']); }
}

function getState() {
	$db = DB::get();

	$state = $db->query("SELECT state FROM state ORDER BY id DESC LIMIT 1");

	return $state;
}

function findToggler($token) {
	$db = DB::get();

	$toggler = $db->query("SELECT * FROM tokens WHERE token = '$token'");
	return $toggler;
}

function setState($user,$method,$state) {
	$db = DB::get();

	$insert = array(
		"state"		=> $state,
		"user"		=> $user,
		"method"	=> $method,
	);

	$db->insert("state", $insert);
}
?>
