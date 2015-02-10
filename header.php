<?php $globals = $GLOBALS['params']; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="jquery.validate.js"></script>
    <script src="validate.js"></script>
    <title><?php echo htmlspecialchars( $results['pageTitle'] ); ?></title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href='http://fonts.googleapis.com/css?family=Russo+One&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&subset=latin,cyrillic' rel='stylesheet' type='text/css' />
  </head>
  <body>
  <div id="">
    <h1><?php echo htmlspecialchars( $results['pageTitle'] ); ?></h1>
    <div id="language">
    <p><a href="index.php?lang=en" alt="English"><img src="images/en.png" height="32" width="32" /></a></p>
    <p><a href="index.php?lang=ua" alt="Ukrainian"><img src="images/ua.png" height="32" width="32" /></a></p>
    </div>