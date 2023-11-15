<?php

// link to DB
function linkToDb() {
    require_once '_connec.php';
    $pdo = new \PDO(DSN, USER, PASS);
    return $pdo;
}

function connection($login, $password) {
    $pdo = linkToDb();
    $query  = "SELECT `login`, `password`, iduser FROM `user` WHERE BINARY `login` = :login AND BINARY `password`  = :password";
    $statement = $pdo ->prepare($query);
    $statement ->bindValue(':login', $login, \PDO::PARAM_STR);
    $statement ->bindValue(':password', $password, \PDO::PARAM_STR);
    $statement ->execute();
    $user = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $user;
}

// get two field from one table
function getAll ($field1, $field2, $table) {
    $pdo = linkToDb();
    $query  = "SELECT $field1, $field2 FROM $table";
    $statement = $pdo->query($query);
    $allFromOne = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $allFromOne;
}

// select info of two table with join (foreign key)
function getInfo ($table, $table2, $foreignkey, $id, $identifiant) {
    $pdo = linkToDb();
    $query  = "SELECT * FROM $table JOIN $table2 ON $table.$foreignkey = $table2.$foreignkey WHERE $id = $identifiant";
    $statement = $pdo->query($query);
    $all = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $all;
}

//select all from user table
function getUserInfo ($id) {
    $pdo = linkToDb();
    $query  = "SELECT * FROM user WHERE iduser = $id";
    $statement = $pdo->query($query);
    $userInfo = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $userInfo; 
}

//update user table except password
function modifyInfoUser ($login, $firstname, $lastname, $birthdate, $email, $phone, $id) {
    $pdo = linkToDb();
    $query  = "UPDATE user SET `login` = :login, firstname = :firstname, lastname = :lastname, birthdate = :birthdate, email = :email, phone = :phone  WHERE iduser = $id";
    $statement = $pdo ->prepare($query);
    $statement ->bindValue(':login', $login, \PDO::PARAM_STR);
    $statement ->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
    $statement ->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
    $statement ->bindValue(':birthdate', $birthdate, \PDO::PARAM_STR);
    $statement ->bindValue(':email', $email, \PDO::PARAM_STR);
    $statement ->bindValue(':phone', $phone, \PDO::PARAM_STR);
    $statement ->execute();
}

function updatePassword($password, $id) {
    $pdo = linkToDb();
    $query  = "UPDATE user SET `password` = :password  WHERE iduser = $id";
    $statement = $pdo ->prepare($query);
    $statement ->bindValue(':password', $password, \PDO::PARAM_STR);
    $statement ->execute();
}

// get two field from one table
function getAllFromProduct ($field, $table) {
    $pdo = linkToDb();
    $query  = "SELECT $field FROM $table";
    $statement = $pdo->query($query);
    $allFromProduct = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $allFromProduct;
}

//select all from user table
function getProductInfo ($id) {
    $pdo = linkToDb();
    $query  = "SELECT * FROM product WHERE idproduct = $id";
    $statement = $pdo->query($query);
    $productInfo = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $productInfo; 
}

function getProductInCart($id) {
    $pdo = linkToDb();
    $query  = "SELECT snack, price FROM product WHERE idproduct = $id";
    $statement = $pdo->query($query);
    $productName = $statement->fetch(PDO::FETCH_ASSOC);
    return $productName; 
}

function getSession($id) {
    $pdo = linkToDb();
    $query  = "SELECT `session`, date_movie, room, seatTaken, idmovie_session, seats  FROM movie_session as m JOIN `session`  as s ON m.idsession = s.idsession 
    JOIN date_of as d ON m.iddate_of = d.iddate_of 
    JOIN room as r ON r.idroom = m.idroom where idmovie = $id AND seatTaken < seats; ";
    $statement = $pdo->query($query);
    $show = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $show;
}

function getRoomSeatDetail($id) {
    $pdo = linkToDb();
    $query  = "SELECT `session`, date_movie, room, seatTaken, seats  FROM movie_session as m JOIN `session`  as s ON m.idsession = s.idsession 
    JOIN date_of as d ON m.iddate_of = d.iddate_of 
    JOIN room as r ON r.idroom = m.idroom where idmovie_session = $id";
    $statement = $pdo->query($query);
    $roomChoice = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $roomChoice;
}

function getPrices () {
    $pdo = linkToDb();
    $query  = "SELECT * FROM price";
    $statement = $pdo->query($query);
    $getPrices = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $getPrices;
}