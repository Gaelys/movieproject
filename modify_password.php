<?php
$title ='Modification de mot de passe';
include 'INC/head.php';


if (!empty($_POST)) {
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $oldPassword = $_POST['oldPassword'];
    $user = $_SESSION['iduser'];
    if (($password1 === $password2) && ($password1 !== $oldPassword)) {
        $password_hash = password_hash($password1, PASSWORD_DEFAULT);
        $changePassword = updatePassword($password_hash, $user);
        ?>
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Modification de mot de passe : </strong>Votre mot de passe a été modifié avec succès.
        </div>
        <?php
    } else if (($password1 !== $password2)) {
        echo "Vous n'avez pas entrer le même mot de passe.";
    } else {
        echo "Le nouveau mot de passe ne peut pas être le même que l'ancien.";
    }

}
?>
<h2>Vous souhaitez modifier votre mot de passe : <?php echo $_SESSION['login'];?></h2>

<form method="post" class="mb-3">
    <div  class="container ">
        <div class="form-group">
            <label class="col-sm-4 col-form-label" for="password1">Nouveau mot de passe : </label>
            <input class="form-control" type=password id="password1" name="password1">
        </div>
        <div class="form-group">
            <label class="col-sm-4 col-form-label" for="password2">Nouveau mot de passe : </label>
            <input class="form-control" type=password id="password2" name="password2">
        </div>
        <div class="form-group">
            <label class="col-sm-4 col-form-label" for="oldPassword">Ancien mot de passe : </label>
            <input class="form-control" type=password id="oldPassword" name="oldPassword">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Soumettre</button>
        </div>
    </div>
</form>

<?php
include 'INC/foot.php';