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
    $quantity = $_POST['quantity'];
    $idmovie_session = $_POST['idmovie_session'];
    $deleteMovie = deleteMovieInCartWithPrice($iduser, $idproduct, $idprice);
    $verifySeat = verifySeatAvai($idmovie_session);
    $seatAvai = $verifySeat['seatAvai'];
    $seatNow = $seatAvai + $quantity;
    $resetSeat =  resetSeat($seatNow, $idmovie_session);


}

header ('Location: cart.php');
die;

include 'INC/foot.php';