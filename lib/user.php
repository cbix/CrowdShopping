<?php
	class User
	{
		private $isLoggedIn = false;
		private $name, $id, $email;

		/**
		 * construct a new user object
		 */
		public function __construct__()
		{
			// 
		}

		public function register($data) {
			try {
				$stmt = DB::$dbh->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
				$stmt->execute(array(
					':name' => $data['name'],
					':email' => $data['email'],
					':password' => hash('sha256', $data['password'])
				));
				$this->id = PDO::lastInsertId();
				$this->name = $data['name'];
				$this->email = $data['email'];
				$_SESSION['user']['name'] = $this->name;
				$_SESSION['user']['email'] = $this->email;
			} catch(Exception $e) {
				// put error template code here
				die("error creating new user: " . $e->getMessage());
			}
		}
		
		public function login($user, $passwd)
		{
			$stmt = DB::$dbh->prepare("SELECT * FROM users WHERE name = ?");
			$res = $stmt->execute(array($user));
		}
		
		public function logout() {
			session_write_close();
			return true;
		}
		
		public function isLoggedIn()
		{
			return $this->isLoggedIn;
		}
		
		public function getName()
		{
			return $this->name;
		}

		public function fromId($id) {
			$stmt = DB::$dbh->prepare("SELECT * FROM users WHERE id = ?");
			$stmt->execute(array($id));
			$res = $stmt->fetchAll();
			print_r($res);
		}

		public function getByName($name) {
			$stmt = DB::$dbh->prepare("SELECT * FROM users WHERE name = ?");
			$stmt->execute(array($name));
			$res = $stmt->fetchAll();
			// todo
		}

		public static function getBySession() {
			//session_start();
			$user = new User();
			if($_SESSION['user']) {
				$user->getByName($_SESSION['user']['name']);
				$user->setLoggedIn(true);
			} else {
				$user->setLoggedIn(false);
			}
		}

		public static function getById($id) {
			$user = new User();
			$user->fromId($id);
			$user->setLoggedIn(false);
			return $user;
		}

		public function setLoggedIn($loggedIn) {
			$this->isLoggedIn = (bool) $loggedIn;
		}
	}

?>
