<?php

$title ='Informations du compte';
include 'INC/head.php';
$pdo = linkToDb();
$user = $_SESSION['iduser'];
$id = $_GET['identifiant'];
$query="SELECT create_At, price, oc.idorder_cine, infos, title, quantity,`session`, date_movie  FROM order_cine as oc JOIN order_product as op ON oc.idorder_cine=op.idorder_cine
JOIN movie as m ON op.idmovie=m.idmovie
JOIN movie_session as ms ON op.idmovie_session=ms.idmovie_session
JOIN session as s ON ms.idsession=s.idsession
JOIN date_of as d ON ms.iddate_of=d.iddate_of
WHERE oc.iduser =$user AND oc.idorder_cine=$id";
$statement = $pdo->query($query);
$movies = $statement->fetchAll(PDO::FETCH_ASSOC);

$query="SELECT oc.create_At, oc.price, oc.idorder_cine, infos, op.quantity, snack
FROM order_cine AS oc
JOIN order_product AS op ON oc.idorder_cine = op.idorder_cine
JOIN product AS m ON op.idproduct = m.idproduct
WHERE oc.iduser=$user AND oc.idorder_cine=$id";
$statement = $pdo->query($query);
$products = $statement->fetchAll(PDO::FETCH_ASSOC);


if (empty($products)) {
    ?>
    <div>
    Récapitulatifs commande n° <?php echo $id;?> du 
    <?php 
    foreach($movies as $movie) {
        echo $movie['create_At'];?><br/>
        <?php echo $movie['title'];?><br/>
        <?php echo $movie['quantity'];?> places à <?php echo $movie['price'];?> €(<?php echo $movie['infos'];?> ).<br/>
        Séance de <?php echo $movie['date_movie'];?> à <?php echo $movie['session'];?> 
        </div>
        <?php }
} else if (empty($movies)){
    ?>
    <div>
    Récapitulatifs commande n° <?php echo $id;?> 
    <?php
    foreach($products as $product) {
    ?>
    du <?php echo $product['create_At'];?><br/>
    <?php echo $product['snack'];?><br/>
    <?php echo $product['quantity'];?> pour <?php echo $product['price'];?> €(<?php echo $product['infos'];?> ).<br/>
    <?php } ?>
    </div>
    <?php
} else {
    ?>
    <div>
    Récapitulatifs commande n° <?php echo $id;?> du <?php echo $movie['create_At'];?><br/>
    <?php echo $movie['title'];?><br/>
    <?php echo $movie['quantity'];?> places à <?php echo $movie['price'];?> €(<?php echo $movie['infos'];?> ).<br/>
    Séance de <?php echo $movie['date_movie'];?> à <?php echo $movie['session'];?><br/>
    <?php
    foreach($products as $product) {
    echo $product['snack'];?><br/>
    <?php echo $product['quantity'];?> places à <?php echo $product['price'];?> €(<?php echo $product['infos'];?> ).<br/>
    <?php }
    ?>
</div>
<?php
}
include 'INC/foot.php';