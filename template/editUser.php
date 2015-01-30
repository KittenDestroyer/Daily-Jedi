<?php include('header.php') ?>
  <div id="darkSide">
  <div class="adminHeader">
    <p>You are logged in as <b><a href="admin.php?action=editUser&amp;userId=<?php echo htmlspecialchars( $_SESSION['id'] ) ?>"><?php echo htmlspecialchars( $_SESSION['username'] ) ?></a></b>. <a href="admin.php?action=logout">Log out</a></p>
    <p><img src="<?php echo $results["image"]; ?>" alt="Avatar" /></p>
  </div>
    <dl>
<?php if ( $_SESSION['role_id'] == "admin" || $_GET['userId'] == $_SESSION['id'] ) { ?>
    <form enctype="multipart/form-data" action="admin.php?action=upload" method="post">
      <input type="hidden" name="id" value="<?php echo $results['user']->id ?>" />
      <input name="image" accept="image/jpeg" type="file">
      <input name="upload" value="Submit" type="submit">
    </form>
    <form action="admin.php?action=editUser" method ="post">
      <input type="hidden" name="userId" value="<?php echo $results['user']->id ?>" />
      <dt><label for="username">Username:</label></dt>
        <dd><input type="text" id="username" name="username" placeholder="Username" required autofocus maxlength="20" value="<?php echo $results['user']->username ?>" /></dd>
      <dt><label for="password">Password:</label></dt>
        <dd><input type="password" name="password" id="password" placeholder="Password" required maxlength="30" value="<?php echo $results['user']->password ?>" /></dd>
      <dt><label for="email">E-mail:</label></dt>
        <dd><input type="text" name="email" id="email" placeholder="E-mail" required maxlength="30" value="<?php echo $results['user']->email ?>" /></dd>
<?php if ( $_SESSION['role_id'] == "admin" ) { ?>
      <dt><label for="role">Role:</label></dt>
      <div class="radio">
        <dd><input  type="radio" name="role_id" value="banned">Banned<br>
            <input  type="radio" name="role_id" value="user">User<br>
            <input  type="radio" name="role_id" value="moderator">Moderator<br>
            <input  type="radio" name="role_id" value="admin">Admin<br>
        </dd>
      </div>
<?php } ?>
    </dl>
  <div>
      <input class="button" type="submit" name="saveChanges" value="Save changes" />
      <input class="button" type="submit" formnovalidate name="cancel" value="Cancel" />
  </div>
    </form>
<?php if ( $_SESSION['role_id'] == "admin" ) { ?>
    <p><a href="admin.php?action=deleteUser&amp;userId=<?php echo $results['user']->id ?>" onclick="return confirm('Delete this user?')">Delete user</a></p>
<?php } ?>
<?php } ?>
  </div>
<?php include("footer.php"); ?>