<?php
session_start();
include("../db/connection.php");

if (isset($_SESSION["ID"])) {

    //se selezionati i default controllo se già presente altro indirizzo default e lo tolgo dal default
    $paymentDefault = isset($_POST['paymentDefault']) ? $_POST['paymentDefault'] : '0';
    if ($paymentDefault == 1) {
        $sql = $conn->prepare("SELECT * FROM addresses WHERE IdUser = ? AND UserPaymentDefault = 1 ");
        $sql->bind_param('i', $_SESSION["ID"]);
        $sql->execute();

        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $sql = $conn->prepare("UPDATE addresses SET UserPaymentDefault = 0 WHERE IdUser = ? AND UserPaymentDefault = 1 ");
            $sql->bind_param('i', $_SESSION["ID"]);
            $sql->execute();
        }
    }
    $shippingDefault = isset($_POST['shippingDefault']) ? $_POST['shippingDefault'] : '0';
    if ($shippingDefault == 1) {
        $sql = $conn->prepare("SELECT * FROM addresses WHERE IdUser = ? AND UserShippingDefault = 1 ");
        $sql->bind_param('i', $_SESSION["ID"]);
        $sql->execute();

        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $sql = $conn->prepare("UPDATE addresses SET UserShippingDefault = 0 WHERE IdUser = ? AND UserShippingDefault = 1 ");
            $sql->bind_param('i', $_SESSION["ID"]);
            $sql->execute();
        }
    }

    $sql = $conn->prepare("INSERT INTO addresses (`Address`, `ZIP Code`, Country, City, Province, UserShippingDefault, UserPaymentDefault, IdUser) VALUES (?,?,?,?,?,?,?,?)");
    $sql->bind_param('sssssiii', $_POST["address"], $_POST["zipCode"], $_POST["country"], $_POST["city"], $_POST["province"], $shippingDefault, $paymentDefault, $_SESSION["ID"]);
    $sql->execute();
} else {
    $sql = $conn->prepare("INSERT INTO addresses (`Address`, `ZIP Code`, Country, City, Province) VALUES (?,?,?,?,?)");
    $sql->bind_param('sssss', $_POST["address"], $_POST["zipCode"], $_POST["country"], $_POST["city"], $_POST["province"]);
    $sql->execute();
}
header("location:../my-account.php?pag=address&msg=Address added successfully!&type=success");
