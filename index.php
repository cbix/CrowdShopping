<?php
require_once("lib/base.php");
error_reporting(E_ERROR);
$tpl = new HTML_Template_IT("./tpl");
$tpl1 = new HTML_Template_IT("./tpl");
$tpl->loadTemplatefile("index.html", true, false);
	$tpl->touchBlock("head");
	//$tpl->show();
		$tpl1 -> loadTemplateFile("latest_questions.html");
		$questions = Question::getLatestQuestions();
		foreach($questions as $question)
		{
			$tpl1->setCurrentBlock('latest_question');
				$tpl1->setVariable("TITLE", $question->getTitle());
				$tpl1->setVariable("TEXT", $question->getDescription());
			$tpl1->parseCurrentBlock("latest_question");
		}
		$tpl1->parse();
		
	//$tpl->loadTemplateFile("index.html");
	$bestUsers = User::getFourBestUsers();
		foreach($bestUsers as $user)
		{
			$tpl->setCurrentBlock("best_users");
				$tpl->setVariable("USERNAME", $user->getName());
				$tpl->setVariable("GRADE", $user->rank());
			$tpl->parseCurrentBlock("best_users");
		}
	$tpl->touchBlock("footer");
	
$tpl->show();
$tpl1->show();
?>
