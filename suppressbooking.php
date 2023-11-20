<?php
$title='suppress';
include 'INC/head.php';
if (empty($_GET) || (!is_numeric($_GET['identifiant']))) {
    header('Location: product.php');
    die;
}
$idorder_cine = $_GET['identifiant'];
$iduser = $_SESSION['iduser'];

try {
    $pdo = linkToDb();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();
    $products = getquantityFromProductOrder($idorder_cine);
    
    foreach ($products as $product){
        if (!empty($product['idmovie_session'])) {
        $quantity = $product['quantity'];
        $idmovie_session = $product['idmovie_session'];
        $verifySeat = verifySeatAvai($idmovie_session);
        $seatAvai = $verifySeat['seatAvai'];
        $seatNow = $seatAvai + $quantity;
        $resetSeat =  resetSeat($seatNow, $idmovie_session);
        }
    }
        $deleteFromOrder_cine = deleteFromOrder_cine($iduser, $idorder_cine);
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed: " . $e->getMessage();
    die;
}

header('Location: bookings.php');
die;