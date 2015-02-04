<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require( "config.php" );
require( "language.php" );
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$username = ( isset( $_SESSION['username'] ) ? $_SESSION['username'] : "" );
$language = ( isset( $_SESSION['lang'] ) ? $_SESSION['lang'] : "en" );
$globals = $GLOBALS['params'];

if ( $_SESSION['role_id'] == "banned" ) {
	session_destroy();
	unset($_SESSION['username']);
	header("Location: banned.php");
}

switch ( $action ) {
	case 'archive':
	  archive();
	  break;
	case 'viewArticle':
	  viewArticle();
	  break;
	default:
	  homepage();
}

function archive() {
	$page = isset( $_GET['page'] ) ? $_GET['page'] : 1;
	$offset = ($page - 1) * HOMEPAGE_NUM_ARTICLES;
	$results = array();
	if ( $_SESSION['lang'] == "en") {
	  $data = Article::getListen($offset, HOMEPAGE_NUM_ARTICLES );
	} elseif ( $_SESSION['lang'] == "ua" ) {
	  $data = Article::getListua($offset, HOMEPAGE_NUM_ARTICLES );
	} else {
		return false;
	}
	global $globals;
	$results['article'] = $data['results'];
	$results['totalRows'] = $data['totalRows'];
	$results['pageTitle'] = $globals['TITLE_ARCHIVE'];
	require( TEMPLATE_PATH . "/archive.php" );
}

function viewArticle() {
	if ( !isset( $_GET["articleId"] ) || !$_GET["articleId"] ) {
		homepage();
		return;
	}

	$results = array();
	if ( $_SESSION['lang'] == "en") {
	  $results['article'] = Article::getByIden((int) $_GET["articleId"]);
	} elseif ( $_SESSION['lang'] == "ua" ) {
	  $results['article'] = Article::getByIdua((int) $_GET["articleId"]);
	} else {
		return false;
	}
	global $globals;
	$results['pageTitle'] = $results['article']->title;
	require( TEMPLATE_PATH . "/viewArticle.php" );
}

function homepage() {
	$page = isset( $_GET["page"]) ? $_GET["page"] : 1;
	$offset = ($page - 1) * HOMEPAGE_NUM_ARTICLES;
	if (isset($_SESSION['lang'] ) ) {
		if ( $_SESSION['lang'] == "en"  )  {
		  $data = Article::getListen($offset, HOMEPAGE_NUM_ARTICLES );
		} elseif ( $_SESSION['lang'] == "ua" ) {
		  $data = Article::getListua($offset, HOMEPAGE_NUM_ARTICLES );
		} else {
			return false;
		}
	}
	$results = array();
	global $globals;
	$results['article'] = $data['results'];
	$results['totalRows'] = $data['totalRows'];
	$results['pageTitle'] = $globals['MAIN_TITLE'];
	$totalPages = ceil( $results['totalRows'] / HOMEPAGE_NUM_ARTICLES );
	require( TEMPLATE_PATH . "/homepage.php" );
}
	
function cut($string, $length) {
	$str = substr($string, 0, $length);
	$pos = strrpos($str, ' ');
	return substr($str, 0, $pos);
}

?>