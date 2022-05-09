<?php
include("../db/connection.php");

session_start();

$idArticle = $_GET['id'];
$idWishlist;

//prendo idWishlist
if (isset($_SESSION["IDWishlist"])) {                   //se loggato
    $idWishlist = $_SESSION["IDWishlist"];
} else if (isset($_SESSION["IDWishlistGuest"])) {       //se c'è la wishlist guest con il cookie
    $idWishlist = $_SESSION["IDWishlistGuest"];
} else if (!isset($_SESSION["IDWishlistGuest"])) {      //se non c'è la wishlist guest con il cookie e non è loggato
    //creo wishlist guest
    $sql = $conn->prepare("INSERT INTO wishlists() VALUES ()");
    $sql->execute();

    //ultimo id inserito
    $idWishlist = $conn->insert_id;

    //salvo la wishlist anche nella sessione
    $_SESSION["IDWishlistGuest"] = $idWishlist;

    //creo cookie con valore idWishlist
    $cookie_name = "IDWishlistGuest";
    $cookie_value = $idWishlist;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}


if (isset($idWishlist) && isset($idArticle)) {
    //controllo se gia presente articolo in quella wishlist
    $sql = $conn->prepare("SELECT * FROM includes WHERE IdWishlist = ? AND IdArticle = ? ");
    $sql->bind_param('ii', $idWishlist, $idArticle);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        //se già presente tolgo
        $sql = $conn->prepare("DELETE FROM includes WHERE IdWishlist = ? AND IdArticle = ?");
        $sql->bind_param('ii', $idWishlist, $idArticle);
        $sql->execute();
        header("location:..\product-list.php?msg=Removed from wishlist successfully!&type=danger");
    } else {
        //se no aggiungo articolo
        $sql = $conn->prepare("INSERT INTO includes (IdWishlist, IdArticle) VALUES (?,?)");
        $sql->bind_param('ii', $idWishlist, $idArticle);
        $sql->execute();
        header("location:..\product-list.php?msg=Added to wishlist successfully!&type=success");
    }
} else
    header("location:..\product-list.php?msg=Article doesn't exist!&type=danger");
