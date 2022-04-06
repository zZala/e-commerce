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
} else if (!isset($_SESSION["IDWishlistGuest"])) {
    if (isset($_COOKIE["IDWishlistGuest"])) {
        $idCart = $_COOKIE["IDWishlistGuest"];
        echo $idCart;
        $_SESSION["IDWishlistGuest"] = $idCart;
    } else {
        //creo wishlist guest
        $sql = $conn->prepare("INSERT INTO wishlists() VALUES ()");
        $sql->execute();

        //prendo id wishlist creato
        $sql = "SELECT * FROM wishlists ORDER BY Id DESC LIMIT 1";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $idWishlist = $row["Id"];
        //salvo la wishlist anche nella sessione OTTIMIZZAZIONE
        $_SESSION["IDWishlistGuest"] = $idWishlist;

        //creo cookie con valore idWishlist
        $cookie_name = "IDWishlistGuest";
        $cookie_value = $idWishlist;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
    }
}


if (isset($idWishlist) && isset($idArticle)) {
    //controllo se gia presente articolo in quella wishlist
    $sql = "SELECT * FROM includes WHERE IdWishlist = '$idWishlist' AND IdArticle = '$idArticle' ";
    $result = $conn->query($sql);
    //salvo wishlist in sessione e nella variabile idWishlist a cui aggiungo l'articolo sotto
    if ($result->num_rows > 0) {
        $sql = $conn->prepare("DELETE FROM includes WHERE IdWishlist = '$idWishlist' AND IdArticle = '$idArticle'");
        $sql->execute();
        header("location:..\product-list.php?msg=Removed from wishlist successfully!");
    } else {
        //aggiungo articolo
        $sql = $conn->prepare("INSERT INTO includes (IdWishlist, IdArticle) VALUES (?,?)");
        $sql->bind_param('ii', $idWishlist, $idArticle);
        $sql->execute();
        header("location:..\product-list.php?msg=Added to wishlist successfully!");
    }
}


function console_log($data)
{
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ')';
    echo '</script>';
}
