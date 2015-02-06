<?php include( "header.php" ); ?>
  <div id="darkSide">
  <script src="validate.js"></script>
    <form action="admin.php?action=register" method="post" onclick="return checkForm(this);">
      <input type="hidden" name="register" value="true" />
      <input type="hidden" name="role_id" value="user" />
<?php if ( isset( $results['errorMessage'] ) ) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>
    <dl>
      <dt><label for="username"><?php echo $globals['USERNAME'] ?>:</label></dt>
        <dd><input type="text" name="username" id="username" placeholder="Username" /></dd>
      <dt><label for="password"><?php echo $globals['PASSWORD'] ?>:</label></dt>
        <dd><input type="text" name="password" id="password" placeholder="Password" maxlenght="20" /></dd>
      <dt><label for="password2">Confirm password:</label></dt>
        <dd><input type="text" name="password2" id="password2" placeholder="Confirm password" onkeyup="checkPass(); return false;" formnovalidate /></dd>
      <span id="confirmMessage"></span>
      <dt><label for="email">E-mail:</label></dt>
        <dd><input type="text" name="email" id="email" placeholder="E-mail" maxlenght="20" /></dd>
    </dl>
  <div>
      <input class="button" type="submit" name="register" value="<?php echo $globals['REGISTER'] ?>" />
  </div>
    </form>
  </div>
<?php include( "footer.php"); ?>