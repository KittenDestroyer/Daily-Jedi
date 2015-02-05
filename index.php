<?php
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
	case 'comment':
	  comment();
	  break;
	case 'vote':
	  vote();
	  break;
	default:
	  homepage();
}

function archive() {
	$page = isset( $_GET['page'] ) ? $_GET['page'] : 1;
	$offset = ($page - 1) * HOMEPAGE_NUM_ARTICLES;
	$results = array();
	$language = $_SESSION['lang'];
	$data = Article::getList($language, $offset, HOMEPAGE_NUM_ARTICLES );
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
	$results['article'] = Article::getById((int) $_GET["articleId"]);
	$results['comments'] = Comment::getList((int) $_GET["articleId"]);
	$votes = Vote::allVotes((int) $_GET['articleId']);
	$userVote = Vote::userVote($_SESSION['id'], (int) $_GET['articleId']);
	global $globals;
	$results['pageTitle'] = $results['article']->title;
	require( TEMPLATE_PATH . "/viewArticle.php" );

	if ( isset( $_GET['status'] ) ) {
		if ( $_GET['status'] == "voteAdded" ) $results['statusMessage'] = "Your vote has been added.";
	}
}

function comment() {
	if (isset( $_POST['saveChanges'] ) ) {
	  $comment = new Comment();
	  $comment->storeForm($_POST);
	  $comment->insert();
	  header("Location: index.php?action=viewArticle&status=voteAdded&articleId=".$_POST['articleId']);
	} else {
		require( TEMPLATE_PATH . "/viewArticle.php" );
	}
}

function vote() {
	if (isset( $_POST['saveChanges'] ) ) {
	  $vote = new Vote();
	  $vote->storeForm($_POST);
	  $vote->insert();
	  header("Location: index.php?action=viewArticle&articleId=".$_POST['articleId']);
	} else {
		require( TEMPLATE_PATH . "/viewArticle.php" );
	}
}

function homepage() {
	$page = isset( $_GET["page"]) ? $_GET["page"] : 1;
	$offset = ($page - 1) * HOMEPAGE_NUM_ARTICLES;
	$language = $_SESSION['lang'];
	$data = Article::getList($language, $offset, HOMEPAGE_NUM_ARTICLES );
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