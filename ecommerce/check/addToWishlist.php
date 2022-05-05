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

    //prendo id wishlist creato
    $sql = "SELECT * FROM wishlists ORDER BY Id DESC LIMIT 1";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $idWishlist = $row["Id"];

    //salvo la wishlist anche nella sessione
    $_SESSION["IDWishlistGuest"] = $idWishlist;

    //creo cookie con valore idWishlist
    $cookie_name = "IDWishlistGuest";
    $cookie_value = $idWishlist;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}


if (isset($idWishlist) && isset($idArticle)) {
    //controllo se gia presente articolo in quella wishlist
    $sql = "SELECT * FROM includes WHERE IdWishlist = '$idWishlist' AND IdArticle = '$idArticle' ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        //se già presente tolgo
        $sql = $conn->prepare("DELETE FROM includes WHERE IdWishlist = '$idWishlist' AND IdArticle = '$idArticle'");
        $sql->execute();
        header("location:..\product-list.php?msg=Removed from wishlist successfully!");
    } else {
        //se no aggiungo articolo
        $sql = $conn->prepare("INSERT INTO includes (IdWishlist, IdArticle) VALUES (?,?)");
        $sql->bind_param('ii', $idWishlist, $idArticle);
        $sql->execute();
        header("location:..\product-list.php?msg=Added to wishlist successfully!");
    }
}
