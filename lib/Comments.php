<?php
	class Comments
	{
		public $this->id;
		public $this->question_id;
		public $this->user;
		public $this->text;
		public $this->createTime;
		public $this->editTime;
		public $this->rank;
		
		__construct__($id)
		{
			DBH::dbh->prepare("SELECT comments.*, categories.name
										FROM comments, categories
										WHERE id == :comment_id && comment.category == category.id");
			DBH::dbh->bindParam(':comment_id', $id);
										
			DBH::dbh->execute();
			$result DBH::dbh->fetchAssoc();
			
			if(!$result)
			{
				__destruct__();
				header('Location: /404.php');
			}
			
			$this->id				= $result['id'];
			$this->question_id	= $result['question_id'];
			$this->text  			= $result['text'];
			$this->createTime	= $result['createTime'];
			$this->editTime 		= $result['editTime'];
			$this->user			= User::getUserById($result['user']);
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
			
			DBH::dbh->prepare("UPDATE answers
										SET text=:text, edit_time=:edit_time
										WHERE id==:id");
							
			DBH::dbh->bindParam('id', $this->id);
			DBH::dbh->bindParam('text', $text);
			DBH::dbh->bindParam('edit_time', $time());
		}
		
		public incRank()
		{
			$this.rank++;
			
			DBH::dbh->prepare("UPDATE answers
										SET rank=:rank
										WHERE id==:id");
							
			DBH::dbh->bindParam('id', $this->id);
			DBH::dbh->bindParam('rank', $this->rank);
		}
		
		public decRank()
		{
			if($this.rank > 0)
			{
				$this.rank--;
				
				DBH::dbh->prepare("UPDATE answers
											SET rank=:rank
											WHERE id==:id");
								
				DBH::dbh->bindParam('id', $this->id);
				DBH::dbh->bindParam('rank', $this->rank);
			}
		}
		
		

	}
?>