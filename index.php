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
			$tpl->parse("latest_question");
		}
		$tpl->parse();
		$tpl -> loadTemplateFile("latest_questions.html");
	$tpl->parse("content");

$tpl->show();
