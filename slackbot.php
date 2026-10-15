<?php

//Define Variables
define('SLACK_TOKEN','');

include('include/classes/shooker/shooker.php');

if($_POST['token'] == SLACK_TOKEN) {

	//Initialize class with the token from Slack
	$shkr = new Shooker();

	$shkr->setupOutgoing(SLACK_TOKEN);

	//Add a trigger based on keyword "test"
	$stateTrigger = $shkr->addTrigger("!state");

	//When this trigger is hit, perform this function
	$stateTrigger->addAction(function($paramString, $user, $channel){

		$url = 'https://spacestate.pixelbar.nl/spacestate.php';
		$obj = json_decode(file_get_contents($url), true);
		return "Pixelbar is now: " . $obj['state'];

	});

	$locationTrigger = $shkr->addTrigger("!location");

	$locationTrigger->addAction(function($paramString, $user, $channel) {

		return "Pixelbar is located at :\n\nLat : 51.910111\nLon : 4.433988\n\nAddress : Vierhavensstraat 56\n3029 BG Rotterdam";
	});

	$helpTrigger = $shkr->addTrigger("!help");

	$helpTrigger->addAction(function($paramString, $user, $channel) {
		return "Currently i'm supporting : \n\n!state - Displays the current Spacestate\n!location - Displays the location of Pixelbar\n!help - Show this help\n";
	});

	$topicTrigger = $shkr->addTrigger("!topic");

	$topicTrigger->addAction(function($paramString, $user, $channel) {
		return "/topic " . $paramString;
	});


	//This function is required to listen for triggers within Slack client, make sure to call after all triggers are added
	$shkr->listen();
}

?>
