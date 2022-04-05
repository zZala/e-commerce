<?php
include("../db/connection.php");

//check password
$password = md5($_POST["Password"]);
$retypePassword = md5($_POST["RetypePassword"]);
if (strcmp($password, $retypePassword) == 0) {

  //variabili inserite
  $firstName = $_POST["FirstName"];
  $lastName = $_POST["LastName"];
  $birthDate = $_POST["BirthDate"];
  $mobileNumber = $_POST["MobileNumber"];
  $email = $_POST["E-mail"];
  $username = $_POST["Username"];



  //seleziono tutti gli username presenti nel database per controllare se già presente
  $sql = "SELECT Username FROM users";
  $result = $conn->query($sql);

  //controllo
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc())
      if ($username == $row["Username"]) {
        header("location:../login.php?msg=Username already used!");
        return 0;
      }
  }

  //nuovo utente
  $sql = $conn->prepare("INSERT INTO users (FirstName, LastName, BirthDate, Username, Email, MobilePhoneNumber, Password) VALUES (?,?,?,?,?,?,?)");
  $sql->bind_param('sssssss', $firstName, $lastName, $birthDate, $username, $email, $mobileNumber, $password);
  if ($sql->execute() === true) {
    //se creato correttamente l'utente creo un suo carrello tramite l'id
    $sql = "SELECT Id FROM users WHERE Username = '$username'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $id = $row["Id"];

    $sql = $conn->prepare("INSERT INTO carts (IdUser) VALUES (?)");
    $sql->bind_param('i', $id);
    $sql->execute();

    $sql = $conn->prepare("INSERT INTO wishlists (IdUser) VALUES (?)");
    $sql->bind_param('i', $id);
    $sql->execute();
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  header("location:../login.php?msg=Registered successfully!");
} else {
  header("location:../login.php?msg=Password doesn't match!");
}
