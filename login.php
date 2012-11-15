<?php
require_once("lib/base.php");
if($_SESSION['user']) {
	include("tpl/index.html");
} else {
	if($_POST['name']) {
		try {
			$user = new User();
			$user->login($_POST['name'], $_POST['password']);
			include("tpl/index.html");
		} catch(Exception $e) {
			die("could not login user: " . $e->getMessage());
		}
	} else {
		include("tpl/login.html");
	}
}
