<?php
session_start();
include("../db/connection.php");

$idPaymentDefault = substr($_POST["paymentRadioOptions"], -1);
$idShippingDefault = substr($_POST["shippingRadioOptions"], -1);

//reset precedenti default
$sql = $conn->prepare("SELECT * FROM addresses WHERE IdUser = ? AND UserPaymentDefault = 1 OR UserShippingDefault = 1");
$sql->bind_param('i', $_SESSION["ID"]);
$sql->execute();
$result = $sql->get_result();
if ($result->num_rows > 0) {
    $sql = $conn->prepare("UPDATE addresses SET UserPaymentDefault = 0, UserShippingDefault = 0 WHERE IdUser = ? AND UserPaymentDefault = 1 ");
    $sql->bind_param('i', $_SESSION["ID"]);
    $sql->execute();
}

//imposto nuovi default
$sql = $conn->prepare("UPDATE addresses SET UserPaymentDefault = 1 WHERE IdUser = ? AND Id = ?");
$sql->bind_param('ii', $_SESSION["ID"], $idPaymentDefault);
$sql->execute();

$sql = $conn->prepare("UPDATE addresses SET UserShippingDefault = 1 WHERE IdUser = ? AND Id = ?");
$sql->bind_param('ii', $_SESSION["ID"], $idShippingDefault);
$sql->execute();

header("location:../my-account.php?pag=address&msg=Default addresses updated successfully!&type=success");
