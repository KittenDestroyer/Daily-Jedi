<?php include('header.php') ?>
  <div id="darkSide">
  <div class="adminHeader">
    <p><?php echo $globals['YOU_ARE_LOGGED'] ?> <b><a href="admin.php?action=editUser&amp;userId=<?php echo htmlspecialchars( $_SESSION['id'] ) ?>"><?php echo htmlspecialchars( $_SESSION['username'] ) ?></a></b>. <a href="admin.php?action=logout"><?php echo $globals['LOGOUT'] ?></a></p>
    <p id="avatar"><img src="<?php echo $_SESSION['image'] ?>" alt="Avatar" height="100" width="100" /></p>
  </div>
    <p><a href="admin.php?action=listUsers"><?php echo $globals['PADAWANS'] ?></a></p>
    <p><a href="admin.php?action=listArticles"><?php echo $globals['ARTICLES'] ?></a></p>
<?php if ( $_SESSION['role_id'] == "admin" ) { ?>
<?php echo $_SESSION['lang'] ?>
<?php foreach ( $globals as $key => $value ) { ?>
  <form action="admin.php?action=editSite" method="post">
  <input type="hidden" name="parameter" value="<?php echo $key ?>" />
  <input type="hidden" name="lang" value="<?php echo $_SESSION['lang'] ?>" />
  <dl>
	  <dt><label for="<?php echo $key ?>"><?php echo $key ?></label></dt>
	    <dd><input type="text" name="value" value="<?php echo $value ?>" /></dd>
  </dl>
  <input type="submit" name="saveChanges" value="Change" />
  </form>
<?php } ?>

<?php } ?>
<?php include('footer.php') ?>