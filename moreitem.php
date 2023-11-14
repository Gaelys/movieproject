<?php
$title= 'ajoutter un item au panier';
include 'INC/head.php';

if (!empty($_GET)) {
    $identifiantP = $_GET['$id'];
    $_SESSION['cart'][$identifiantP] ++ ;
}

header ('Location: cart.php');
die;
include 'INC/foot.php';