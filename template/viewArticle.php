<?php include "header.php" ?>
  <div id="lightSide">
<?php if (isset( $_SESSION['username'] ) ) { ?>
	  <div class="adminHeader">
	    <p><?php echo $GLOBALS['YOU_ARE_LOGGED'] ?> <b><a href="admin.php?action=editUser&amp;userId=<?php echo htmlspecialchars( $_SESSION['id'] ) ?>"><?php echo htmlspecialchars( $_SESSION['username'] ) ?></a></b>. <a href="admin.php?action=logout"><?php echo $GLOBALS['LOGOUT'] ?></a></p>
	    <p id="avatar"><img src="<?php echo $_SESSION['image'] ?>" alt="Avatar" height="100" width="100" /></p>
	  </div>
<?php } ?>
  <div class="content"><?php echo $results['article']->content?></div>
    <h2 id="pubDate">Published on <?php echo date('j F Y', $results['article']->pubDate)?></h2>
    <p><a href="./?action=archive"><?php echo $GLOBALS['ARCHIVE'] ?></a></p>
  </div>
<?php include "footer.php" ?>
