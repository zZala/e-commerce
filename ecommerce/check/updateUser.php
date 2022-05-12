<?php
include("../db/connection.php");
session_start();

//check password
$password = md5($_POST["password"]);
$retypePassword = md5($_POST["retypePassword"]);
if ($_POST["password"] != "") {
    if (strcmp($password, $retypePassword) == 0) {

        //variabili inserite
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $birthDate = $_POST["birthDate"];
        $mobileNumber = $_POST["mobileNumber"];
        $email = $_POST["email"];
        $username = $_POST["username"];

        //seleziono tutti gli username presenti nel database per controllare se già presente
        $sql = $conn->prepare("SELECT Username FROM users WHERE Id <> ?");
        $sql->bind_param('i', $_SESSION["ID"]);
        $sql->execute();
        $result = $sql->get_result();

        //controllo
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc())
                if ($username == $row["Username"]) {
                    header("location:../my-account.php?msg=Username already used!&type=warning");
                    return 0;
                }
        }

        //update utente
        $sql = $conn->prepare("UPDATE users SET Username = ?, FirstName = ?, LastName = ?, BirthDate = ?, MobilePhoneNumber = ?, Email = ?, Password = ? WHERE Id = ?");
        $sql->bind_param('sssdsssi', $username, $firstName, $lastName, $birthDate, $mobileNumber, $email, $password, $_SESSION["ID"]);
        $sql->execute();

        header("location:../my-account.php?msg=Updated successfully!&type=success");
    } else {
        header("location:../my-account.php?msg=Password does not match!&type=danger");
    }
} else
    header("location:../my-account.php?msg=Password must not be empty!&type=danger");
