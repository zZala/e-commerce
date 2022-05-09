<?php
include("../db/connection.php");
session_start();

//controllo quale indirizzo prendere
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
    //trovo le quantità e gli id degli articoli acquistati
    $sql = $conn->prepare("SELECT IdArticle, Title, Quantity, Pieces FROM contains JOIN articles ON IdArticle = Id WHERE IdCart = ?");
    $sql->bind_param('i', $idCart);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        echo "droga";
        while ($row = $result->fetch_assoc()) {
            if ($row["Pieces"] == 0) {
                header("location: ..\cart.php?msg=" . $row["Title"] . " not available!&type=danger");
                exit;
            }
            //aggiorno le quantità disponibili nel database
            $sql = $conn->prepare("UPDATE articles SET Pieces= ? WHERE Id = ?");
            $newPieces = $row["Pieces"] - $row["Quantity"];
            $sql->bind_param('ii', $newPieces, $row["IdArticle"]);
            $sql->execute();
        }
    } else {
        header("location: ..\cart.php");
        exit;
    }
    
    $sql = $conn->prepare("INSERT INTO orders (DeliveryDate, PaymentMethod, ShippingAddress, ShippingCosts, IdCart) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param('sssii', $date, $paymentMethod, $address, $shippingCost, $idCart);
    $sql->execute();

    if (isset($_SESSION["IDCart"])) {
        //nuovo carrello per l'utente
        $sql = $conn->prepare("INSERT INTO carts (IdUser) VALUES (?)");
        $sql->bind_param('i', $_SESSION["ID"]);
        $sql->execute();

        //ultimo id inserito
        $idNewCart = $conn->insert_id;

        //salvo nuova sessione
        $_SESSION["IDCart"] = $idNewCart;
    } else if (isset($_SESSION["IDCartGuest"])) {
        //creo nuovo carrello guest
        $sql = $conn->prepare("INSERT INTO carts () VALUES ()");
        $sql->execute();

        //ultimo id inserito
        $idNewCart = $conn->insert_id;

        //salvo nuova sessione
        $_SESSION["IDCartGuest"] = $idNewCart;

        //aggiorno cookie
        $cookie_name = "IDCartGuest";
        $cookie_value = $idNewCart;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1  
    }
    header("location: ..\cart.php?msg=Ordered successfully!&type=success");
} else
    header("location: ..\cart.php?msg=Payment method must be set!&type=warning");
