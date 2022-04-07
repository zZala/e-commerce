<?php
include("../db/connection.php");

session_start();

$idArticle = $_GET['id'];
$idCart;

//controllo se loggato
if (isset($_SESSION["ID"])) {

    //cerco cart appartenente a quel user
    $sql = "SELECT Id FROM carts WHERE IdUser = '" . $_SESSION["ID"] . "'";
    $result = $conn->query($sql);

    //salvo cart in sessione e nella variabile idCart a cui aggiungo l'articolo sotto
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["IDCart"] = $row["Id"];
        $idCart = $row["Id"];
    }
} else if (isset($_SESSION["IDCartGuest"])) {
    $idCart = $_SESSION["IDCartGuest"];
}


if (isset($idCart) && isset($idArticle)) {
    //controllo se gia presente articolo in quella cart
    $sql = "DELETE FROM contains WHERE IdCart = '$idCart' AND IdArticle = '$idArticle' ";
    $conn->query($sql);
    header("location:..\cart.php?msg=Removed from cart successfully!");
}
