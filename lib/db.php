<?php
class DB {
	public static $dbh;
	public static function connect() {
		try {
			if($this->dbh == null) {
				$this->dbh = new PDO(
					$config['db']['dsn'],
					$config['db']['user'],
					$config['db']['pass'],
					array(
						PDO::ATTR_PERSISTENT => true
					)
				);
			}
		} catch(Exception $e) {
			die("Could not connect to database, please check your config.php!");
		}
	}
}
