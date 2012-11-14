<?php
class DBHandler {
	public static $dbh = null;
	public static function connect() {
		global $config;
		try {
			if(self::$dbh == null) {
				self::$dbh = new PDO(
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
