<?php
try {
	// include config:
	require_once("config.php");
} catch(Exception $e) {
	die("config.php not found. Set up everything in the config-sample.php and rename it to config.php!");
}
// include libraries:
require_once("lib/base.php");

// bootstrap the application:
DB::connect();
