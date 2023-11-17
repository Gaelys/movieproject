<?php
$title ='trash';
include 'INC/head.php';
if (!empty($_GET)) {
    if (isset($_GET['idp'])) {
        $idproduct = $_GET['idp'];
        $iduser = $_SESSION['iduser'];
        $deleteAllFromCart =  deleteAllFromCart(':idproduct', $idproduct, $iduser);
    }
}
if (!empty($_POST)) {
    $idproduct = $_POST['idmovie'];
    $iduser = $_SESSION['iduser'];
    $idprice = $_POST['idprice'];
    $deleteMovie = deleteMovieInCartWithPrice($iduser, $idproduct, $idprice);

}

header ('Location: cart.php');
die;

include 'INC/foot.php';