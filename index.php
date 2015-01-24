<?php

require( "config.php" );
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

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
	$results = array();
	$data = Article::getList( $page );
	$results['article'] = $data['results'];
	$results['totalRows'] = $data['totalRows'];
	$results['pageTitle'] = "Jedi archive";
	require( TEMPLATE_PATH . "/archive.php" );
}

function viewArticle() {
	if ( !isset( $_GET["articleId"] ) || !$_GET["articleId"] ) {
		homepage();
		return;
	}

	$results = array();
	$results['article'] = Article::getById((int) $_GET["articleId"]);
	$results['pageTitle'] = $results['article']->title;
	require( TEMPLATE_PATH . "/viewArticle.php" );
}

function homepage() {
	$page = isset( $_GET["page"]) ? $_GET["page"] : 1;
	$offset = ($page - 1) * HOMEPAGE_NUM_ARTICLES;
	$data = Article::getList($offset, HOMEPAGE_NUM_ARTICLES );
	$results = array();
	$results['article'] = $data['results'];
	$results['totalRows'] = $data['totalRows'];
	$results['pageTitle'] = "Daily Jedi";
	$totalPages = ceil( $results['totalRows'] / HOMEPAGE_NUM_ARTICLES );
	require( TEMPLATE_PATH . "/homepage.php" );
}
	
function cut($string, $length) {
	$str = substr($string, 0, $length);
	$pos = strrpos($str, ' ');
	return substr($str, 0, $pos);
}

?>