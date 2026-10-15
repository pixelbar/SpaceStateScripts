<?php
/* This is the Pixelbar SpaceNotifier
 * It is made by Roy van Dongen
 */



class SpaceNotifier {

	public $state;

	public function __construct() {
	}

	// Action when space is opened
	public function open($actions,$twitter) {
		foreach($actions as $action) {
			switch($action) {
				case "twitter":
					$this->twitter_open($twitter);
					break;
				case "power":
					$this->power("open");
					break;
			}
		}
	}

	// Action when space is closed
	public function closed($actions,$twitter) {
		foreach ($actions as $action) {
			switch($action) {
				case "twitter":
					$this->twitter_closed($twitter);
					break;
				case "power":
					$this->power("closed");
					break;
			}
		}
	}

	// The state of the space
	public function status($db) {
		$this->state = $db->query("SELECT id,state,timestamp,user,method,actiondone from state ORDER BY `id` DESC LIMIT 1");
		return $this->state;
	}

	public function toggledone($db) {
		$this->state = $db->update("state", array ("actiondone" => "1") ,"id = ?", $this->state[0]->id);
        }

	public function twitter_open($twitter) {
		$tweet = $this->fillTheVariables(TWIT_OPENMSG);

		$twitter->post("statuses/update", array("status" => $tweet));
	}

	public function twitter_closed($twitter) {
		$tweet = $this->fillTheVariables(TWIT_CLOSEMSG);

		$twitter->post("statuses/update", array("status" => $tweet));	
	}

	public function power($state) {

	}

	public function irc($state) {

	}

	public function fillTheVariables($msg) {
		$timestamp = $this->state[0]->timestamp;
		$user = $this->state[0]->user;
		$method = $this->state[0]->method;

		$msg = str_replace('{{{timestamp}}}', $timestamp, $msg);
		if($user !== $method) {
			$msg = str_replace('{{{byuser}}}', "by " . $user . " ", $msg);
		} else {
			$msg = str_replace('{{{byuser}}}', '', $msg);
		}
		$msg = str_replace('{{{method}}}', $method, $msg);

		return $msg;
	}
}

?>
