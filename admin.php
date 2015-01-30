<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require( "config.php" );
session_start();
$action = ( isset( $_GET['action'] ) ? $_GET['action'] : "" );
$username = ( isset( $_SESSION['username'] ) ? $_SESSION['username'] : "" );

if ( $action != "login" && $action != "logout" && $action != "register" && !$username ) {
	login();
	exit;
}



switch ( $action ) {
	case 'login':
	  login();
	  break;
	case 'register':
	  register();
	  break;
	case 'listUsers':
	  listUsers();
	  break;
	case 'editUser':
	  editUser();
	  break;
	case 'upload':
	  upload();
	  break;
	case 'deleteUser':
	  deleteUser();
	  break;
	case 'logout':
	  logout();
	  break;
	case 'newArticle':
	  newArticle();
	  break;
	case 'editArticle':
	  editArticle();
	  break;
	case 'deleteArticle':
	  deleteArticle();
	  break;
	default:
	  listArticles();
}

function login() {

	$results = array();
	$results['pageTitle'] = "Join the dark side";

	if( isset( $_POST['login'] ) )
	{

			$user = new User();
			$user->storeForm( $_POST );
			if ($user->login())
			{
				$id = $user->getId( $_POST['username'] );
				$_SESSION['id'] = $id;
				$_SESSION['username'] = $user->username;
				$_SESSION['role_id'] = $user->getRole( $id );
				if ( $_SESSION['role_id'] == "admin" || $_SESSION['role_id'] == "moderator") {
					header("Location: admin.php?status=welcomeUser");
				}
				else
				{
					header("Location: index.php");
				}
				
			}
			else
			{
				header("Location: admin.php?error=wrongPassword");
				require(TEMPLATE_PATH . "/loginForm.php");
			}
	}
	else
	{
		require(TEMPLATE_PATH . "/loginForm.php");
	}
}

function register() {

	$results = array();
	$results['pageTitle'] = "Join the dark side";

	if( isset( $_POST['register'] ) )
	{
			$user = new User();
			$user->storeForm( $_POST );
			$user->insert();
			header("Location: admin.php?status=welcomeUser");
		} 
		else 
		{
			require(TEMPLATE_PATH . "/regForm.php");
		}
}

function listUsers() {
	$results = array();
	$results['pageTitle'] = "Padawans";
	$data = User::listUsers();
	$results['users'] = $data['results'];
	require(TEMPLATE_PATH . "/listUsers.php");
}
function editUser() {

	$results = array();
	$results['pageTitle'] = "Edit user";

	if ( isset( $_POST['saveChanges'] ) ) {
		if ( !$user = User::getUser( (int) $_POST['userId'] ) ) {
			header("Location: admin.php?error=userNotFound");
			return;
		}
		$user->storeForm( $_POST );
		$user->update();
		if ( $_SESSION['role_id'] == "admin" || $_SESSION['role_id'] == "moderator" ) {
		  header("Location: admin.php?action=listUsers");
		} else {
			header("Location: index.php");
		}
	} elseif ( isset( $_POST['cancel'] ) ) {
		if ( $_SESSION['role_id'] == "admin" || $_SESSION['role_id'] == "moderator" ) {
		  header("Location: admin.php?action=listUsers");
		} else {
			header("Location: index.php");
		}
	} else {
		$results['user'] = User::getUser( (int) $_GET['userId'] );
		require(TEMPLATE_PATH . "/editUser.php");
	}
}

function deleteUser() {
	if ( !$user = User::getUser( (int) $_GET['userId'] ) ) {
		header("Location: admin.php?error=userNotFound");
		return;
	}

	$user->delete();
	header("Location: admin.php?action=listUsers");
}

function logout() {
	
	unset($_SESSION['username']);
	header("Location: admin.php");
}
 
 
function newArticle() {

	$results = array();
	$results['pageTitle'] = "New article";
	$results['formAction'] = "newArticle";

	if ( isset( $_POST['saveChanges'] ) ) {
		
		$article = new Article;
		$article->storeFormValues( $_POST );
		$article->insert();
		header("Location: admin.php?status=changesSaved");
	} elseif ( isset( $_POST['cancel'] ) ) {
		header("Location: admin.php");
	} else {
		$results['article'] = new Article;
		require(TEMPLATE_PATH . "/editArticle.php");
	}
}
 
 
function editArticle() {

	$results = array();
	$results['pageTitle'] = "Edit article";
	$results['formAction'] = "editArticle";

	if ( isset( $_POST['saveChanges'] ) ) {
		if ( !$article = Article::getById( (int) $_POST['articleId'] ) ) {
			header("Location: admin.php?error=articleNotFound");
			return;
		}
		$article->storeFormValues( $_POST );
		$article->update();
		header("Location: admin.php?status=changesSaved");
	} elseif ( isset( $_POST['cancel'] ) ) {
		header("Location: admin.php");
	} else {
		$results['article'] = Article::getById( (int) $_GET['articleId'] );
		require(TEMPLATE_PATH . "/editArticle.php");
	}
}
 
 
function deleteArticle() {

	if ( !$article = Article::getById( (int) $_GET['articleId'] ) ) {
		header("Location: admin.php?error=articleNotFound");
		return;
	}

	$article->delete();
	header("Location: admin.php?status=articleDeleted");
}
 
 
function listArticles() {
	$page = isset( $_GET["page"]) ? $_GET["page"] : 1;
	$offset = ($page - 1) * HOMEPAGE_NUM_ARTICLES;
	$results = array();
	$data = Article::getList($offset, HOMEPAGE_NUM_ARTICLES);
	$results['articles'] = $data['results'];
	$results['totalRows'] = $data['totalRows'];
	$results['pageTitle'] = "Daily Jedi";
	$totalPages = ceil( $results['totalRows'] / HOMEPAGE_NUM_ARTICLES );

	if ( isset( $_GET['error'] ) ) {
		if ( $_GET['error'] == "articleNotFound" ) $results['errorMessage'] = "Error: article not found";
	}

	if ( isset( $_GET['status'] ) ) {
		if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Changes have been saved.";
		if ( $_GET['status'] == "articleDeleted" ) $results['statusMessage'] = "Article deleted";
	}

	require( TEMPLATE_PATH . "/listArticles.php" );
}
 
?>