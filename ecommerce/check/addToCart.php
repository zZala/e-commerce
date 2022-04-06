<?php
include("../db/connection.php");

session_start();

$idArticle = $_GET['id'];

//controllo se loggato
if (isset($_SESSION["ID"])) {
    //cerco carrello appartenente a quello user
    $sql = "SELECT Id FROM carts WHERE IdUser = '" . $_SESSION["ID"] . "'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idCart = $row["Id"];
        $sql = $conn->prepare("INSERT INTO contains (IdCart, IdArticle, Quantity) VALUES (?,?,?)");
        $sql->bind_param('iii', $idCart, $idArticle, $_GET['q']);
        $sql->execute();
        header("location:..\product-list.php?msg=Added to cart successfully!");
    } else {
        header("location:..\login.php?msg=Error!");
    }
}
