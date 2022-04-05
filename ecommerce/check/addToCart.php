<?php
include("../db/connection.php");

session_start();

$idArticle = $_GET['id'];

$sql = "SELECT Id FROM carts WHERE IdUser = '" . $_SESSION["ID"] . "'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $idCart = $result->fetch_assoc();

    $sql = $conn->prepare("INSERT INTO contains (IdArticle, IdCart, Quantity) VALUES (?,?,?)");
    $sql->bind_param('iii', $idArticle, $idCart, $_GET['q']);
    $sql->execute();
    header("location:..\product-list.php?msg=Added to cart successfully!");
} else {
    header("location:..\login.php?msg=Error!");
}
