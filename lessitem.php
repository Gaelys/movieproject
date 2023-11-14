<?php
$title= 'retire un item du panier';
include 'INC/head.php';

if (!empty($_GET)) {
    $identifiantP = $_GET['$id'];
    $_SESSION['cart'][$identifiantP] -- ;
    if ($_SESSION['cart'][$identifiantP] === 0) {
        unset($_SESSION['cart'][$identifiantP]);
        var_dump($_SESSION['cart']);
    
    }
}
header ('Location: cart.php');
die;
include 'INC/foot.php';