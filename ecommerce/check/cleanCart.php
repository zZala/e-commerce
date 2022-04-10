<?php
include("../db/connection.php");
session_start();

if (isset($_GET['msg']))
    $indirizzo = "location:..\cart.php?msg=Ordered successfully!";
else
    $indirizzo = "location:..\cart.php?msg=Clean successfully!";
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


if (isset($idCart)) {
    //elimino tutte le righe nella tabella contains di quel cart
    $sql = "DELETE contains FROM contains WHERE IdCart = '$idCart'";
    $conn->query($sql);
    header($indirizzo);
}
