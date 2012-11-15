<?php
	require_once "/lib/base.php";
	class Question
	{
		public $id;
		public $title;
		public $user;
		public $description;
		public $category;
		public $tags=array();
		public $createTime;
		public $modifyTime;
		public $answers;
		
		function __construct__($id)
		{
			DBH::$dbh->prepare("SELECT questions.*, categories.name
										FROM questions, categories
										WHERE id == :question_id && question.category == category.id");
			DBH::$dbh->bindParam(':question_id', $id);
										
			DBH::$dbh->execute();
			$result = DBH::$dbh->fetchAssoc();
			
			if(!$result)
			{
				__destruct__();
				header('Location: /404.php');
			}
			
			$this->id				= $result['id'];
			$this->title				= $result['title'];
			$this->category		= $result['category'];
			$this->description  = $result['description'];
			$this->createTime	= $result['createTime'];
			$this->editTime 		= $result['editTime'];
			$this->user			= User::getUserById($result['user']);
			
			DBH::$dbh->prepare("SELECT tags.name
										FROM tags
										WHERE tags.id == question_tags.tag_id && question_tags.question_id == :question_id");
										
			DBH::$dbh->bindParam(':question_id', $this->id);
			
			DBH::$dbh->execute();
			
			$result = DBH::$dbh->fetchAll();
			
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
	}
?>