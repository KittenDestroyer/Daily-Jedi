<?php
session_start();

if (isset($_GET['lang'])) {
  $lang = $_GET['lang'];

  $_SESSION['lang'] = $lang;

  setcookie( 'lang', $lang, time() + (3600 * 24 * 30) );
}
elseif (isset($_SESSION['lang'])) {
  $lang = $_SESSION['lang'];
}
elseif (isset($_COOKIE['lang'])) {
  $lang = $_COOKIE['lang'];
}
else {
  $lang = 'en';
}

switch ($lang) {
  case 'en':
  $lang_file = 'lang.en.php';
  break;

  case 'ua':
  $lang_file = 'lang.ua.php';
  break;

  default :
  $lang_file = 'lang.en.php';
}

include('lang/' . $lang_file);
?>