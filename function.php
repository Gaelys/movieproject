<?php

// link to DB
function linkToDb() {
    require_once '_connec.php';
    return $pdo = new \PDO(DSN, USER, PASS);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $pdo;
}

function connection($login, $password) {
    $pdo = linkToDb();
    $query  = "SELECT `login`, `password` FROM `user` WHERE BINARY `login` = :login AND BINARY `password`  = :password";
    $statement = $pdo ->prepare($query);
    $statement ->bindValue(':login', $login, \PDO::PARAM_STR);
    $statement ->bindValue(':password', $password, \PDO::PARAM_STR);
    $statement ->execute();
    $user = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $user;
}

?>