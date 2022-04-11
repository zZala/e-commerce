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
echo $date;

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

    if (isset($_SESSION["IDCart"])) {
        //nuovo carrello per l'utente
        $sql = $conn->prepare("INSERT INTO carts (IdUser) VALUES (?)");
        $sql->bind_param('i', $_SESSION["ID"]);
        $sql->execute();
    } else if (isset($_SESSION["IDCartGuest"])) {
        //creo nuovo carrello guest
        $sql = $conn->prepare("INSERT INTO carts () VALUES ()");
        $sql->execute();

        //aggiorno cookie
        $cookie_name = "IDCartGuest";
        $cookie_value = $idCart;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1  
    }

    header("location: ..\cart.php?msg=Ordered successfully!");
} else
    header("location: ..\cart.php?msg=Error!");
