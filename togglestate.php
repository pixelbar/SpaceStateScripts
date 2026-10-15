<?php

$debug = true;

require("include/config.inc.php");
require("include/classes/db/db.php");

date_default_timezone_set("Europe/Amsterdam");

if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        if($_SERVER['HTTP_X_FORWARDED_FOR'] != $_SERVER["REMOTE_ADDR"]) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
                $ip = $_SERVER["REMOTE_ADDR"];
        }
}

if($debug == true) { syslog(LOG_INFO, 'togglestate.php Connection received from ' . $ip); }

if(isset($_GET['token']) || isset($_GET['user']) || isset($_GET['state'])) {

	if($debug == true) { syslog(LOG_INFO, 'togglestate.php Everything set for ' . $ip); }

	$token		=	$_GET['token'];
	$user		=	$_GET['user'];
	$state		=	$_GET['state'];

	$currentstate = getState();

	if($currentstate[0]->state === $state) {
		echo "ALLREADY TOGGLED TO THIS STATE";
		if($debug == true) { syslog(LOG_INFO, 'togglestate.php Allready toggled to ' . $state . ' for client : ' . $ip); }
	} else {
		$toggler = findToggler($token);

		if($toggler[0]->ip == $ip) {
		
			switch($state) {
				case "open":
					setState($user,$toggler[0]->method,"open");
					echo "SUCCESS";
					if($debug == true) { syslog(LOG_INFO, 'togglestate.php Space is now open ' . $ip); }
					break;
				case "closed":
					setState($user,$toggler[0]->method,"closed");
					echo "SUCCESS";
					if($debug == true) { syslog(LOG_INFO, 'togglestate.php Space is now closed ' . $ip); }
					break;
				default:
					header('Location: https://www.pixelbar.nl/');
					break;
			}
		} else {
			header('Location: https://www.pixelbar.nl/');
			if($debug == true) { syslog(LOG_INFO, 'togglestate.php Invalid Toggle from ' . $ip); }
		}
	}
} else {
	header('Location: https://www.pixelbar.nl/');
	if($debug == true) { syslog(LOG_INFO, 'togglestate.php Not all variables set from ' . $ip); }
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
