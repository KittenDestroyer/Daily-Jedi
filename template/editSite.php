<?php include('header.php') ?>
  <div id="darkSide">
  <div class="adminHeader">
    <p><?php echo $globals['YOU_ARE_LOGGED'] ?> <b><a href="admin.php?action=editUser&amp;userId=<?php echo htmlspecialchars( $_SESSION['id'] ) ?>"><?php echo htmlspecialchars( $_SESSION['username'] ) ?></a></b>. <a href="admin.php?action=logout"><?php echo $globals['LOGOUT'] ?></a></p>
    <p id="avatar"><img src="<?php echo $_SESSION['image'] ?>" alt="Avatar" height="100" width="100" /></p>
  </div>
    <p><a href="admin.php?action=listUsers"><?php echo $globals['PADAWANS'] ?></a></p>
    <p><a href="admin.php?action=listArticles"><?php echo $globals['ARTICLES'] ?></a></p>
<?php if ( $_SESSION['role_id'] == "admin" ) { ?>
	<form action="admin.php?action=editSite" method="post">
	<dl>
<?php foreach ( $globals as $key => $value ) { ?>
	  <dt><label for="<?php echo $key ?>"><?php echo $key ?></label></dt>
	    <dd><input type="text" name="<?php echo $key ?>" value="<?php echo $value ?>" /></dd>
<?php } ?>
	</dl>
	</form>
<?php } ?>
<?php include('footer.php') ?>