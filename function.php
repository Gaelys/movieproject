<?php

// link to DB
function linkToDb() {
    require_once '_connec.php';
    $pdo = new \PDO(DSN, USER, PASS);
    return $pdo;
}

function connection($login) {
    $pdo = linkToDb();
    $query  = "SELECT `login`, `password`, iduser FROM `user` WHERE BINARY `login` = :login";
    $statement = $pdo ->prepare($query);
    $statement ->bindValue(':login', $login, \PDO::PARAM_STR);
    $statement ->execute();
    $user = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $user;
}

// get two field from one table
function getAll ($field1, $field2, $table) {
    $pdo = linkToDb();
    $page = $_GET['page'] ?? 1;
    $nbResultsInPage = 3;
    $offset = ($page - 1) * $nbResultsInPage;
    $query= "SELECT COUNT(idmovie, title) as total FROM movie";
    $statement = $pdo->query($query);
    $rows = $statement->fetchcolumn(0);
    $npPages = ceil($rows / $nbResultsInPage);
    $query  = "SELECT idmovie, title FROM movie LIMIT $offset ,$nbResultsInPage";
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

function getProductNameInCart($id) {
    $pdo = linkToDb();
    $query  = "SELECT snack FROM product WHERE idproduct = $id";
    $statement = $pdo->query($query);
    $productName = $statement->fetch(PDO::FETCH_ASSOC);
    return $productName; 
}

function getProductPriceInCart($id) {
    $pdo = linkToDb();
    $query  = "SELECT price FROM product WHERE idproduct = $id";
    $statement = $pdo->query($query);
    $productPrice = $statement->fetch(PDO::FETCH_ASSOC);
    return $productPrice; 
}

function getSession($id) {
    $pdo = linkToDb();
    $query  = "SELECT `session`, date_movie, room, seatAvai, idmovie_session, seats  FROM movie_session as m JOIN `session`  as s ON m.idsession = s.idsession 
    JOIN date_of as d ON m.iddate_of = d.iddate_of 
    JOIN room as r ON r.idroom = m.idroom where idmovie = $id AND seatAvai > 0 AND end_session > NOW()";
    $statement = $pdo->query($query);
    $show = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $show;
}

function getRoomSeatDetail($id) {
    $pdo = linkToDb();
    $query  = "SELECT `session`, date_movie, room, seatAvai,idmovie_session, seats  FROM movie_session as m JOIN `session`  as s ON m.idsession = s.idsession 
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
function getMovieInCart($id) {
    $pdo = linkToDb();
    $query  = "SELECT title, `session`,date_movie FROM movie_session as ms JOIN movie ON ms.idmovie=movie.idmovie 
    JOIN `session` as s ON s.idsession = ms.idsession
    JOIN date_of as d ON d.iddate_of=ms.iddate_of  where idmovie_session = $id;";
    $statement = $pdo->query($query);
    $movieInCart = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $movieInCart;
}

function getCart($id) {
    $pdo = linkToDb();
    $query = "SELECT * FROM cart WHERE iduser = $id";
    $statement = $pdo->query($query);
    $getCart = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $getCart;

}

// get two field from one table
function getTitleFromMovie($id) {
    $pdo = linkToDb();
    $query  = "SELECT title FROM movie WHERE idmovie = $id";
    $statement = $pdo->query($query);
    $getTitleFromMovie = $statement->fetch(PDO::FETCH_ASSOC);
    return $getTitleFromMovie;
}

function getPricesession($id) {
    $pdo = linkToDb();
    $query  = "SELECT p.price, p.idprice FROM price as p JOIN cart as c ON c.idprice=p.idprice WHERE idcart = $id";
    $statement = $pdo->query($query);
    $getPrice = $statement->fetch(PDO::FETCH_ASSOC);
    return $getPrice;
}

function getPCart($id, $idproduct) {
    $pdo = linkToDb();
    $query = "SELECT quantity, price, idcart FROM cart WHERE iduser = $id AND idproduct = $idproduct ";
    $statement = $pdo->query($query);
    $getCart = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $getCart;

}

function getSpeCart($id) {
    $pdo = linkToDb();
    $query = "SELECT idproduct FROM cart WHERE iduser = $id";
    $statement = $pdo->query($query);
    $getCart = $statement->fetchAll(PDO::FETCH_COLUMN);
    return $getCart;
}

function getMyBookings($id) {
    $pdo = linkToDb();
    $query = "SELECT * FROM order_cine WHERE iduser = $id AND date_end >= NOW() ORDER BY create_At ASC";
    $statement = $pdo->query($query);
    $getMyBookings = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $getMyBookings;
}

function getMyOldBookings($id) {
    $pdo = linkToDb();
    $query = "SELECT * FROM order_cine WHERE iduser = $id AND date_end < NOW() ORDER BY create_At DESC";
    $statement = $pdo->query($query);
    $getOldBookings = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $getOldBookings;
}

function minusCart($iduser, $idproduct) {
    $pdo = linkToDb();
    $query = "SELECT quantity FROM cart WHERE iduser = $iduser AND idproduct = $idproduct";
    $statement = $pdo->query($query);
    $getItem = $statement->fetch(PDO::FETCH_ASSOC);
    return $getItem;
}

function minusInsertInC($iduser, $quantity, $idproduct) {
    $pdo = linkToDb();
    $query = "UPDATE cart SET `quantity` = :quantity  WHERE iduser = $iduser AND idproduct = :idproduct ";
    $statement = $pdo ->prepare($query);
    $statement ->bindValue(':quantity', $quantity, \PDO::PARAM_INT);
    $statement ->bindValue(':idproduct', $idproduct, \PDO::PARAM_INT);
    $statement ->execute();
}

function deleteFromC($iduser, $idproduct) {
    $pdo = linkToDb();
    $query = "DELETE FROM cart  WHERE iduser = $iduser AND idproduct = :idproduct ";
    $statement = $pdo ->prepare($query);
    $statement ->bindValue(':idproduct', $idproduct, \PDO::PARAM_INT);
    $statement ->execute();
}

function deleteAllFromCart($idcall, $idproduct, $iduser) {
    $pdo = linkToDb();
    $query = "DELETE FROM cart  WHERE iduser = $iduser AND idproduct = $idcall ";
    $statement = $pdo ->prepare($query);
    $statement ->bindValue($idcall, $idproduct, \PDO::PARAM_INT);
    $statement ->execute();
}

function deleteMovieInCartWithPrice($iduser, $idproduct, $idprice) {
    $pdo = linkToDb();
    $query = "DELETE FROM cart WHERE iduser = $iduser AND idmovie = $idproduct AND idprice = $idprice";
    $statement = $pdo ->exec($query);
}

function getMoviePrice($idprice) {
    $pdo = linkToDb();
    $query = "SELECT infos FROM price WHERE idprice = $idprice ";
    $statement = $pdo->query($query);
    $getInfos = $statement->fetch(PDO::FETCH_ASSOC);
    return $getInfos;
}

function getListMovieInPrice($idmovie, $idprice, $iduser) {
    $pdo = linkToDb();
    $query = "SELECT quantity FROM cart WHERE idmovie = $idmovie AND idprice = $idprice AND iduser = $iduser";
    $statement = $pdo->query($query);
    $getList = $statement->fetch(PDO::FETCH_ASSOC);
    return $getList;
}

function getLastNum_order() {
    $pdo = linkToDb();
    $query = "SELECT num_order FROM order_cine ORDER BY id_order_cine DESC LIMIT 1";
    $statement = $pdo->query($query);
    $getLast = $statement->fetch(PDO::FETCH_ASSOC);
    return $getLast;
}

function verifySeatAvai($id) {
    $pdo = linkToDb();
    $query = "SELECT seatAvai FROM movie_session WHERE idmovie_session = $id";
    $statement = $pdo->query($query);
    $verifySeat = $statement->fetch(PDO::FETCH_ASSOC);
    return $verifySeat;   
}

function resetSeat($seatAvai, $idmovie_session) {
    $pdo = linkToDb();
    $query = "UPDATE movie_session SET seatAvai = :seatAvai WHERE idmovie_session = :idmovie_session";
    $statement = $pdo ->prepare($query);
    $statement ->bindValue(':seatAvai', $seatAvai, \PDO::PARAM_INT);
    $statement ->bindValue(':idmovie_session', $idmovie_session, \PDO::PARAM_INT);
    $statement ->execute();
}