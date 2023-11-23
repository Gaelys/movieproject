<?php
$title ='votre gourmandise';
include 'INC/head.php';
if ((empty($_GET)) || (!is_numeric($_GET['identifiant']))) {
    header('Location: product.php');
    die;
}

$productList = productList("idproduct", "product");
if (!in_array($_GET['identifiant'],$productList)) {
    header('Location: product.php');
    exit();
}
$idproduct = $_GET['identifiant'];
$product = getProductInfo($idproduct);

if (!empty($_POST)) { 
    if (empty($_SESSION['iduser'])) {
        header('Location: login.php');
        die;
    }
    $iduser = $_SESSION['iduser'];
    $price = $product[0]['price'];
    $infos = $product[0]['allergies'];
    $quantity = $_POST['quantity'];
    if ($quantity === '0' || $quantity === '' || $quantity < 0) {
        ?>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <div class="container">
                <strong>Oups !</strong> quantité non valide.
            </div>
        </div>
        <?php
    } else {
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
        $_SESSION['message'] = "Ajouté au panier avec succès.";
        header('location: product.php');
        exit();
    }
}

?>
<div class="mb-3">
    <h3>Produit séléctionné : <strong><?php echo $product[0]['snack']; ?></strong></h3>
    <div class="alert alert-danger">
        <h4 class="alert-heading">Allergènes : <?php echo $product[0]['allergies'];?></h4>
    </div>
    <img src="<?php echo $product[0]['images'];?>" width="160em" height="250em"> 
    <div>
        <h4>Description : </h4>
        <?php echo $product[0]['description'];?> . <br/><br/>
    </div>
    Prix : <?php echo $product[0]['price'];?>€.
</div>
<div class="mb-2">
    <h4>Commander maintenant:</h4>
</div>
<form method="post" class="mb-3 col-sm-3">
    <div class="form-group">
        <div class="mb-3">
            <label for="quantity" class="form-label mt-4">Choisissez la quantité : </label><br/>
            <input class="form-control" type="number" min="0" id="quantity" name="quantity">
        </div>
            <div>
            <button type="submit" class="btn btn-outline-info">Commander</button>
        </div>
    </div>
</form>
<?php


include 'INC/foot.php';