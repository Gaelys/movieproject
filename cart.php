<?php
$title ='Panier';
include 'INC/head.php';
?>

<?php
$user = $_SESSION['iduser'];

if (!empty($_POST)) {
    
    $currentDate = date("Y-m-d H:i:s");
    $totalPrice = $_POST['totalprice'];
    $iduser = $_SESSION['iduser'];
    $lookForEnd = 0;
    $idmovie_session_array = [];
    foreach ($_POST['cart'] as $item) {
        if (isset($item['idmovie'])) {
            $lookForEnd ++;
            $idmovie_session_array[] = $item['idmovie_session'];
        }
    }
    $pdo=linkToDb();
    if ($lookForEnd === 0) {
        $dateOfExpire = date("Y-m-d 23:59:59");
    } else if (($lookForEnd === 1)) {
        $idmovie_session = $idmovie_session_array[0];
        $query = "SELECT end_session FROM movie_session WHERE idmovie_session = $idmovie_session";
        $statement = $pdo->query($query);
        $getExpire = $statement->fetch(PDO::FETCH_ASSOC);
        $dateOfExpire = $getExpire['end_session'];
    } else {
        $placeholders = implode(', ', array_fill(0, count($idmovie_session_array), '?'));
        $query = "SELECT MAX(end_session) AS max_expiration FROM movie_session WHERE idmovie_session IN ($placeholders)";
        $statement = $pdo->prepare($query);
        foreach ($idmovie_session_array as $key => $idmovie_session) {
            $statement->bindValue(($key + 1), $idmovie_session, PDO::PARAM_INT);
        }
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $dateOfExpire = $result['max_expiration'];
    }
    
    try {
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        
        $insertOrderCine = "INSERT INTO order_cine (price, iduser, create_At, date_end) VALUES (:price, :iduser, :currentDate, :date_end)";
        $statement = $pdo->prepare($insertOrderCine);
        $statement->bindParam(':price', $totalPrice);
        $statement->bindParam(':iduser', $iduser);
        $statement->bindParam(':currentDate', $currentDate);
        $statement->bindParam(':date_end', $dateOfExpire);
        $statement->execute();
        
        $idorder_cine = $pdo->lastInsertId();

        $cart = $_POST['cart'];
        
        foreach ($cart as $item) {
            if(isset($item['idmovie'])) {
                $queryInsertOrderProduct = "INSERT INTO order_product (idorder_cine, idmovie, idmovie_session, quantity, infos, price_elements) VALUES (:idorder_cine, :idmovie, :idmovie_session, :quantity, :infos, :price_elements)";
                $statementProduct = $pdo->prepare($queryInsertOrderProduct);
                $statementProduct->bindParam(':idorder_cine', $idorder_cine);
                $statementProduct->bindParam(':idmovie', $item['idmovie']);
                $statementProduct->bindParam(':idmovie_session', $item['idmovie_session']);
                $statementProduct->bindParam(':quantity', $item['quantity']);
                $statementProduct->bindParam(':infos', $item['infos']);
                $statementProduct->bindParam(':price_elements', $item['elementprice']);
                $statementProduct->execute();
            } else {
                $queryInsertOrderProduct = "INSERT INTO order_product (idorder_cine, idproduct, quantity, infos, price_elements) VALUES (:idorder_cine, :idproduct, :quantity, :infos, :price_elements)";
                $statementProduct = $pdo->prepare($queryInsertOrderProduct);
                $statementProduct->bindParam(':idorder_cine', $idorder_cine);
                $statementProduct->bindParam(':idproduct', $item['idproduct']);
                $statementProduct->bindParam(':quantity', $item['quantity']);
                $statementProduct->bindParam(':infos', $item['infos']);
                $statementProduct->bindParam(':price_elements', $item['elementprice']);
                $statementProduct->execute();
            }
        }
        $queryDeleteCart = "DELETE FROM cart where iduser = :iduser";
        $statementDeleteCart = $pdo->prepare($queryDeleteCart);
        $statementDeleteCart->bindParam(':iduser', $iduser);
        $statementDeleteCart->execute();
        
        $pdo->commit();
  
    } catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed: " . $e->getMessage();
    die;
    }


}

$getCart = getCart($user);

if (!empty($getCart)) {
    ?>
    <h2 class="mt-2">Contenu du panier :</h2>

    <div class="table-responsive">
        <table class="table table-hover text-align-center mt-5">
            <thead class="table-info">
                <tr><th>Vos produits</th><th scope="col">Quantité</th><th scope="col">Prix unitaire</th><th scope="col">Prix de l'ensemble</th><th scope="col">Modifier les item</th><th  scope="col">Supprimer un produit</th><th  scope="col">Prix total</th></tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($getCart as $key =>$item) {
                    echo '<tr><td  scope="row">';
                    if (!empty($item['idproduct'])) {
                        $name = getProductNameInCart($item['idproduct']);
                        echo $name['snack'];
                    }
                    if (!empty($item['idmovie'])) {
                        $name = getTitleFromMovie($item['idmovie']); 
                        echo $name['title'];
                    }
                    ?>
                    </td><td><?php echo $item['quantity']; ?></td><td><?php
                    if (!empty($item['idproduct'])) {
                        echo $item['price'];
                    }
                    if (!empty($item['idmovie'])) {
                        $priceHer = getPricesession($item['idcart']);
                        echo $priceHer['price'];
                    }
                    ?>€</td><td><?php
                    if (!empty($item['idproduct'])) {
                        echo $p = $item['price']*$item['quantity']; $total =$total + $p;
                    }
                    if (!empty($item['idmovie'])) {
                        $priceHer = getPricesession($item['idcart']);
                        echo $p = $priceHer['price']*$item['quantity']; $total =$total + $p;
                    }
                    ?>
                    €</td><td>
                    <?php 
                    if (!empty($item['idproduct'])) {
                        echo '<a href="lessitem.php?idp=' . $item['idproduct'] . '"><i class="fa-solid fa-minus"></i></a> ou';
                    }
                    ?>
                    <?php
                    if (!empty($item['idproduct'])) {
                        echo '<a href="moreitem.php?idp=' . $item['idproduct'] . '"><i class="fa-solid fa-plus"></i></a>';
                    }
                    ?>
                    </td><td>
                    <?php
                    if (!empty($item['idproduct'])) {
                        echo '<a href="trash.php?idp=' . $item['idproduct'] . '"><i class="fa-solid fa-trash"></a>';
                    } else {
                        ?>
                        <form method="post" action="trash.php">
                            <input type="hidden" name="quantity" value="<?php echo $item['quantity'];?>">
                            <input type="hidden" name="idmovie_session" value="<?php echo $item['idmovie_session'];?>">
                            <input type="hidden" name="idprice" value="<?php echo $priceHer['idprice'];?>">
                            <input type="hidden" name="idmovie" value="<?php echo $item['idmovie'];?>">
                            <input type="submit" value="supprimer" class="btn btn-warning btn-sm"></input>
                        </form>
                        <?php
                    }
                    ?><td></td></tr>
                <?php }
                ?>
                <tr><td colspan="6"></td><td><?php echo $total;?>€</td></tr>
            </tbody>
        </table>
    </div>
    <form method="post" class="mb-3">
        <?php
        foreach ($getCart as $key => $item) {
            if(!empty($item['idproduct'])) {
                ?>
                <input type="hidden" name="cart[<?php echo $key; ?>][idproduct]" value="<?php echo $item['idproduct']; ?>">
                <?php
                $p = $item['price']*$item['quantity'];
            } else{
                ?>
                <input type="hidden" name="cart[<?php echo $key; ?>][idmovie]" value="<?php echo $item['idmovie']; ?>">
                <input type="hidden" name="cart[<?php echo $key; ?>][idmovie_session]" value="<?php echo $item['idmovie_session']; ?>">
                <?php
                $priceHer = getPricesession($item['idcart']);
                $p = $priceHer['price']*$item['quantity'];
            }
            
            ?>
            <input type="hidden" name="cart[<?php echo $key; ?>][quantity]" value="<?php echo $item['quantity']; ?>">
            <input type="hidden" name="cart[<?php echo $key; ?>][infos]" value="<?php echo $item['infos']; ?>">
            <input type="hidden" name="cart[<?php echo $key; ?>][elementprice]" value="<?php echo $p; ?>">
            
        <?php } ?>
        <input type="hidden" name="totalprice" value="<?php echo $total; ?>">
        <button type="submit" class="btn btn-primary">Payer</button>
    </form>
    <?php
} else {
    ?>
    <div class="container mt-5">
        <div>
            <div class="mb-5">
            Le panier est vide.
            </div>
            <div class="mb-5">
                <i class="fa-solid fa-hourglass fa-2xl"></i>
            </div>
            <div class="mb-5">
            Nous savons que c'est un choix cornélien.<br/>
            Prenez votre temps.<br/>
            Et surtout ... appreciez votre film...<br/>
            et vos gourmandises.
            </div>
        </div>
    </div>
    <?php
}

include 'INC/foot.php';