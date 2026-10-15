<?php

require("doorbellconfig.inc.php");

if($_SERVER["REMOTE_ADDR"] == CONF_REMOTEIP) {

        sendSlack();

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
