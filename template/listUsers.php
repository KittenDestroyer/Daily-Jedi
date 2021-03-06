<?php include ( "header.php" ); ?>
  <div id="darkSide">
  <div class="adminHeader">
    <p>You are logged in as <b><a href="admin.php?action=editUser&amp;userId=<?php echo htmlspecialchars( $_SESSION['id'] ) ?>"><?php echo htmlspecialchars( $_SESSION['username'] ) ?></a></b>. <a href="admin.php?action=logout"?>Log out</a></p><br>
    <p id="avatar"><img src="<?php echo $_SESSION['image'] ?>" alt="Avatar" height="100" width="100" /></p>
  </div>
<?php if ( isset( $results['errorMessage'] ) ) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage']; ?></div>
<?php } ?>
<?php if ( isset( $results['statusMessage'] ) ) { ?>
  <div class="statusMessage"><?php echo $results['statusMessage']; ?></div>
<?php } ?>
  <div id="articleList">
    <dl>
      <?php foreach ( $results["users"] as $user ) { ?>
        <h2>
<?php if ( $_SESSION['role_id'] == "admin" ) { ?>
          <dt><a href="admin.php?action=editUser&amp;userId=<?php echo $user->id ?>"><?php echo $user->username ?></a></dt>
            <dd><?php echo $user->role_id ?></dd>
<?php } else { ?>
          <dt><p><?php echo $user->username ?></p></dt>
            <dd><?php echo $user->role_id ?></dd>
<?php } ?>
        </h2>
      <?php } ?>
  </div>
  <a href="admin.php?action=listUsers">View Padawans</a>
  <a href="admin.php?action=listArticles">View Articles</a>
  </div>
<?php include('footer.php'); ?>