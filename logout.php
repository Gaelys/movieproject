<?php
include 'INC/head.php';
$_SESSION = array();
  // Destruction de la session
session_destroy();
  // Destruction du tableau de session
unset($_SESSION);
if(empty($_SESSION['login'])) {
  // Si inexistante ou nulle, on redirige vers le formulaire de login
  header('Location: login.php');
  exit();
};
include 'INC/foot.php';
?>