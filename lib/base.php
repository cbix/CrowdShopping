<?php
session_start();
// include everything:
require_once("HTML/Template/IT.php");
require_once("db.php");
require_once("user.php");
try {
	// include config:
	require_once("config.php");
} catch(Exception $e) {
	die("config.php not found. Set up everything in the config-sample.php and rename it to config.php!");
}
// bootstrap the application:
DB::connect();
