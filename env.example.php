<?php 

if($_SERVER['SERVER_NAME'] == 'localhost')
{
	/** database config **/
	define('DBNAME', 'home_care');
	define('DBHOST', 'localhost');
	define('DBPORT', '5432');
	define('DBUSER', 'username');
	define('DBPASS', '');
	define('DBDRIVER', '');
	
	define('ROOT', 'http://localhost:9000');

} else

define('APP_NAME', "Home Care");
define('APP_DESC', "");

/** true means show errors **/
define('DEBUG', true);