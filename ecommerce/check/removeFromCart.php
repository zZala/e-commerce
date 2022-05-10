<?php
include("../db/connection.php");

session_start();

$idArticle = $_GET['id'];
$idCart;

//controllo se loggato
if (isset($_SESSION["IDCart"])) {
    $idCart = $_SESSION["IDCart"];
} else if (isset($_SESSION["IDCartGuest"])) {
    $idCart = $_SESSION["IDCartGuest"];
}

if (isset($idCart) && isset($idArticle)) {
    //rimuovo articolo
    $sql = $conn->prepare("DELETE FROM contains WHERE IdCart = ? AND IdArticle = ?");
    $sql->bind_param('ii', $idCart, $idArticle);
    $sql->execute();
    header("location:..\cart.php?msg=Removed from cart successfully!&type=success");
} else
    header("location:..\cart.php");
