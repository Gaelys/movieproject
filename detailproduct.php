<?php
$title ='votre gourmandise';
include 'INC/head.php';

$idproduct = $_GET['identifiant'];
$product = getProductInfo($idproduct);
if (!empty($_POST)) { 
    $iduser = $_SESSION['iduser'];
    $quantity = $_POST['quantity'];
    $price = $product[0]['price'];
    $infos = $product[0]['allergies'];
    try {
        $pdo = linkToDb();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();

        $cart = getPCart($_SESSION['iduser'], $idproduct);
        var_dump($cart);
        if (!empty($cart)){
            $quantityT = $quantity + $cart[0]['quantity'];
            $priceT = $price +  $cart[0]['price'];
            $idcart = $cart[0]['idcart'];
            $query ="UPDATE cart SET quantity = $quantityT, price = $priceT  WHERE idcart = $idcart AND idproduct = $idproduct";
            $statement =  $pdo ->exec($query);
        } else {
            $query = "INSERT INTO cart (idproduct, iduser, quantity, price, infos) VALUES (:idproduct, :iduser, :quantity, :price, :infos)";
            $statement = $pdo ->prepare($query);
            $statement ->bindValue(':idproduct', $idproduct, \PDO::PARAM_INT);
            $statement ->bindValue(':iduser', $iduser, \PDO::PARAM_INT);
            $statement ->bindValue(':quantity', $quantity, \PDO::PARAM_INT);
            $statement ->bindValue(':price', $price, \PDO::PARAM_STR);
            $statement ->bindValue(':infos', $infos, \PDO::PARAM_STR);
            $statement ->execute();
        }    
        $pdo->commit();
    } catch (Exception $e) {
            $pdo->rollBack();
            echo "Failed: " . $e->getMessage();
            die;
    }

}
var_dump($_SESSION);

?>
<div>
    <h3>Produit séléctionné : <strong><?php echo $product[0]['snack']; ?></strong></h3>
    Allergènes : <?php echo $product[0]['allergies'];?>
    <div>
        <p>Description : </p>
        <?php echo $product[0]['description'];?> . <br/><br/>
    </div>
    Prix : <?php echo $product[0]['price'];?>€.
</div>

Commander maintenant:
<form method="post">
    <label for="quantity">Choisissez la quantité : </label><br/>
    <input type="number" id="quantity" name="quantity">
    <button type="submit">Commander</button>
</form>
<?php


include 'INC/foot.php';