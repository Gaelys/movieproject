<?php

// link to DB
function linkToDb() {
    require_once '_connec.php';
    return $pdo = new \PDO(DSN, USER, PASS);
    return $pdo;
}


?>