<?php
if (!isset($_SESSION['login'])) {
  header('Location: index.php');
  die;
}
session_start();
$_SESSION = array();
session_destroy();
unset($_SESSION);
if(empty($_SESSION['login'])) {
  header('Location: login.php');
  die();
}
