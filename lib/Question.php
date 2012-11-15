<?php
	require_once "lib/base.php";
	class Question
	{
		public $id;
		public $title;
		public $user;
		public $description;
		public $category;
		public $tags=array();
		public $createTime;
		
		static function getLatestQuestions()
		{
			$questions = array();
			$sth = DBH::$dbh->prepare("SELECT questions.id
													  FROM questions
													  ORDER BY questions.create_time DESC
													  LIMIT 5");
										
			$sth->execute();
			while($result = $sth->fetch(PDO::FETCH_ASSOC))
			{
				$questions[] = new Question($result['id']);
			}
			return $questions;
		}
		
		function __construct($id)
		{
			$sth = DBH::$dbh->prepare("SELECT questions.*, categories.name
													  FROM questions, categories
													  WHERE questions.id = :question_id && questions.category = categories.id");
			$sth->bindParam(':question_id', $id);
										
			$sth->execute();
			$result = $sth->fetch(PDO::FETCH_ASSOC);
			
			if(!$result)
			{
				$this->__destruct__();
				header('Location: /404.php');
			}
			
			$this->id				= $result['id'];
			$this->title				= $result['title'];
			$this->category		= $result['category'];
			$this->description  = $result['description'];
			$this->createTime	= $result['create_time'];
			$this->user			= User::getById($result['user_id']);
			
			$sth = DBH::$dbh->prepare("SELECT tags.name
													  FROM tags, question_tags
													  WHERE tags.id = question_tags.tag_id && question_tags.question_id = :question_id"
													 );
										
			$sth->bindParam(':question_id', $this->id);
			
			$sth->execute();
			
			$result = $sth->fetchAll();
			
			foreach($result as $row)
			{
				$this->tags[] = $row['name'];
			}
		}
		
		public function  getID()
		{
			return $this->id;
		}
		
		public function  getTitle()
		{
			return $this->title;
		}
		
		public function getUser()
		{
			return $this->user;
		}
		
		public function getDescription()
		{
			return $this->description;
		}
		
		public function getTags()
		{
			return $this->tags;
		}
		
		public function getCategory()
		{
			return $this->category;
		}
		
		public function getCreateTime()
		{
			return $this->createTime;
		}
		
		public function getHighRatedComments()
		{
			$highRatedComment = array();
			$sth = DBH::$dbh->prepare("SELECT 
													  FROM comment.id
													  WHERE comment.question_id = :question_id
													 ORDER BY comment,rank DESC
													 LIMIT 3
													");
										
			$sth->bindParam(':question_id', $this->id);
			
			$sth->execute();
			
			while($result = $sth->fetch(PDO::FETCH_ASSOC))
			{
				$highRatedComment[] = new Comment($result['id']);
			}
			
			return $highRatedComment;
		}
		
		public function getComments()
		{
			$comments = array();
			$sth = DBH::$dbh->prepare("SELECT 
													  FROM comment.id
													  WHERE comment.question_id = :question_id
													  ORDER BY comment.createTime ASC
													");
										
			$sth->bindParam(':question_id', $this->id);
			
			$sth->execute();
			
			while($result = $sth->fetch(PDO::FETCH_ASSOC))
			{
				$comments[] = new Comment($result['id']);
			}
			
			return $comments;
		}
	}
?>