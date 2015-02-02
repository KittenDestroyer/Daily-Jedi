<?php include('header.php') ?>
  <div id="darkSide">
  <div class="adminHeader">
    <p><?php echo $GLOBALS['YOU_ARE_LOGGED'] ?> <b><a href="admin.php?action=editUser&amp;userId=<?php echo htmlspecialchars( $_SESSION['id'] ) ?>"><?php echo htmlspecialchars( $_SESSION['username'] ) ?></a></b>. <a href="admin.php?action=logout"><?php echo $GLOBALS['LOGOUT'] ?></a></p>
    <p id="avatar"><img src="<?php echo $_SESSION['image'] ?>" alt="Avatar" height="100" width="100" /></p>
  </div>
<?php if ( $_SESSION['role_id'] == "admin" ) { ?>
	<form action="admin.php?action=editSite" method="post">
	<dl>
	  <dt><label for="TITLE_ARCHIVE">Title for archive:</label></dt>
	    <dd><input type="text" name="TITLE_ARCHIVE" value="$GLOBALS['TITLE_ARCHIVE']" /></dd>