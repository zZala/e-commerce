<?php
include("../db/connection.php");

session_start();

$usernameOrEmail = $_POST['UsernameOrEmail'];
$password = md5($_POST['PasswordLogin']);

$sql = "SELECT Id, Username, Password FROM users WHERE Username = '$usernameOrEmail' OR Email = '$usernameOrEmail' AND Password = '$password'";

$result = $conn->query($sql);
$conn->close();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $_SESSION['ID'] = $row['Id'];
  header("location:..\index.php?msg=Logged successfully!");
} else {
  header("location:..\login.php?msg=Username and Password doesn't match!");
}
