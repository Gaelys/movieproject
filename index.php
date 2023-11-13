<?php
$title= 'Accueil';
include 'INC/head.php';
$movies = getAll("idmovie", "title", "movie");
foreach($movies as $movie) {
    echo $movie['title'] . '<br/>';
    echo '<a href="detail.php?identifiant=' . $movie["idmovie"] . '">Détails</a>';
}
include 'INC/foot.php';
?>