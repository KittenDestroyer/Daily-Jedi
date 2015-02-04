<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set( "Europe/Kiev");
define( "DB_DSN", "mysql:host=localhost;dbname=work" );
define( "DB_USERNAME", "root" );
define( "DB_PASSWORD", "111" );
define( "TEMPLATE_PATH", "/var/www/html/test.com/template");
define( "CLASS_PATH", "/var/www/html/test.com/class" );
define( "SAVE_PATH", "/var/www/html/test.com/images" );
define( "HOMEPAGE_NUM_ARTICLES", 5 );
define( "ADMIN_USERNAME", "admin" );
define( "ADMIN_PASSWORD", "123" );
require( CLASS_PATH . "/Article.php" );
require( CLASS_PATH . "/User.php" );
require( CLASS_PATH . "/Database.php" );
require( CLASS_PATH . "/Image.php" );
require( CLASS_PATH . "/Language.php" );
require( CLASS_PATH . "/Comment.php");

function handleException( $exception ) {
	echo "Error: ";
	error_log( $exception->getMessage() );
}

set_exception_handler( 'handleException' );
?>