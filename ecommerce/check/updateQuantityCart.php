<?php
include("../db/connection.php");

session_start();

$idArticle = $_GET['id'];
$idCart;
$q = $_GET['q'];

//controllo se loggato
if (isset($_SESSION["IDCart"])) {
    $idCart = $_SESSION["IDCart"];
} else if (isset($_SESSION["IDCartGuest"])) {
    $idCart = $_SESSION["IDCartGuest"];
}


if (isset($idCart) && isset($idArticle) && isset($_GET['q'])) {
    //aggiorno quantità
    $sql = $conn->prepare("UPDATE contains SET Quantity= ? WHERE IdCart = ? AND IdArticle = ?");
    $sql->bind_param('iii', $q, $idCart, $idArticle);
    $sql->execute();
    header("location:..\cart.php?msg=Updated successfully!&type=success");
} else {
    header("location:..\cart.php");
}
