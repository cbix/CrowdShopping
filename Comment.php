<?php
	class Comment
	{
		public $this->id;
		public $this->question_id;
		public $this->user;
		public $this->text;
		public $this->createTime;
		public $this->editTime;
		public $this->rank;
		
		__construct($id)
		{
			DBH::dbh->prepare("SELECT comments.*, categories.name
										FROM comments, categories
										WHERE id = :comment_id && comment.category = category.id");
			DBH::dbh->bindParam(':comment_id', $id);
										
			DBH::dbh->execute();
			$result DBH::dbh->fetchAssoc();
			
			if(!$result)
			{
				$this->__destruct__();
				header('Location: /404.php');
			}
			
			$this->id				= $result['id'];
			$this->question_id	= $result['question_id'];
			$this->text  			= $result['text'];
			$this->createTime	= $result['createTime'];
			$this->editTime 		= $result['editTime'];
			$this->user			= User::getById($result['user']);
			$this->rank			= result['rank'];
		}
		
		public getID()
		{
			return $this->id;
		}
		
		public getQuestion_id()
		{
			return $this->question_id;
		}
		
		public getUser()
		{
			return $this->user;
		}
		
		public getText()
		{
			return $this->Text;
		}
		
		public getRank()
		{
			return $this->rank;
		}
		
		public setText($text)
		{
			$this->text = $text;
			
			$sth = DBH::dbh->prepare("UPDATE comment
													SET text=:text, edit_time=:edit_time
													WHERE id==:id"
												  );
							
			$sth->bindParam('id', $this->id);
			$sth->bindParam('text', $text);
			$sth->bindParam('edit_time', $time());
		}
		
		public incRank()
		{
			$this.rank++;
			
			$sth = DBH::dbh->prepare("UPDATE answers
													SET rank=:rank
													WHERE id==:id");
							
			$sth->bindParam('id', $this->id);
			$sth->bindParam('rank', $this->rank);
			$sth->execute();
		}
		
		public decRank()
		{
			if($this.rank > 0)
			{
				$this.rank--;
				
				$sth = DBH::dbh->prepare("UPDATE answers
														SET rank=:rank
														WHERE id==:id");
								
				$sth->bindParam('id', $this->id);
				$sth->bindParam('rank', $this->rank);
				$sth->execute();
			}
		}
		
		

	}
?>