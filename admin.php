<?php
require( "config.php" );
require( "language.php" );
$action = ( isset( $_GET['action'] ) ? $_GET['action'] : "" );
$username = ( isset( $_SESSION['username'] ) ? $_SESSION['username'] : "" );
$globals = $GLOBALS['params'];
if ( $_SESSION['role_id'] == "banned" ) {
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
	$results['pageTitle'] = $globals['LOGIN_TITLE'];

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
	$results['pageTitle'] = $globals['PADAWANS'];
	$data = User::listUsers();
	$results['users'] = $data['results'];
	require(TEMPLATE_PATH . "/listUsers.php");
}
function editUser() {

	$results = array();
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
	//$results['pageTitle'] = $globals['EDIT_SITE'];
	if( isset( $_POST['saveChanges'] ) ) {
		$language = new Language();
		$language->storeForm( $_POST );
		if ( $_POST['lang'] == "en") {
		  $language->updateen();
		} elseif ( $_POST['lang'] == "ua" ) {
			$language->updateua();
		} else {
			return false;
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
		$image->insert( $user_id, $imagepath );
		header("Location: admin.php");
	} else {
		require(TEMPLATE_PATH . "/editUser.php");
	}
}

function logout() {
	
	unset($_SESSION['username']);
	header("Location: index.php");
}
 
 
function newArticle() {

	$results = array();
	$results['pageTitle'] = $globals['NEW_ARTICLE_TITLE'];
	$results['formAction'] = "newArticle";

	if ( isset( $_POST['saveChanges'] ) ) {
		
		$article = new Article;
		$article->storeFormValues( $_POST );
		if ( $_SESSION['lang'] == "en") {
		  $article->inserten();
		} elseif ( $_SESSION['lang'] == "ua" ) {
		  $article->insertua();
		} else {
			return false;
		}
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
	$results['pageTitle'] = $globals['EDIT_ARTICLE_TITLE'];
	$results['formAction'] = "editArticle";

	if ( isset( $_POST['saveChanges'] ) ) {
		if ( $_SESSION['lang'] == "en") {
			$article = Article::getByIden( (int) $_POST['articleId'] );
		} elseif ( $_SESSION['lang'] == "ua" ) {
			$article = Article::getByIdua( (int) $_POST['articleId'] );
		} else {
			return false;
		}
		$article->storeFormValues( $_POST );
		if ( $_SESSION['lang'] == "en") {
		  $article->updateen();
		} elseif ( $_SESSION['lang'] == "ua" ) {
		  $article->updateua();
		} else {
			return false;
		}
		header("Location: admin.php?status=changesSaved");
	} elseif ( isset( $_POST['cancel'] ) ) {
		header("Location: admin.php");
	} else {
		if ( $_SESSION['lang'] == "en") {
			$results['article'] = Article::getByIden( (int) $_GET['articleId'] );
		} elseif ( $_SESSION['lang'] == "ua" ) {
			$results['article'] = Article::getByIdua( (int) $_GET['articleId'] );
		} else {
			return false;
		}

		require(TEMPLATE_PATH . "/editArticle.php");
	}
}
 
 
function deleteArticle() {

	if ( $_SESSION['lang'] == "en") {
		$results['article'] = Article::getByIden( (int) $_GET['articleId'] );
	} elseif ( $_SESSION['lang'] == "ua" ) {
		$results['article'] = Article::getByIdua( (int) $_GET['articleId'] );
	} else {
		return false;
	}

	$article->delete();
	header("Location: admin.php?status=articleDeleted");
}
 
 
function listArticles() {
	$page = isset( $_GET["page"]) ? $_GET["page"] : 1;
	$offset = ($page - 1) * HOMEPAGE_NUM_ARTICLES;
	$results = array();
	if ( $_SESSION['lang'] == "en") {
	  $data = Article::getListen($offset, HOMEPAGE_NUM_ARTICLES );
	} elseif ( $_SESSION['lang'] == "ua" ) {
	  $data = Article::getListua($offset, HOMEPAGE_NUM_ARTICLES );
	} else {
		return false;
	}
	$results['articles'] = $data['results'];
	$results['totalRows'] = $data['totalRows'];
	$results['pageTitle'] = $globals['MAIN_TITLE'];
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