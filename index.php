<?php
$title= 'Accueil';
include 'INC/head.php';
$movies = getAll("idmovie", "title", "movie");
?>
<div><h3>Film à l'affiche : </h3></div>
<?php
foreach($movies as $movie) {
    echo '<div>' .$movie['title'] . '<br/>';
    echo '<a href="detail.php?identifiant=' . $movie["idmovie"] . '">Détails</a></div>';
}
include 'INC/foot.php';
