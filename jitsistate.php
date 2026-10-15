<?php

require("jitsiconfig.inc.php");

header('Cache-Control: no-cache, must-revalidate');
header("Content-Type: application/json; charset=UTF-8");

if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        if($_SERVER['HTTP_X_FORWARDED_FOR'] != $_SERVER["REMOTE_ADDR"]) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
                $ip = $_SERVER["REMOTE_ADDR"];
        }
}

if(in_array($ip, CONF_REMOTEIP)) {

	$return = array(
		"response" => "ok",
		"data" => $_POST
	);
	echo json_encode($return);
} else {
	$return = array(
		"response" => "not allowed",
		"data" => $ip
	);
	echo json_encode($return);
}

function sendSlack() {
        $data = "payload=" . json_encode(array(
                "username"      =>      "Pixelbar doorbell",
                "icon_emoji"    =>      ":bell:",
                "channel"       =>      "#general",
                "text"          =>      "<!here> There is someone at the door:door: !"
        ));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://hooks.slack.com/services/");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $output = curl_exec($ch);
        curl_close($ch);
}


?>
