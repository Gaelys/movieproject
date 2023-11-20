<?php
$title ='choisissez le nombre de place';
include 'INC/head.php';
if (empty($_POST)) {
    header ('Location: index.php');
    die;
}
if (empty($_SESSION['iduser'])) {
    header('Location: login.php');
    die;
}
$movie = $_POST['movie'];
$dateTime = $_POST['date'];
$idmovie = $_POST['idmovie'];
$roomDetail = getRoomSeatDetail($dateTime);
$idMovieSession = $roomDetail[0]['idmovie_session'];
$date = $roomDetail[0]['date_movie'];
$formattedDate = substr($date, 8, 2);
$monthNum = mb_substr($date, 5 ,2);
$seatAvai = $roomDetail[0]['seatAvai'];
$hourOfMovie = substr($roomDetail[0]['session'], 0, 5);
?>
<h3>Vous avez choisi le film : "<?php echo $movie;?>", le <?php echo $formattedDate . " du " . $monthNum . " à " . $hourOfMovie ;?> : </h3>
<p>Il reste <?php echo $seatAvai;?> places. </p>
<form method="post" action="chooseprice.php">
    <div class="form-group col-sm-5">
        <label class="form-label mt-4" for="quantity">Choisissez la quantité : </label><br/>
        <input type="number" class="form-control" min="0" max="<?php echo $seatAvai;?>" id="quantity" name="quantity">
    </div>
    <input type="hidden" name="idmovie" value="<?php echo $idmovie;?>">
    <input type="hidden" name="movie" value="<?php echo $movie;?>">
    <input type="hidden" name="cineSession" value="<?php echo $dateTime;?>">
    <input type="hidden" name="idmovie_session" value="<?php echo $idMovieSession;?>">
    <button type="submit" class="btn btn-outline-info">Réserver ses places</button>
</form>
<?php

include 'INC/foot.php';
