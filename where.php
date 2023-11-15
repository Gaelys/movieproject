<?php
$title ='validation de vos places';
include 'INC/head.php';
unset($_SESSION['movie']);
var_dump($_POST);
if (!empty($_POST)) {
    $idmovie = $_POST['idmovie'];
    $quantity = $_POST['quantity'];
    $movie = $_POST['movie'];
    $session = $_POST['cineSession'];

    if (!isset($_SESSION['movie'])) {
        $_SESSION['movie'] = array();
    }
    if (isset($_SESSION['movie'][$idmovie])) {
        $_SESSION['movie'][$idmovie] += $quantity;
    } else {
        $_SESSION['movie'][$idmovie] = $quantity;
    }
    for ($i=0; $i<$quantity; $i++) {
        if (isset($_SESSION['movie'][$i+1 . $movie])) {
            $_SESSION['movie'][$i+1 . $movie] += $_POST['price'.$i+1];
        } else {
            $_SESSION['movie'][$i+1 . $movie] = $_POST['price'.$i+1];
        }
    if (!isset($_SESSION['movie']['session'.$idmovie.$session])) {
        $_SESSION['movie']['session'.$idmovie.$session] = $session;
    }
    }
}
var_dump($_SESSION);
header ('Location : cart.php');
exit();
include 'INC/foot.php';