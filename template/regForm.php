<?php include( "header.php" ); ?>
  <div id="darkSide">  
    <form action="admin.php?action=register" method="post">
      <input type="hidden" name="register" value="true" />
      <input type="hidden" name="role_id" value="user" />
<?php if ( isset( $results['errorMessage'] ) ) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>
    <dl>
      <dt><label for="username"><?php echo USERNAME ?>:</label></dt>
        <dd><input type="text" name="username" id="username" placeholder="Username" required autofocus maxlength="20" /></dd>
      <dt><label for="password"><?php echo PASSWORD ?>:</label></dt>
        <dd><input type="text" name="password" id="password" placeholder="Password" maxlenght="20" /></dd>
      <dt><label for="email">E-mail:</label></dt>
        <dd><input type="text" name="email" id="email" placeholder="E-mail" maxlenght="20" /></dd>
    </dl>
  <div>
      <input class="button" type="submit" name="register" value="<?php echo REGISTER ?>" />
  </div>
    </form>
  </div>
<?php include( "footer.php"); ?>