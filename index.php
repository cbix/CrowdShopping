<?php
require_once("lib/base.php");
$tpl = new HTML_Template_IT("./tpl");
$tpl->loadTemplatefile("index.html", true, true);
	$tpl->setCurrentBlock("content");
		$tpl -> loadTemplateFile("latest_questions.html");
		$questions = Question::getLatestQuestions();
		foreach($questions as $question)
		{
			$tpl->setCurrentBlock('latest_question');
				$tpl->setVariable("TITLE", $question->getTitle());
				$tpl->setVariable("TEXT", $question->getDescription());
			$tpl->parseCurrentBlock("latest_question");
		}
		$tpl->parse();
		$tpl->show();
	$tpl->loadTemplateFile("index.html");
	$tpl->setCurrentBlock("content");
	$tpl->parseCurrentBlock("content");
		$bestUsers = User::getFourBestUser();
		foreach($bestUsers as $user)
		{
			$tpl->setCurrentBlock("best_users");
				$tpl->setVariable("USERNAME", $user->getName());
				$tpl->setVariable("GRADE", $user->getRank());
			$tpl->parseCurrentBlock("best_users");
		}	

$tpl->show();
?>
