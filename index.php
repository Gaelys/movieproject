<?php
$title= 'Accueil';
include 'INC/head.php';

$page = $_GET['page'] ?? 1;
$nbResultsInPage = 3;
$offset = ($page - 1) * $nbResultsInPage;
$where = '';
if (isset($_GET['search']) && $_GET['search'] != '') {
    $where .=" WHERE title LIKE :search";
}
$pdo =linkToDb();
$query= "SELECT COUNT(idmovie) as total FROM movie $where";
$statement = $pdo->prepare($query);
if (isset($_GET['search']) && $_GET['search'] != '') {
    $statement ->bindValue(':search', '%' . $_GET['search'] . '%');
}
$statement->execute();
$rows = $statement->fetchcolumn(0);
$npPages = ceil($rows / $nbResultsInPage);
$query  = "SELECT idmovie, title, images, summary FROM movie $where LIMIT $offset ,$nbResultsInPage";
$statement = $pdo->prepare($query);
if (isset($_GET['search']) && $_GET['search'] != '') {
    $statement ->bindValue(':search', '%' . $_GET['search'] . '%');
}
$statement->execute();
$movies = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<div>
    
    <h3 class="text-warning"><i class="fa-solid fa-film"></i>Film à l'affiche : </h3></div>
<form action="index.php" class="d-flex mb-3">
    <input type="search" name="search" placeholder="Recherchez votre film" class="form-contro me-sm-2 " value="<?php echo $_GET['search'] ?? '';?>">
    <button class="btn btn-primary my-2 my-sm-0">Recherche</button>
</form>
<?php
foreach($movies as $movie) {
    ?>
    <div class="d-flex mb-3">
      <div class="col-md-2">
        <img src="<?php echo $movie['images'];?>" width="160em" height="250em"> 
      </div>
      <div class="col-md-6">
        <?php 
        echo '<h6 class="specolor">' . $movie['title'] . ":</h6> " . $movie['summary']; 
        echo '<p><a href="detailmovie.php?identifiant=' . $movie["idmovie"] . '">Détails</a></p>';
        ?>
      </div>
    </div>
    <?php
}
?>
<div>
  <ul class="pagination pagination-lg">
    <?php for ($i = 1; $i <= $npPages; $i ++): ?>
    <li class="page-item <?php echo $i == $page ? 'active' : '' ?>" <?php echo $i == $page ? 'aria-current="page"' : '' ?>>
      <a class="page-link" href="index.php?page=<?php echo $i; ?>&search=<?php echo $_GET['search'] ?? ''; ?>"><?php echo $i; ?>
      </a>
    </li>
    <?php endfor ?> 
  </ul>
</div>
<?php
include 'INC/foot.php';
