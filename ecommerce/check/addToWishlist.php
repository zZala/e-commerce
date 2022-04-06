<?php
include("../db/connection.php");

session_start();

$idArticle = $_GET['id'];


//cerco la wishlist appartenente a quello user
$sql = "SELECT Id FROM wishlists WHERE IdUser = '" . $_SESSION["ID"] . "'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idWishlist = $row["Id"];
    $sql = $conn->prepare("INSERT INTO includes (IdWishlist, IdArticle, Quantity) VALUES (?,?,?)");
    $sql->bind_param('iii', $idWishlist, $idArticle, $_GET["q"]);
    $sql->execute();
    header("location:..\product-list.php?msg=Added to wishlist successfully!");
} else {
    header("location:..\login.php?msg=Error!");
}
