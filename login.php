<?php
$title ='login';
include 'INC/head.php';
?>

<?php
if (!empty($_POST['login']) && !empty($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $user =connection($login, $password);
    if (count($user) > 0) {
        // user identified
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;
        header('Location: index.php');
        exit();
    } else {
        echo "Ce mot de passe ou nom d'utilisateur ne correspond à aucun compte.";
    }
};
if (!empty($_SESSION['login'])) {
    echo "Vous êtes déjà connecté. Si ce n'est pas votre identifiant, déconnectez vous et reconnectez vous.";
} else {
    ?>
    <br/>
    <form method="post">
        <div>
            <label for="login">Identifiant : </label>
            <input type=text id="login" name="login">
        </div>
        <div>
            <label for="password">Mot de passe : </label>
            <input type=password id="password" name="password">
        </div>
        <div>
            <button type="submit">Soumettre</button>
        </div>
    </form>
    <?php
};

        include 'INC/foot.php';
?>