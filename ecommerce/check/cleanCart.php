<?php
include("../db/connection.php");
session_start();

$idCart;

//controllo se loggato
if (isset($_SESSION["IDCart"])) {
    $idCart = $_SESSION["IDCart"];
} else if (isset($_SESSION["IDCartGuest"])) {
    $idCart = $_SESSION["IDCartGuest"];
}

if (isset($idCart)) {
    //elimino tutte le righe nella tabella contains di quel cart
    $sql = $conn->prepare("DELETE contains FROM contains WHERE IdCart = ?");
    $sql->bind_param('i', $idCart);
    $sql->execute();
    header("location:..\cart.php?msg=Clean successfully!&type=success");
} else
    header("location:..\cart.php");
