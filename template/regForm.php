<?php include( "header.php" ); ?>
  <div id="darkSide">  
    <form action="admin.php?action=register" method="post">
      <input type="hidden" name="register" value="true" />
      <input type="hidden" name="role_id" value="4" />
<?php if ( isset( $results['errorMessage'] ) ) { ?>
  <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>
    <dl>
      <dt><label for="username">Username:</label></dt>
        <dd><input type="text" name="username" id="username" placeholder="Username" required autofocus maxlength="20" /></dd>
      <dt><label for="password">Password:</label></dt>
        <dd><input type="text" name="password" id="password" placeholder="Password" maxlenght="20" /></dd>
      <dt><label for="firstName">First Name:</label></dt>
        <dd><input type="text" name="firstName" id="firstName" placeholder="First Name" maxlenght="20" /></dd>
      <dt><label for="lastName">Last Name:</label></dt>
        <dd><input type="text" name="lastName" id="lastName" placeholder="Last Name" maxlenght="20" /></dd>
      <dt><label for="email">E-mail:</label></dt>
        <dd><input type="text" name="email" id="email" placeholder="E-mail" maxlenght="20" /></dd>
    </dl>
  <div>
      <input class="button" type="submit" name="register" value="Register" />
  </div>
    </form>
  </div>
<?php include( "footer.php"); ?>