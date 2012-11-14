<?php
	class User
	{
		private $this->isLoggedIn = false;
		private $this->username = "";
		
		__construct__()
		{
			start_session();
		}
		
		public login($user, $passwd)
		{
			if
		}
		
		public logout();
		
		public isLoggedIn()
		{
			return $this->isLoggedIn;
		}
		
		public getUsername()
		{
			return $this->username;
		}
	}

?>