<?php
include("../db/connection.php");

session_start();

$usernameOrEmail = $_POST['UsernameOrEmail'];
$password = md5($_POST['PasswordLogin']);

$sql = "SELECT Id, Username, Password FROM users WHERE Username = '$usernameOrEmail' OR Email = '$usernameOrEmail' AND Password = '$password'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $_SESSION['ID'] = $row['Id'];
  $_SESSION['Username'] = $row['Username'];

  $sql = "SELECT Id FROM carts WHERE IdUser = '" . $_SESSION['ID'] . "' ORDER BY Id DESC LIMIT 1";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $_SESSION['IDCart'] = $row['Id'];

  $sql = "SELECT Id FROM wishlists WHERE IdUser = '" . $_SESSION['ID'] . "' ORDER BY Id DESC LIMIT 1";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $_SESSION['IDWishlist'] = $row['Id'];

  header("location:..\index.php?msg=Logged successfully!");
} else {
  header("location:..\login.php?msg=Username and Password doesn't match!");
}
