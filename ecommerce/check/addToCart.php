<?php
include("../db/connection.php");

session_start();

$idArticle = $_GET['id'];
$idCart;

//controllo se loggato
if (isset($_SESSION["ID"])) {

    //cerco carrello appartenente a quel user
    $sql = "SELECT Id FROM carts WHERE IdUser = '" . $_SESSION["ID"] . "'";
    $result = $conn->query($sql);

    //salvo carrello in sessione e nella variabile idCart a cui aggiungo l'articolo sotto
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["IDcart"] = $row["Id"];
        $idCart = $row["Id"];
    }
} else if (isset($_SESSION["IDCartGuest"])) {
    $idCart = $_SESSION["IDCartGuest"];
} else if (!isset($_SESSION["IDCartGuest"])) {
    if (isset($_COOKIE["IDCartGuest"])) {
        $idCart = $_COOKIE["IDCartGuest"];
        $_SESSION["IDCartGuest"] = $idCart;
    } else {
        echo "Cookie '" . $cookie_name . "' is set!<br>";
        echo "Value is: " . $_COOKIE[$cookie_name];

        //creo carrello guest
        $sql = $conn->prepare("INSERT INTO carts () VALUES ()");
        $sql->execute();

        //prendo id carrello creato
        $sql = "SELECT * FROM carts ORDER BY Id DESC LIMIT 1";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $idCart = $row["Id"];
        //salvo il carrello anche nella sessione OTTIMIZZAZIONE
        $_SESSION["IDCartGuest"] = $idCart;

        //creo cookie con valore idCart
        $cookie_name = "IDCartGuest";
        $cookie_value = $idCart;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
    }
}


if (isset($idCart) && isset($idArticle) && $_GET["q"] != null) {
    //controllo se gia presente articolo in quel carrello
    $sql = "SELECT Quantity FROM contains WHERE IdCart = '$idCart' AND IdArticle = '$idArticle' ";
    $result = $conn->query($sql);

    //salvo carrello in sessione e nella variabile idCart a cui aggiungo l'articolo sotto
    if ($result != null && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $q = $row["Quantity"] + $_GET["q"];
        $sql = $conn->prepare("UPDATE Quantity SET Quantity = '$q' WHERE IdCart = '$idCart' AND IdArticle = '$idArticle'");
        $sql->execute();
    } else {
        //aggiungo articolo
        $sql = $conn->prepare("INSERT INTO contains (IdCart, IdArticle, Quantity) VALUES (?,?,?)");
        $sql->bind_param('iii', $idCart, $idArticle, $_GET['q']);
        $sql->execute();
    }
    header("location:..\product-list.php?msg=Added to cart successfully!");
}
