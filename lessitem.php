<?php
$title= 'retire un item du panier';
include 'INC/head.php';

if (!empty($_GET)) {
    if (isset($_GET['idp'])) {
        $idproduct = $_GET['idp'];
        $iduser = $_SESSION['iduser'];
        $item = minusCart($iduser, $idproduct);
        var_dump($item);
        $quantity = $item['quantity'] - 1;
        echo $quantity;
        if ($item['quantity'] > 1) {
            $insertInCart =  minusInsertInC($iduser, $quantity, $idproduct);
        } else {
            $deleteFromC = deleteFromC($iduser, $idproduct);
        }
    }
}
header ('Location: cart.php');
die;
include 'INC/foot.php';