<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <header>
            <h1>Bienvenue chez Colosseo</h1>
            <p>La plus grande chaîne de cinéma de France.<br/>Créateur d'émotion depuis 1950</p>
        </header>
        <nav>
            <?php
            ?>
            <div>
                Bienvenue,
                <?php
                session_start();
                include "function.php";
                if (isset ($_SESSION['login'])) {
                    echo "\"" . $_SESSION['login'] . "\"";
                } else {
                    echo " cher cinéphile.";
                }
                ?>
            </div>
            <div>
                <a href="index.php">Accueil</a> - 
                <a href="login.php">Login</a> -
                <a href="product.php">Gourmandises</a> -
                    
                <?php
                if (!empty($_SESSION['login'])) {
                    echo ' <a href="cart.php">Panier</a> -';
                    echo ' <a href="parametre.php">Paramètres du compte</a> -';
                    echo ' <a href="logout.php">logout</a>';
                };
                ?>
            </div>
        </nav>