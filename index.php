<?php
require_once("lib/base.php");
$tpl = new HTML_Template_IT("./tpl");
$tpl->loadTemplatefile("index.html", true, true);
$tpl->show();
