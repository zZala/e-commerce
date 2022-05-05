<?php
include("../db/connection.php");
session_start();

if (!isset($_POST["check"])) {
    $address = $_POST["address"];
} else {
    $address = $_POST["addressB"];
}

$date = new DateTime('now');
$date->add(new DateInterval('P7D'));
$date = $date->format("Y-m-d");

if (isset($_POST["radio"]))
    $paymentMethod = $_POST["radio"];

if (isset($_SESSION["IDCart"]))
    $idCart = $_SESSION["IDCart"];
else if (isset($_SESSION["IDCartGuest"]))
    $idCart = $_SESSION["IDCartGuest"];
$shippingCost = 5;


if (isset($paymentMethod)) {
    $sql = $conn->prepare("INSERT INTO orders (DeliveryDate, PaymentMethod, ShippingAddress, ShippingCosts, IdCart) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param('sssii', $date, $paymentMethod, $address, $shippingCost, $idCart);
    $sql->execute();

    //trovo le quantità e gli id degli articoli acquistati
    $sql = "SELECT IdArticle, Quantity, Pieces FROM contains JOIN articles ON IdArticle = Id WHERE IdCart = $idCart";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //aggiorno le quantità disponibili nel database
            $sql = $conn->prepare("UPDATE articles SET Pieces=? WHERE Id = ?");
            $newPieces = $row["Pieces"] - $row["Quantity"];
            $sql->bind_param('ii', $newPieces, $row["IdArticle"]);
            $sql->execute();
        }
    }

    if (isset($_SESSION["IDCart"])) {
        //nuovo carrello per l'utente
        $sql = $conn->prepare("INSERT INTO carts (IdUser) VALUES (?)");
        $sql->bind_param('i', $_SESSION["ID"]);
        $sql->execute();

        //prendo id carrello creato
        $sql = "SELECT * FROM carts ORDER BY Id DESC LIMIT 1";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        //salvo nuova sessione
        $_SESSION["IDCart"] = $row["Id"];
    } else if (isset($_SESSION["IDCartGuest"])) {
        //creo nuovo carrello guest
        $sql = $conn->prepare("INSERT INTO carts () VALUES ()");
        $sql->execute();

        //prendo id carrello creato
        $sql = "SELECT * FROM carts ORDER BY Id DESC LIMIT 1";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        //salvo nuova sessione
        $_SESSION["IDCartGuest"] = $row["Id"];

        //aggiorno cookie
        $cookie_name = "IDCartGuest";
        $cookie_value = $row["Id"];
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1  
    }

    header("location: ..\cart.php?msg=Ordered successfully!");
} else
    header("location: ..\cart.php?msg=Error!");
