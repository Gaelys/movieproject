<?php
$title ='détail';
include 'INC/head.php';
if (empty($_GET) || (!is_numeric($_GET['identifiant']))) {
    header('Location: product.php');
    die;
}
$productList = productList("idmovie", "movie");
if (!in_array($_GET['identifiant'],$productList)) {
    header('Location: index.php');
    exit();
}
$identifiant = $_GET['identifiant'];
$movie = getinfo("movie", "classification", "idclassification", "idmovie", $identifiant);

if(isset($_SESSION['message'])) {
    ?>
    <div class="alert alert-dismissible alert-warning">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <h4 class="alert-heading"><?php echo $_SESSION['message'];?></h4>
        <p class="mb-0"></p>
    </div>
    <?php
    unset($_SESSION['message']);
}
?>
<div>
    <h3>Film à l'affiche <strong>"<?php echo $movie[0]['title'];?>"</strong>.</h3>
    <div class="alert alert-danger">
        <h4 class="alert-heading">Classé : <?php echo $movie[0]['classification'];?></h4>
    </div>
    <img src="<?php echo $movie[0]['images'];?>" width="160em" height="250em"> 
    <h4>Résumé : </h4><?php echo $movie[0]['summary'];?><br/><br/>
    Date de sortie :<?php echo $movie[0]['releaseDate'];?><br/>
    <?php
    $formattedHour = substr($movie[0]['duration'], 0, 2);
    $formattedMin = substr($movie[0]['duration'], 3, 2);

    echo "Ce film dure " . $formattedHour . "h" . $formattedMin .".<br/>";
    ?>
</div>
<?php
$availableMovies = getSession($identifiant);

?>
<h3>Places restantes</h3>
<table class="table table-hover table-responsive">
    <thead class="table-success">
        <tr><th> Séance </th><th>Heure</th><th>Places restantes</th></tr>
    </thead>
    <tbody>
        <?php
        foreach ($availableMovies as $avMovie) {
            $formattedTime = substr($avMovie['session'], 0, 5);   
            echo '<tr><td>' . $avMovie['date_movie'] . '</td><td>' . $formattedTime . '</td><td>' .  $avMovie['seatAvai'] . ' places</td></tr>';
            }
        ?>
    </tbody>
</table>
<h3>Choisissez votre séance: </h3>

<form action="chooseplace.php" method="post" class="mb-3 col-sm-5">
    <div class="mb-3 col-sm-5">
        <label class="form-label"for="date">Choisissez votre date: </label><br/>
        <select class="form-select" name="date">
            <option value=''>Choissisez une option</option>
            <?php
            foreach ($availableMovies as $avMovie) {
                $hourOfMovie = substr($avMovie['session'], 0, 5);
                $concat = $avMovie['date_movie'].' à ' . $hourOfMovie;
            echo '<option value="'. $avMovie['idmovie_session'] . '">' . $concat  . '</option>';
            }
            ?>
        </select>
    </div>
    
    <input type="hidden" name="movie" value="<?php echo $movie[0]['title'];?>">
    <input type="hidden" name="idmovie" value="<?php echo $identifiant;?>">
    <button type="submit" class="btn btn-outline-info">Commander</button>
</form>
<?php
include 'INC/foot.php';
