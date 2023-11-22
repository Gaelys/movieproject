<?php
$title ='promotions';
include 'INC/head.php';

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
$iduser =$_SESSION['iduser'];
$getOptionsOfC = getOptionsOfC($iduser);

if (isset($_POST['specials']) || ($getOptionsOfC['idoptions']) !== NULL) {
    $iduser = $_SESSION['iduser'];
    $pdo = linkToDb();
    $query = "UPDATE cart set idoptions = 1 WHERE iduser = :iduser";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':iduser', $iduser, PDO::PARAM_INT);
    $statement->execute();
    header ('Location: index.php');
    exit();
}
if (isset($_POST['next'])) {
    header ('Location: index.php');
    exit();
}
?>

<form method="post">
    <fieldset class="form-group">
      <legend class="mt-4">Promotions</legend>
        <div class="form-check">
            <input class="form-check-input" name="specials" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" name="specials" for="flexCheckDefault">
            Je souhaite bénéficier de la promotions black friday (5€ sur mon panier).
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="next" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" name="next" for="flexCheckDefault">
            Je ne souhaite pas bénéficier de la promotions black friday.
            </label>
        </div>
    </fieldset>
    <input type="submit"></input>
</form>
<?php
include 'INC/foot.php';