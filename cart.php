<?php
$title ='Panier';
include 'INC/head.php';
?>

<?php

var_dump($_SESSION);
if (!empty($_SESSION['cart'])) {
    ?>
    <h2>Contenu du panier :</h2>
    
    <table>
        <tr><th>Vos produits</th><th>Quantité</th><th>Prix unitaire</th><th>Prix de l'ensemble</th><th>Modifier les item<th>Supprimer un produit</th></th><th>Prix total</th></tr>
        <tr>
        <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $idproduct => $quantity) {
            $productName = getProductInCart($idproduct);
            $p = $quantity * $productName['price'];
            echo '<td>' . $productName['snack'] . '</td><td>' . $quantity . '</td><td>' . $productName['price'] . '€</td><td>' . $p . '€</td><td><a href="lessitem.php?$id=' .$idproduct . '"><i class="fa-solid fa-minus"></i></a> ou <a href="moreitem.php?$id=' .$idproduct . '"><i class="fa-solid fa-plus"></i></a></td><td><i class="fa-solid fa-trash"></i></td></tr>';
            $total = $total + $p;
        }?>
        <tr><td colspan="6"></td><td><?php echo $total;?>€</td></tr>
    </table>

    <form method="post">
        <button type="submit">Payer</button>
    </form>
    <?php
} else {
    ?><p>Le panier est vide.</p><?php
}

if (!isset($_SESSION['cart'])) {
    ?><p>Votre panier est vide</p><?php
}
include 'INC/foot.php';