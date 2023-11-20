<?php

$title ='Informations du compte';
include 'INC/head.php';
$pdo = linkToDb();

$getMyBookings = getMyBookings($_SESSION['iduser']);

?>
<h3>Réservations en cours</h3>
<?php
if (empty($getMyBookings)) {
    ?>
    <div class="container">
<P>Auncune reservations en cours</P>
    </div>
    <?php
} else { 
    foreach($getMyBookings as $booking) {
        ?>
        <div>
            <h4>Réservation n°<?php echo $booking['idorder_cine'];?> faite le : <?php echo $booking['create_At'];?></h4>
            <div>
            Total : <?php echo $booking['price'];?> € 
            <?php
            echo '<a href="bookingdetail.php?identifiant=' . $booking['idorder_cine'] . '">détails</></a>';
            ?>
            </div>
        </div>
        <?php
    }
}
$getMyOldBookings = getMyOldBookings($_SESSION['iduser']);
?>
<hr>
<h3>Anciennes réservations</h3>
<?php
if (empty($getMyOldBookings)) {
    ?>
    <div class="container">
        <P>Auncune reservations</P>
    </div>
    <?php
} else { 
    foreach($getMyOldBookings as $booking) {
        ?>
        <div class="mb-3">
            <h4>Réservation n°<?php echo $booking['idorder_cine'];?> faite le : <?php echo $booking['create_At'];?></h4>
            <div>
            Total : <?php echo $booking['price'];?> € 
            <?php
            echo '<a href="bookingdetail.php?identifiant=' . $booking['idorder_cine'] . '">détails</></a>';
            ?>
            </div>
        </div>
        <?php
    }
}
include 'INC/foot.php';