<?php include( "header.php" ); ?>
  <div id="darkSide">
  <script src="validate.js"></script>
    <form action="admin.php?action=login" method="post" onclick="return checkForm(this);">
      <input type="hidden" name="login" value="true" />
<?php if ( isset( $results['errorMessage'] ) ) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>
    <dl>
      <dt><label for="username"><?php echo $globals['USERNAME'] ?>:</label></dt>
        <dd><input type="text" name="username" id="username" placeholder="Admin username" maxlength="20" /></dd>
      <dt><label for="password"><?php echo $globals['PASSWORD'] ?>:</label></dt>
        <dd><input type="text" name="password" id="password" plcaeholder="Admin password" maxlenght="20" /></dd>
    </dl>
  <div>
      <input class="button" type="submit" name="login" value="<?php echo $globals['LOGIN'] ?>" />
  </div>
    </form>
    <a href="admin.php?action=register"><?php echo $globals['REGISTRATION'] ?></a>
  </div>
<?php include( "footer.php"); ?>