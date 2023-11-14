<?php
$title ='Modification de mot de passe';
include 'INC/head.php';


if (!empty($_POST)) {
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $oldPassword = $_POST['oldPassword'];
    $user = $_SESSION['iduser'];
    if (($password1 === $password2) && ($password1 !== $oldPassword)) {
        $changePassword = updatePassword($password1, $user);
    } else if (($password1 !== $password2)) {
        echo "Vous n'avez pas entrer le même mot de passe.";
    } else {
        echo "Le nouveau mot de passe ne peut pas être le même que l'ancien.";
    }

}
?>
<h2>Vous souhaitez modifier votre mot de passe : <?php echo $_SESSION['login'];?></h2>

<form method="post">
    <div>
        <label for="password1">Nouveau mot de passe : </label>
        <input type=password id="password1" name="password1">
    </div>
    <div>
        <label for="password2">Nouveau mot de passe : </label>
        <input type=password id="password2" name="password2">
    </div>
    <div>
        <label for="oldPassword">Ancien mot de passe : </label>
        <input type=password id="oldPassword" name="oldPassword">
    </div>
    <div>
        <button type="submit">Soumettre</button>
    </div>
</form>

<?php
include 'INC/foot.php';