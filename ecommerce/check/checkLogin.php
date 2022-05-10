<?php
include("../db/connection.php");

session_start();

$usernameOrEmail = $_POST['UsernameOrEmail'];
$password = md5($_POST['PasswordLogin']);

$sql = $conn->prepare("SELECT Id, Username, Password FROM users WHERE Username = ? OR Email = ? AND Password = ?");
$sql->bind_param('sss', $usernameOrEmail, $usernameOrEmail, $password);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  //salvo session
  $_SESSION['ID'] = $row['Id'];
  $_SESSION['Username'] = $row['Username'];

  //seleziono ultimo carrello
  $sql = $conn->prepare("SELECT MAX(Id) FROM carts WHERE IdUser = ?");
  $sql->bind_param('i', $_SESSION['ID']);
  $sql->execute();
  $result = $sql->get_result();
  $row = $result->fetch_assoc();
  $_SESSION['IDCart'] = $row['MAX(Id)'];

  //seleziono unica wishlist
  $sql = $conn->prepare("SELECT Id FROM wishlists WHERE IdUser = ?");
  $sql->bind_param('i', $_SESSION['ID']);
  $sql->execute();
  $result = $sql->get_result();
  $row = $result->fetch_assoc();
  $_SESSION['IDWishlist'] = $row['Id'];

  header("location:..\index.php?msg=Logged successfully!&type=success");
} else {
  header("location:..\login.php?msg=Username and Password doesn't match!&type=danger");
}
