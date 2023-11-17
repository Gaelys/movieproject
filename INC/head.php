<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.2/dist/lux/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
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
                <h2>Bienvenue,
                <?php
                session_start();
                include "function.php";
                if (isset ($_SESSION['login'])) {
                    echo "\"" . $_SESSION['login'] . "\"";
                } else {
                    echo " cher cinéphile.";
                }
                ?>
                </h2>
            </div>
            <div>
                <a href="index.php">Accueil</a> - 
                <a href="login.php">Login</a> -
                <a href="product.php">Gourmandises</a> -
                    
                <?php
                if (!empty($_SESSION['login'])) {
                    echo ' <a href="cart.php">Panier</a> -';
                    echo ' <a href="parametre.php">Informations du compte</a> -';
                    echo ' <a href="logout.php">logout</a>';
                };
                ?>
            </div>
        </nav>