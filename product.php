<?php
$title ='gourmandises';
include 'INC/head.php';

$products =getAllFromProduct("*", "product");
if(isset($_SESSION['message'])) {
  ?>
  <div class="alert alert-dismissible alert-success">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <h4 class="alert-heading"><?php echo $_SESSION['message'];?></h4>
    <p class="mb-0"></p>
  </div>
  <?php
  unset($_SESSION['message']);
}
?>
<div><h3 class="text-warning"><i class="fa-solid fa-cookie-bite"></i>Produit en vente : </h3></div>
<?php

foreach($products as $product) {
    ?>
    <div class="d-flex mb-3">
      <div class="col-md-2">
        <img src="<?php echo $product['images'];?>" width="190em" height="250em"> 
      </div>
      <div class="col-md-6">
      <?php 
        echo '<h6 class="specolor">' . $product['snack'] . ":</h6> ";
        echo '<div>' . $product['description'] . '</div>';
        echo '<span class="badge bg-danger rounded-pill">Allergène :' . $product['allergies']. '</span><br/>';
        echo '<a href="detailproduct.php?identifiant=' . $product["idproduct"] . '">Détails</a></div>';
        ?>
      </div>
    </div>
    <?php
}
include 'INC/foot.php';
