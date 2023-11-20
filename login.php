<?php
$title ='login';
include 'INC/head.php';
?>

<?php
if (!empty($_POST['login']) && !empty($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $user =connection($login);
    $verify = password_verify($password,$user[0]['password']);
    if (count($user) > 0 && $verify === true) {
        // user identified
        $_SESSION['login'] = $login;
        $_SESSION['iduser'] = $user[0]['iduser'];
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
    <form method="post" class="mb-3">
        <fieldset class="container">
            <div class="row justify-content-center">
                <div class="col-md-3">
                <legend>Se connecter</legend>
                <div class="form-group justify-content-center">
                    <label for="login" class="col-sm-4 col-form-label">Identifiant : </label>
                    <div>
                        <input type=text id="login" name="login" class="form-control">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="col-sm-5 col-form-label">Mot de passe : </label>
                    <div>
                    <input type=password id="password" name="password" class="form-control">
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Connexion</button>
                </div>
                </div>
            </div>
        </fieldset>
    </form>
    <?php
};

        include 'INC/foot.php';
