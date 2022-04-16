<?php
include("../db/connection.php");
session_start();

//check password
$password = md5($_POST["password"]);
$retypePassword = md5($_POST["retypePassword"]);
if (strcmp($password, $retypePassword) == 0) {

    //variabili inserite
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $birthDate = $_POST["birthDate"];
    $mobileNumber = $_POST["mobileNumber"];
    $email = $_POST["email"];
    $username = $_POST["username"];



    //seleziono tutti gli username presenti nel database per controllare se già presente
    $sql = "SELECT Username FROM users WHERE Id <> '" . $_SESSION["ID"] . "'";
    $result = $conn->query($sql);

    //controllo
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc())
            if ($username == $row["Username"]) {
                header("location:../my-account.php?msg=Username already used!");
                return 0;
            }
    }

    //update utente
    $sql = "UPDATE contains SET Quantity='$q' WHERE IdCart = '$idCart' AND IdArticle = '$idArticle' ";
    $conn->query($sql);
    header("location:..\cart.php?msg=Updated successfully!");

    $sql = "UPDATE users SET Username = '$username', FirstName = '$firstName', LastName = '$lastName', BirthDate = '$birthDate', MobilePhoneNumber = '$mobileNumber', Email = '$email', Password = '$password' WHERE Id = '" . $_SESSION["ID"] . "'";

    header("location:../my-account.php?msg=Updated successfully!");
} else {
    header("location:../my-account.php?msg=Password doesn't match!");
}
