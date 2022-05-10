<?php
include("../db/connection.php");

session_start();

$idArticle = $_GET['id'];
$idWishlist;

//controllo se loggato
if (isset($_SESSION["IDWishlist"])) {
    $idWishlist = $_SESSION["IDWishlist"];
} else if (isset($_SESSION["IDWishlistGuest"])) {
    $idWishlist = $_SESSION["IDWishlistGuest"];
}

if (isset($idWishlist) && isset($idArticle)) {
    //rimuovo articolo
    $sql = $conn->prepare("DELETE FROM includes WHERE IdWishlist = ? AND IdArticle = ?");
    $sql->bind_param('ii', $idWishlist, $idArticle);
    $sql->execute();
    header("location:..\wishlist.php?msg=Removed from wishlist successfully!&type=success");
} else {
    header("location:..\wishlist.php");
}
