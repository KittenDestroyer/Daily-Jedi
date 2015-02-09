<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require( "config.php" );
require( "language.php" );
$action = ( isset( $_GET['action'] ) ? $_GET['action'] : "" );
$username = ( isset( $_SESSION['username'] ) ? $_SESSION['username'] : "" );
$globals = $GLOBALS['params'];
if ( $_SESSION['role_id'] == "banned" ) {
	session_destroy();
	unset($_SESSION['username']);
	header("Location: banned.php");
}

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
	case 'banned':
	  banned();
	  break;
	case 'listUsers':
	  listUsers();
	  break;
	case 'editUser':
	  editUser();
	  break;
	case 'editSite':
	  editSite();
	  break;
	case 'newParameter':
	  newParameter();
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
	global $globals;
	$results['pageTitle'] = $globals['LOGIN_TITLE'];

	if ( isset( $_GET['error'] ) ) {
		if ( $_GET['error'] == "wrongPassword" ) $results['errorMessage'] = "Error: wrong password.";
	}

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
				$_SESSION['image'] = Image::getImage( $id );
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
	global $globals;
	$results['pageTitle'] = $globals['LOGIN_TITLE'];

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

function banned() {
	if( isset( $_POST['logout'] ) ) {
		unset($_SESSION['username']);
		header("Location: index.php");
	} else {
		require(TEMPLATE_PATH . "/banned.php");
	}
}

function listUsers() {
	$results = array();
	global $globals;
	$results['pageTitle'] = $globals['PADAWANS'];
	$data = User::listUsers();
	$results['users'] = $data['results'];
	require(TEMPLATE_PATH . "/listUsers.php");
}
function editUser() {

	$results = array();
	global $globals;
	$results['pageTitle'] = $globals['EDIT_USER_TITLE'];

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

function editSite() {
	$results = array();
	global $globals;
	$results['pageTitle'] = $globals['EDIT_SITE'];
	if( isset( $_POST['saveChanges'] ) ) {
		$language = new Language();
		$language->storeForm( $_POST );
		if (isset($_POST['lang'] ) ) {
			if ( $_POST['lang'] == "en") {
			  $language->updateen();
			} elseif ( $_POST['lang'] == "ua" ) {
				$language->updateua();
			} else {
				return false;
			}
		}
		header("Location: admin.php?status=changesSaved");
	} else {
		require(TEMPLATE_PATH . "/editSite.php");
	}
}

function newParameter() {
	$results = array();
	global $globals;
	$results['pageTitle'] = $globals['MAIN_TITLE'];
	if( isset( $_POST['saveChanges'] ) ) {
		$language = new Language();
		$language->storeForm( $_POST );
		if(isset($_POST['lang'])) {
			if($_POST['lang'] == "en") {
			  $language->inserten();
			} elseif($_POST['lang'] == "ua") {
				$language->insertua();
			} else {
				return false;
			}
		}
		header("Location: admin.php?status=changesSaved");
	} else {
		require(TEMPLATE_PATH . "/editSite.php");
	}
}

function upload() {
	if( isset( $_POST['upload'] ) ) {
		move_uploaded_file($_FILES["image"]["tmp_name"],"/var/www/html/test.com/images/" . $_FILES["image"]["name"]);
		$imagepath = "images/".$_FILES["image"]["name"];
		$user_id = $_POST['id'];
		$image = new Image();
		if(!$image->getImage($user_id)){
		  $image->insert($user_id, $imagepath);
		} else {
		  $image->update($user_id, $imagepath);
		}
		header("Location: admin.php");
	} else {
		require(TEMPLATE_PATH . "/editUser.php");
	}
}

function logout() {
	session_destroy();
	unset($_SESSION['username']);
	header("Location: index.php");
}
 
 
function newArticle() {

	$results = array();
	global $globals;
	$results['pageTitle'] = $globals['NEW_ARTICLE_TITLE'];
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
	global $globals;
	$results['pageTitle'] = $globals['EDIT_ARTICLE_TITLE'];
	$results['formAction'] = "editArticle";

	if ( isset( $_POST['saveChanges'] ) ) {
		$article = Article::getById( (int) $_POST['articleId'] );
		$article->storeFormValues( $_POST );
		$article->update();
		header("Location: admin.php?status=changesSaved");
	} elseif ( isset( $_POST['cancel'] ) ) {
		header("Location: admin.php");
	} else {
		$results['article'] = Article::getById((int) $_GET["articleId"]);
		require(TEMPLATE_PATH . "/editArticle.php");
	}
}
 
 
function deleteArticle() {

	$article = Article::getById((int) $_GET["articleId"]);
	$article->delete();
	header("Location: admin.php?status=articleDeleted");
}
 
 
function listArticles() {
	$page = isset( $_GET["page"]) ? $_GET["page"] : 1;
	$offset = ($page - 1) * HOMEPAGE_NUM_ARTICLES;
	$results = array();
	$language = $_SESSION['lang'];
	$data = Article::getList($offset, HOMEPAGE_NUM_ARTICLES );
	$results['articles'] = $data['results'];
	$results['totalRows'] = $data['totalRows'];
	global $globals;
	$results['pageTitle'] = $globals['MAIN_TITLE'];
	$totalPages = ceil( $results['totalRows'] / HOMEPAGE_NUM_ARTICLES );

	if ( isset( $_GET['error'] ) ) {
		if ( $_GET['error'] == "articleNotFound" ) $results['errorMessage'] = "Error: article not found";
	}

	if ( isset( $_GET['status'] ) ) {
		if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Changes have been saved.";
		if ( $_GET['status'] == "articleDeleted" ) $results['statusMessage'] = "Article deleted";
		if($_GET['status'] == "welcomeUser") $results['statusMessage'] = "Welcome " . $_SESSION['username'];
	}

	require( TEMPLATE_PATH . "/listArticles.php" );
}
 
?>