<?php
$title ='votre gourmandise';
include 'INC/head.php';

$identifiantP = $_GET['identifiant'];
if (!empty($_POST)) {
    $quantity = $_POST['quantity'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    if (isset($_SESSION['cart'][$identifiantP])) {
        $_SESSION['cart'][$identifiantP] += $quantity;
    } else {
        $_SESSION['cart'][$identifiantP] = $quantity;
    }
}
var_dump($_SESSION);
$product = getProductInfo($identifiantP);
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