<?php include ( "header.php" ); ?>
  <div id="darkSide">
  <div class="adminHeader">
    <p>You are logged in as <b><a href="admin.php?action=editUser&amp;userId=<?php echo htmlspecialchars( $_SESSION['id'] ) ?>"><?php echo htmlspecialchars( $_SESSION['username'] ) ?></a></b>. <a href="admin.php?action=logout"?>Log out</a></p><br>
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
          <dt><a href="admin.php?action=editUser&amp;userId=<?php echo $user->id ?>"><?php echo $user->username ?></a></dt>
            <dd><?php echo $user->role_id ?></dd>
        </h2>
      <?php } ?>
  </div>
  <a href="admin.php?action=listUsers">View Padawans</a>
  <a href="admin.php?action=listArticles">View Articles</a>
  </div>
<?php include('footer.php'); ?>