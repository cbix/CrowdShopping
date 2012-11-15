<?php
require_once("lib/base.php");
if($_SESSION['user']) {
	header('Location: index.php');
} else {
	if($_POST['name']) {
		try {
			$user = new User();
			$user->login($_POST['name'], $_POST['password']);
			header('Location: index.php');
		} catch(Exception $e) {
			die("could not login user: " . $e->getMessage());
		}
	} else {
		include("tpl/login.html");
	}
}
