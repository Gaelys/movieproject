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
<a href="modify_password.php">Modifier le mot de passe</a>
<?php
echo '<form method="post">';
echo '<table>';
echo '<tr><th>Identifiant :</th><td><input type="text" name="login" value="' . $thisUser[0]['login'] . '"></td></tr>';
echo '<tr><th>Prénom : </th><td><input type="text" name="firstname" value="' . $thisUser[0]['firstname'] . '"/></td></tr>';
echo '<tr><th>Nom : </th><td><input type="text" name="lastname" value="' . $thisUser[0]['lastname'] . '"/></td></tr>';
echo '<tr><th>Date de naissance : </th><td><input type="date" name="birthdate" value="' . $thisUser[0]['birthdate'] . '"/></td></tr>';
echo '<tr><th>Email : </th><td><input type="email" name="email" value="' . $thisUser[0]['email'] . '"/></td></tr>';
echo '<tr><th>téléphone : </th><td><input type="tel" name="phone" value="' . $thisUser[0]['phone'] . '"/></td></tr>';
echo '<tr><td><input type="submit" value="Enregistrer"></td></tr>';
echo '</table>';
echo '</form>';


include 'INC/foot.php';
