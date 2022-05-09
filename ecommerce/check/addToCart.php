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

    //ultimo id inserito
    $idCart = $conn->insert_id;

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
    $sql = $conn->prepare("SELECT Quantity FROM contains WHERE IdCart = ? AND IdArticle = ?");
    $sql->bind_param('ii', $idCart, $idArticle);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        //se già presente aggiorno la quantità
        $row = $result->fetch_assoc();
        $newQuantity = $row["Quantity"] + $_GET["q"];

        //controllo disponibilità articolo
        $sql = $conn->prepare("SELECT Pieces FROM articles WHERE Id = ?");
        $sql->bind_param('i', $idArticle);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row["Pieces"] >= $newQuantity) {
                //aggiorno quantità articolo
                $sql = $conn->prepare("UPDATE contains SET Quantity = ? WHERE IdCart = ? AND IdArticle = ?");
                $sql->bind_param("iii", $newQuantity, $idCart, $idArticle);
                $sql->execute();
                header("location:..\product-list.php?msg=Added to cart successfully!&type=success");
            } else {
                header("location:..\product-list.php?msg=Insufficient available pieces of the article!&type=danger");
            }
        } else
            header("location:..\product-list.php?msg=Article doesn't exist!&type=danger");
    } else {
        //controllo disponibilità articolo
        $sql = $conn->prepare("SELECT Pieces FROM articles WHERE Id = ?");
        $sql->bind_param('i', $idArticle);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row["Pieces"] >= $_GET["q"]) {
                //aggiungo articolo
                $sql = $conn->prepare("INSERT INTO contains (IdCart, IdArticle, Quantity) VALUES (?,?,?)");
                $sql->bind_param('iii', $idCart, $idArticle, $_GET['q']);
                $sql->execute();
                header("location:..\product-list.php?msg=Added to cart successfully!&type=success");
            } else {
                header("location:..\product-list.php?msg=Insufficient available pieces of the article!&type=danger");
            }
        } else
            header("location:..\product-list.php?msg=Article doesn't exist!&type=danger");
    }
} else
    header("location:..\product-list.php?msg=Article not available!&type=danger");
