<?php
$title ='détail';
include 'INC/head.php';
$identifiant = $_GET['identifiant'];
$movie = getinfo("movie", "classification", "idclassification", "idmovie", $identifiant);
echo '<br/>';
echo 'Film à l\'affiche <strong>"' . $movie[0]['title'] . '"</strong>.<br/>';
echo "Classé : " .$movie[0]['classification'];
echo "<p>Résumé : </p>" . $movie[0]['resume'] . '<br/><br/>';
echo "Date de sortie : " . $movie[0]['releaseDate'] . '<br/>';
$formattedHour = substr($movie[0]['duration'], 0, 2);
$formattedMin = substr($movie[0]['duration'], 3, 2);

echo "Ce film dure " . $formattedHour . "h" . $formattedMin .".<br/>";

include 'INC/foot.php';
?>