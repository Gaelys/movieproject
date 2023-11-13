<?php
session_start();
?>
<nav>
    <div>
        <a href="index.php">Accueil</a>
    </div>
    <div>
        <?php
        if (!empty($_SESSION['login'])) {
            echo '<a href="logout.php">logout</a>';
        };
        ?>