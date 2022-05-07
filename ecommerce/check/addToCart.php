<?php
include("../db/connection.php");

session_start();

$idArticle = $_GET['id'];
$idCart;

//prendo idCart
if (isset($_SESSION["IDCart"])) {                       //se loggato
    $idCart = $_SESSION["IDCart"];
} else if (isset($_SESSION["IDCartGuest"])) {           //se c'è il carrello guest con il cookie
    $idCart = $_SESSION["IDCartGuest"];
} else if (!isset($_SESSION["IDCartGuest"])) {          //se non c'è il carrello guest con il cookie e non è loggato
    //creo carrello guest
    $sql = $conn->prepare("INSERT INTO carts () VALUES ()");
    $sql->execute();

    //prendo id carrello creato
    $sql = "SELECT * FROM carts ORDER BY Id DESC LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $idCart = $row["Id"];

    //salvo il carrello anche nella sessione
    $_SESSION["IDCartGuest"] = $idCart;

    //creo cookie con valore idCart
    $cookie_name = "IDCartGuest";
    $cookie_value = $idCart;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}

//controllo se campi validi
if (isset($idCart) && isset($idArticle) && $_GET["q"] != null && $_GET["q"] != 0) {
    //controllo se gia presente articolo in quel carrello
    $sql = "SELECT Quantity FROM contains WHERE IdCart = '$idCart' AND IdArticle = '$idArticle' ";
    $result = $conn->query($sql);

    if ($result != null && $result->num_rows > 0) {
        //se già presente aggiorno la quantità
        $row = $result->fetch_assoc();
        $q = $row["Quantity"] + $_GET["q"];

        //controllo disponibilità articolo
        $sql = "SELECT Pieces FROM articles WHERE Id = $idArticle";
        $result = $conn->query($sql);
        if ($result != null && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pieces = $row["Pieces"];
            if ($pieces >= $q) {
                //aggiungo articolo
                $sql = $conn->prepare("UPDATE contains SET Quantity = '$q' WHERE IdCart = '$idCart' AND IdArticle = '$idArticle'");
                $sql->execute();
                header("location:..\product-list.php?msg=Added to cart successfully!");
            } else {
                header("location:..\product-list.php?msg=Insufficient available pieces of the article!");
            }
        }
    } else {
        //controllo disponibilità articolo
        $sql = "SELECT Pieces FROM articles WHERE Id = $idArticle";
        $result = $conn->query($sql);
        if ($result != null && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pieces = $row["Pieces"];
            if ($pieces >= $_GET["q"]) {
                //aggiungo articolo
                $sql = $conn->prepare("INSERT INTO contains (IdCart, IdArticle, Quantity) VALUES (?,?,?)");
                $sql->bind_param('iii', $idCart, $idArticle, $_GET['q']);
                $sql->execute();
                header("location:..\product-list.php?msg=Added to cart successfully!");
            } else {
                header("location:..\product-list.php?msg=Insufficient available pieces of the article!");
            }
        }
    }
} else
    header("location:..\product-list.php?msg=Article not available!");
