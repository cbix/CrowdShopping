 <?php 
	require_once "lib/Question.php";
  $question = new Question($_GET['id']);
 
  $tpl = new HTML_Template_IT("./tpl");

  $tpl->loadTemplatefile("question.html", true, true);

        $tpl->setCurrentBlock("title") ;
			$tpl->setVariable("TITLE", $question->getTitle()) ;
        $tpl->parseCurrentBlock("title") ;

		$tpl->setCurrentBlock("question");
			$tpl->setVariable("TITLE", $question->getTitle());
			//$tpl->setVariable("USER", $question->getUser()->getName());
			$tpl->setVariable("DATE", date("d.m.Y hh:mm:ss", $question->getCreateTime()));
			$tpl->setVariable("DESCRIPTION", $question->getDescription());
			
			$tags = $question->getTags();
			foreach($tags as $tag)
			{
				$tpl->setCurrentBlock("tags");
					$tpl->setVariable("TAG", $tag);
				$tpl->parse("tags");
			}
			
		$tpl->parse("question");
			
  
  // print the output
  $tpl->show();

?> 