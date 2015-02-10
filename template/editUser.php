<?php  include('header.php')  ?>
  <div id="darkSide">
  <div class="adminHeader">
    <p><?php  echo $globals['YOU_ARE_LOGGED']  ?> <b><a href="admin.php?action=editUser&amp;userId=<?php  echo htmlspecialchars( $_SESSION['id'] )  ?>"><?php  echo htmlspecialchars( $_SESSION['username'] )  ?></a></b>. <a href="admin.php?action=logout"><?php  echo $globals['LOGOUT']  ?></a></p>
    <p id="avatar"><img src="<?php  echo $_SESSION['image']  ?>" alt="Avatar" height="100" width="100" /></p>
  </div>
<?php  if ( $_SESSION['role_id'] == "admin" || $_GET['userId'] == $_SESSION['id'] ) { ?>
    <form enctype="multipart/form-data" action="admin.php?action=upload" method="post">
      <input type="hidden" name="id" value="<?php  echo $results['user']->id  ?>" />
      <input name="image" accept="image/jpeg" type="file">
      <input name="upload" value="Submit" type="submit">
    </form>
    <form action="admin.php?action=editUser" method ="post">
    <dl>
      <input type="hidden" name="userId" value="<?php  echo $results['user']->id  ?>" />
      <dt><label for="username"><?php  echo $globals['USERNAME']  ?>:</label></dt>
        <dd><input type="text" id="username" name="username" placeholder="Username" required autofocus maxlength="20" value="<?php  echo $results['user']->username  ?>" /></dd>
      <dt><label for="password"><?php  echo $globals['PASSWORD']  ?>:</label></dt>
        <dd><input type="password" name="password" id="password" placeholder="Password" required maxlength="30" value="<?php  echo $results['user']->password  ?>" /></dd>
      <dt><label for="email">E-mail:</label></dt>
        <dd><input type="text" name="email" id="email" placeholder="E-mail" required maxlength="30" value="<?php  echo $results['user']->email  ?>" /></dd>
<?php  if ( $_SESSION['role_id'] == "admin" ) { ?>
      <dt><label for="role"><?php  echo $globals['ROLE']  ?>:</label></dt>
      <div class="radio">
        <dd><input  type="radio" name="role_id" value="banned">Banned<br>
            <input  type="radio" name="role_id" value="user">User<br>
            <input  type="radio" name="role_id" value="moderator">Moderator<br>
            <input  type="radio" name="role_id" value="admin">Admin<br>
        </dd>
      </div>
<?php  } ?>
    </dl>
  <div>
      <input class="button" type="submit" name="saveChanges" value="<?php  echo $globals['SAVECHANGES']  ?>" />
      <input class="button" type="submit" formnovalidate name="cancel" value="<?php  echo $globals['CANCEL']  ?>" />
  </div>
    </form>
<?php  if ( $_SESSION['role_id'] == "admin" ) { ?>
    <p><a href="admin.php?action=deleteUser&amp;userId=<?php  echo $results['user']->id  ?>" onclick="return confirm('Delete this user?')"><?php  echo $globals['DELETE']  ?></a></p>
<?php  } ?>
<?php  } ?>
  </div>
<?php  include("footer.php"); ?>