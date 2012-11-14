<?php
require_once("lib/base.php");
/*$tpl = new HTML_Template_IT("./tpl");
$tpl->loadTemplatefile("register.html");
$tpl->show();
print_r($tpl);*/
if($_POST['name']) {
	try {
		$user = new User();
		$user->register(array(
			'name' => $_POST['name'],
			'email' => $_POST['email'],
			'password' => $_POST['password']
		));
		include("tpl/index.html");
	} catch(Exception $e) {
		die("could not create user: " . $e->getMessage());
	}
} else {
	include("tpl/register.html");
}
