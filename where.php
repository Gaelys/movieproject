<?php
$title ='validation de vos places';

include 'INC/head.php';
unset ($_SESSION['movie']);

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
    
    $counts = array_count_values($ticket);
    

    try {
        $pdo = linkToDb();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();

        $verifySeatAvai = verifySeatAvai($session);
        $seatAvai = $verifySeatAvai['seatAvai'];
        if ($quantity > $seatAvai ) {
            $_SESSION['message'] = "Ce nombre de place ne'est plus disponible.";
            ('Location: detailmovie.php?identifiant=$idmovie');
            die;
        } else {
            $seatAfterCart = $seatAvai - $quantity;
            $query = "UPDATE movie_session set seatAvai = :seatNow WHERE idmovie_session = :idmovie_session ";
            $statement = $pdo->prepare($query);
            $statement ->bindValue(':seatNow', $seatAfterCart, \PDO::PARAM_INT);
            $statement ->bindValue(':idmovie_session', $session, \PDO::PARAM_INT);
            $statement ->execute();
        }
        //$insertStatement = $pdo->prepare("INSERT INTO cart (iduser, idmovie, quantity, idmovie_session, idprice, infos) VALUES (:iduser, :idmovie, :quantity, :idmovie_session, :price, :infos)");
        foreach ($counts as $price => $happen) {

            $getMoviePrice = getMoviePrice($price);
            $getListMovieInPrice =getListMovieInPrice($idmovie, $price, $iduser);
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

header ('Location: cart.php');
exit();
include 'INC/foot.php';