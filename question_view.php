 <?php 
  require_once "lib/Question.php";
  $question = new Question($_GET['id']);
 print_r($question);
  $tpl = new HTML_Template_IT("./tpl");

  $tpl->loadTemplatefile("question.html", true, true);

        $tpl->setCurrentBlock("title") ;
			$tpl->setVariable("TITLE", $question->getTitle()) ;
        $tpl->parseCurrentBlock("title") ;

		$tpl->setCurrentBlock("question");
			$tpl->setVariable("TITLE", $question->getTitle());
			$tpl->setVariable("USER", $question->getUser()->getName());
			$tpl->setVariable("DATE", date("d.m.Y h:m:s", $question->getCreateTime()));
			$tpl->setVariable("DESCRIPTION", $question->getDescription());
			
			$tags = $question->getTags();
			foreach($tags as $tag)
			{
				$tpl->setCurrentBlock("tags");
					$tpl->setVariable("TAG", $tag);
				$tpl->parse("tags");
			}
			
		$tpl->parse("question");
		
		$highRatedComments = $question->getHighRatedComments();
		
		foreach($highRatedComments as $comment)
		{
			$tpl->setCurrentBlock("highest-rated");
				$tpl->setVariable("RANKING", $comment->getRank());
				$tpl->setVariable("NAME", $comment->getUser()->getName());
				$tpl->setVariable("TEXT", $comment->getText());
			$tpl->parse("highest-rated");
		}
		
		$comments = $question->getComments();
		
		foreach($comments as $comment)
		{
			$tpl->setCurrentBlock("highest-rated");
				$tpl->setVariable("RANKING", $comment->getRank());
				$tpl->setVariable("NAME", $comment->getUser()->getName());
				$tpl->setVariable("TEXT", $comment->getText());
			$tpl->parse("highest-rated");
		}
  
  // print the output
  $tpl->show();

?> 