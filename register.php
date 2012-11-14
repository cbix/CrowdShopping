<?php
require_once("lib/base.php");
$tpl = new HTML_Template_IT("./tpl");
$tpl->loadTemplatefile("register.html");
$tpl->show();
print_r($tpl);
