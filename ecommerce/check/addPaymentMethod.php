<?php
session_start();
include("../db/connection.php");
print_r($_POST);
if ($_POST["type"] == "PayPal") {
    $sql = $conn->prepare("INSERT INTO payment_methods (`Type`, Email, IdUser) VALUES (?,?,?)");
    $sql->bind_param('ssi', $_POST["type"], $_POST["email"], $_SESSION["ID"]);
    $sql->execute();
    header("location: ../my-account.php?pag=payment&msg=Payment method added successfully!&type=success");
} else if ($_POST["type"] == "Credit Card") {
    $sql = $conn->prepare("INSERT INTO payment_methods (`Type`, CardNumber, NameOnCard, ExpirationDate, IdUser) VALUES (?,?,?,?,?)");
    $sql->bind_param('ssssi', $_POST["type"], $_POST["cardNumber"], $_POST["nameOnCard"], $_POST["expirationDate"], $_SESSION["ID"]);
    $sql->execute();
    header("location: ../my-account.php?pag=payment&msg=Payment method added successfully!&type=success");
}
