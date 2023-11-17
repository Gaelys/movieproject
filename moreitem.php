<?php
$title= 'ajoutter un item au panier';
include 'INC/head.php';

if (!empty($_GET)) {
    $idproduct = $_GET['idp'];
    $iduser = $_SESSION['iduser'];
    $item = minusCart($iduser, $idproduct);
    var_dump($item);
    $quantity = $item['quantity'] + 1;
    echo $quantity;
    $insertInCart =  minusInsertInC($iduser, $quantity, $idproduct);
}
header ('Location: cart.php');
die;

include 'INC/foot.php';