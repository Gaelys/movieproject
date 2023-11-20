<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.2/dist/lux/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
        <link rel="stylesheet" href="./styles/styles.css"/>
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <header class="essai">
            <div>
                <h1>Bienvenue chez Colosseo</h1>
                <p>La plus grande chaîne de cinéma de France.<br/>Créateur d'émotion depuis 1950</p>
            </div>
        </header>
        <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
            <div class="container-fluid">
                <h2 class="navbar-brand">Bienvenue,
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $title === 'Accueil' ? 'active' : '' ?>" href="index.php">Accueil
                            </a>
                        </li>
                        <?php if (empty($_SESSION['login'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $title === 'login' ? 'active' : '' ?>" href="login.php" >Se connecter</a>
                        </li>
                        <?php endif ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $title === 'gourmandises' ? 'active' : '' ?>" href="product.php">Nos Gourmandises</a>
                        </li>
                        <li class="nav-item">
                            <?php if (!empty($_SESSION['login'])) : ?>
                            <a class="nav-link <?php echo $title === 'Panier' ? 'active' : '' ?>" href="cart.php">Mon Panier</a>
                            <?php endif ?>
                        </li>
                        <li class="nav-item">
                            <?php if (!empty($_SESSION['login'])) : ?>
                            <a class="nav-link <?php echo $title === 'Informations du compte' ? 'active' : '' ?>" href="parametre.php">Mes informations</a>
                            <?php endif ?>
                        </li>
                        <li class="nav-item">
                            <?php if (!empty($_SESSION['login'])) : ?>
                            <a class="nav-link" href="logout.php">Se déconnecter</a>
                            <?php endif ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>