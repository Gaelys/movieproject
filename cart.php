<?php
$title ='Panier';
include 'INC/head.php';
if(empty($_SESSION['login'])) {
    header('Location: login.php');
    die();
}
$iduser = $_SESSION['iduser'];

if (!empty($_POST)) {
    
    $currentDate = date("Y-m-d H:i:s");
    $totalPrice = $_POST['totalprice'];
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
        
        if (isset($_POST['idoptions'])) {
            $idoptions = $_POST['idoptions'];
            $query = "UPDATE order_cine SET idoptions = :idoptions WHERE iduser = :iduser AND idorder_cine = :idorder_cine";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':idoptions', $idoptions);
            $statement->bindParam(':iduser', $iduser);
            $statement->bindParam(':idorder_cine', $idorder_cine);
            $statement->execute();
        }

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
header ('Location: cart.php');
die;

}

$getCart = getCart($iduser);

if (!empty($getCart)) {
    ?>
    <h2 class="mt-2">Contenu du panier :</h2>
    <?php
    $total = 0;
    foreach ($getCart as $key =>$item) {
        ?>
        <div>
        <div class="card text-white bg-primary border-info mb-3" style="max-width: 100%;">
            <div class="card-header">Vos Articles : </div>
            <div>
                <?php
                if (!empty($item['idproduct'])) {
                    $name = getProductNameInCart($item['idproduct']);
                    echo '<strong class="text-info">' . $name['snack'] . '</strong><br/>';
                }
                if (!empty($item['idmovie'])) {
                    $name = getTitleFromMovie($item['idmovie']); 
                    echo '<strong class="text-info">' . $name['title'] . '</strong><br/>';
                }
                echo 'quantité : <strong class="text-info">' . $item['quantity'] . '</strong><br/>';
                if (!empty($item['idproduct'])) {
                    echo 'Prix unitaire : <strong class="text-info">' . $item['price'] . ' €</strong><br/>';
                }
                if (!empty($item['idmovie'])) {
                    $priceHer = getPricesession($item['idcart']);
                    echo 'Prix unitaire : <strong class="text-info">' . $priceHer['price'] . ' €</strong><br/>';
                }
                if (!empty($item['idproduct'])) {
                    $p = $item['price']*$item['quantity'];
                    echo '<strong class="text-info">' .$p . ' €</strong><br/>';
                    $total = $total + $p;
                }
                if (!empty($item['idmovie'])) {
                    $priceHer = getPricesession($item['idcart']);
                    $p = $priceHer['price']*$item['quantity'];
                    echo '<strong class="text-info">' . $p . ' €</strong><br/>';
                    $total = $total + $p;
                }
                if (!empty($item['idproduct'])) {
                    ?>
                    <div class="container">
                            <div class="mb-3">
                                <?php
                                echo '<a class="text-info" href="lessitem.php?idp=' . $item['idproduct'] . '"><i class="fa-solid fa-minus fa-2xl"></i></a> ou ';
                                echo '<a class="text-info" href="moreitem.php?idp=' . $item['idproduct'] . '"><i class="fa-solid fa-plus fa-2xl"></i></a><br/>';
                                ?>
                            </div>
                            <?php
                            echo '<a class="text-info" href="trash.php?idp=' . $item['idproduct'] . '"><i class="fa-solid fa-trash fa-xl"></i></a>';
                            ?>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="container">
                        <form method="post" action="trash.php">
                            <input type="hidden" name="quantity" value="<?php echo $item['quantity'];?>">
                            <input type="hidden" name="idmovie_session" value="<?php echo $item['idmovie_session'];?>">
                            <input type="hidden" name="idprice" value="<?php echo $priceHer['idprice'];?>">
                            <input type="hidden" name="idmovie" value="<?php echo $item['idmovie'];?>">
                            <input type="submit" value="supprimer" class="btn btn-info btn-sm"></input>
                        </form>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    <?php }
    $showSpecials  = 0;
    foreach ($getCart as $cartItem) {
        if ($cartItem['idoptions'] !== NULL) {
            $showSpecials = 1;
        }
    }
    ?>
    <div class="card text-white bg-primary border-danger mb-3" style="max-width: 100%;">
        <div class="card-header">Total <?php echo $showSpecials !== 0 ? 'avant réductions' : ''?> : <strong class="text-danger"><?php echo $total;?> €</strong></div>
        <?php
        if ($showSpecials !== 0) {
            
            $getSpecials = getSpecials($iduser);
            $total = $total - $getSpecials['conditions'];
            if ($total < 0) {
                $total = 0;
            }
            ?>
            <div><h6> Une promotion est active sur votre panier : <span class="text-info"><?php echo $getSpecials['option'];?></span></h6>
            Vous bénéficiez de <?php echo $getSpecials['conditions'];?> € de réduction.<br/>
            Soit un total final de : <span class="text-danger"><?php echo $total;?> €</span>.
            </div>
            <?php
        }
        ?>
        <div class="container">
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
                    
                <?php } 
                if ($getCart[0]['idoptions'] !== NULL) {
                    ?>
                    <input type="hidden" name="idoptions" value="<?php echo $getCart[0]['idoptions']; ?>">
                    <?php
                }
                ?>
                <input type="hidden" name="totalprice" value="<?php echo $total; ?>">
                <button type="submit" class="btn btn-danger mt-4">Payer <strong><?php echo $total;?> €</strong></button>
            </form>
        </div>
    </div>
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