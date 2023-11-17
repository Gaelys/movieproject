<?php
$title ='Informations du compte';
include 'INC/head.php';
$pdo = linkToDb();

if (!empty($_POST)) {
    $login = $_POST['login'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname']; 
    $birthdate = $_POST['birthdate'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $id = $_SESSION['iduser'];
    try{
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
        $modifyUser =  modifyInfoUser($login, $firstname, $lastname, $birthdate, $email, $phone, $id); 
        $pdo->commit();

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Failed: " . $e->getMessage();
        die;
    }
}




$thisUser = getUserInfo($_SESSION['iduser']);
echo '<h2>Modifier vos informations "' . $thisUser[0]['login'] . '".</h2><br/<br/>';
?>
<div>
    <a href="modify_password.php">Modifier le mot de passe</a> -
    <a href="bookings.php">Voir mes réservations</a>
</div>
<hr>
<div>
    <form method="post">
        <table>
            <tr><th>Identifiant :</th><td><input type="text" name="login" value="<?php echo $thisUser[0]['login'];?>"></td></tr>
            <tr><th>Prénom : </th><td><input type="text" name="firstname" value="<?php echo $thisUser[0]['firstname'];?>"/></td></tr>
            <tr><th>Nom : </th><td><input type="text" name="lastname" value="<?php echo $thisUser[0]['lastname']; ?>"/></td></tr>
            <tr><th>Date de naissance : </th><td><input type="date" name="birthdate" value="<?php echo $thisUser[0]['birthdate'];?>"/></td></tr>
            <tr><th>Email : </th><td><input type="email" name="email" value="<?php echo $thisUser[0]['email'];?>"/></td></tr>
            <tr><th>téléphone : </th><td><input type="tel" name="phone" value="<?php echo $thisUser[0]['phone'];?>"/></td></tr>
            <tr><td><input type="submit" value="Enregistrer"></td></tr>
        </table>
    </form>
</div>

<?php
include 'INC/foot.php';
