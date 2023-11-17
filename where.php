<?php
$title ='validation de vos places';

include 'INC/head.php';
unset ($_SESSION['movie']);
var_dump($_POST);
if (!empty($_POST)) {
    $iduser = $_SESSION['iduser'];
    $quantity = $_POST['quantity'];
    $session = $_POST['idmovie_session'];
    $idmovie = $_POST['idmovie'];
    $ticket= array( );
    for ($i = 1; $i <= $quantity; $i++) {
        // Assurez-vous de vérifier si la clé $_POST existe avant de l'ajouter à $ticket
        $post_key = 'price' . $i;
        if (isset($_POST[$post_key])) {
            $ticket[] = $_POST[$post_key];
        }
    }
    var_dump($ticket);
    $counts = array_count_values($ticket);
    var_dump($counts);

    try {
        $pdo = linkToDb();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        //$insertStatement = $pdo->prepare("INSERT INTO cart (iduser, idmovie, quantity, idmovie_session, idprice, infos) VALUES (:iduser, :idmovie, :quantity, :idmovie_session, :price, :infos)");
        foreach ($counts as $price => $happen) {

            $getMoviePrice = getMoviePrice($price);
            $getListMovieInPrice =getListMovieInPrice($idmovie, $price);
            if (!empty($getListMovieInPrice)) {
                $total = $getListMovieInPrice['quantity'] + $happen;
                $query = "UPDATE cart set quantity = :quantity WHERE idmovie = :idmovie AND idprice = :idprice ";
                $statement = $pdo->prepare($query);
                $statement ->bindValue(':quantity', $total, \PDO::PARAM_INT);
                $statement ->bindValue(':idmovie', $idmovie, \PDO::PARAM_INT);
                $statement ->bindValue(':idprice', $price, \PDO::PARAM_INT);
                $statement ->execute();
            }else {
                $infos = $getMoviePrice['infos'];
                $insertStatement = $pdo->prepare("INSERT INTO cart (iduser, idmovie, quantity, idmovie_session, idprice, infos) VALUES (:iduser, :idmovie, :quantity, :idmovie_session, :price, :infos)");
                $insertStatement->bindParam(':iduser', $iduser); 
                $insertStatement->bindParam(':idmovie', $idmovie);
                $insertStatement->bindParam(':idmovie_session', $session);
                $insertStatement->bindParam(':price', $price);
                $insertStatement->bindParam(':quantity', $happen);
                $insertStatement->bindParam(':infos', $infos);
                
                $insertStatement->execute();
            }
        }
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Failed: " . $e->getMessage();
        die;
    }
}
var_dump($_SESSION);
header ('Location : cart.php');
exit();
include 'INC/foot.php';