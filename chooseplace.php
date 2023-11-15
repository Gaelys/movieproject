<?php
$title ='choisissez le nombre de place';
include 'INC/head.php';
var_dump($_POST);
if (empty($_POST)) {
    header ('Location: index.php');
    die;
}
$movie = $_POST['movie'];
$dateTime = $_POST['date'];
$idmovie = $_POST['idmovie'];
$roomDetail = getRoomSeatDetail($dateTime);
var_dump($roomDetail);
$date = $roomDetail[0]['date_movie'];
$formattedDate = substr($date, 8, 2);
$monthNum = mb_substr($date, 5 ,2);
$seatAvai = $roomDetail[0]['seats'] - $roomDetail[0]['seatTaken'];
$hourOfMovie = substr($roomDetail[0]['session'], 0, 5);
?>
<h3>Vous avez choisi le film : "<?php echo $movie;?>", le <?php echo $formattedDate . " du " . $monthNum . " à " . $hourOfMovie ;?> : </h3>
<p>Il reste <?php echo $seatAvai;?> places. </p>
<form method="post" action="chooseprice.php">
    <label for="quantity">Choisissez la quantité : </label><br/>
    <input type="number" min="0" max="$seatAvai" id="quantity" name="quantity">
    <input type="hidden" name="idmovie" value="<?php echo $idmovie;?>">
    <input type="hidden" name="movie" value="<?php echo $movie;?>">
    <input type="hidden" name="cineSession" value="<?php echo $dateTime;?>">
    <button type="submit">Réserver ses places</button>
</form>
<?php

include 'INC/foot.php';
