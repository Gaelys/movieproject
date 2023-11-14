<?php
$title ='paramètre';
include 'INC/head.php';

$products =getAllFromProduct("*", "product");
?>
<div><h3>Produit en vente : </h3></div>
<?php
foreach($products as $product) {
    echo '<div>' .$product['snack'] . '<br/>';
    echo '<a href="detailproduct.php?identifiant=' . $product["idproduct"] . '">Détails</a></div>';
}
include 'INC/foot.php';
