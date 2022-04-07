<?php
include("../db/connection.php");

session_start();

$idArticle = $_GET['id'];
$idWishlist;

//controllo se loggato
if (isset($_SESSION["ID"])) {

    //cerco wishlist appartenente a quel user
    $sql = "SELECT Id FROM wishlists WHERE IdUser = '" . $_SESSION["ID"] . "'";
    $result = $conn->query($sql);

    //salvo wishlist in sessione e nella variabile idWishlist a cui aggiungo l'articolo sotto
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["IDWishlist"] = $row["Id"];
        $idWishlist = $row["Id"];
    }
} else if (isset($_SESSION["IDWishlistGuest"])) {
    $idWishlist = $_SESSION["IDWishlistGuest"];
}


if (isset($idWishlist) && isset($idArticle)) {
    //controllo se gia presente articolo in quella wishlist
    $sql = "DELETE FROM includes WHERE IdWishlist = '$idWishlist' AND IdArticle = '$idArticle' ";
    $conn->query($sql);
    header("location:..\wishlist.php?msg=Removed from wishlist successfully!");
}
