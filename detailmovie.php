<?php
$title ='détail';
include 'INC/head.php';
$identifiant = $_GET['identifiant'];
$movie = getinfo("movie", "classification", "idclassification", "idmovie", $identifiant);
echo '<br/>';
echo 'Film à l\'affiche <strong>"' . $movie[0]['title'] . '"</strong>.<br/>';
echo "Classé : " .$movie[0]['classification'];
echo "<p>Résumé : </p>" . $movie[0]['summary'] . '<br/><br/>';
echo "Date de sortie : " . $movie[0]['releaseDate'] . '<br/>';
$formattedHour = substr($movie[0]['duration'], 0, 2);
$formattedMin = substr($movie[0]['duration'], 3, 2);

echo "Ce film dure " . $formattedHour . "h" . $formattedMin .".<br/>";

$availableMovies = getSession($identifiant);
var_dump($availableMovies);

?>
<h3>Places restantes</h3>
<table>
    <tr><th> Séance </th><th>Heure</th><th>Places restantes</th></tr>
    <?php
    foreach ($availableMovies as $avMovie) {
        $formattedTime = substr($avMovie['session'], 0, 5);   
        echo '<tr><td>' . $avMovie['date_movie'] . '</td><td>' . $formattedTime . '</td><td>' .  $avMovie['seats'] - $avMovie['seatTaken'] . ' places</td></tr>';
        }
    ?>
</table>
<h3>Choissisez votre séance: </h3>

<form action="chooseplace.php" method="post">
    <label for="date">Choisissez votre date: </label><br/>
    <select name="date">
        <option value=''>Choissisez une option</option>
        <?php
        foreach ($availableMovies as $avMovie) {
            $hourOfMovie = substr($avMovie['session'], 0, 5);
            $concat = $avMovie['date_movie'].' à ' . $hourOfMovie;
        echo '<option value="'. $avMovie['idmovie_session'] . '">' . $concat  . '</option>';
        }
        ?>
    </select>
    
    <input type="hidden" name="movie" value="<?php echo $movie[0]['title'];?>">
    <input type="hidden" name="idmovie" value="<?php echo $identifiant;?>">
    <button type="submit">Commander</button>
</form>
<?php
include 'INC/foot.php';
