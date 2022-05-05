<?php
include("../db/connection.php");

$id = $_GET["id"];



//cerco carrello associato all'ordine
$sql = "SELECT IdCart FROM orders WHERE Id = $id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idCart = $row["IdCart"];
    
    //trovo le quantità e gli id degli articoli acquistati
    $sql = "SELECT IdArticle, Quantity, Pieces FROM contains JOIN articles ON IdArticle = Id WHERE IdCart = $idCart";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //riaggiungo le quantità disponibili nel database
            $sql = $conn->prepare("UPDATE articles SET Pieces=? WHERE Id = ?");
            $newPieces = $row["Pieces"] + $row["Quantity"];
            $sql->bind_param('ii', $newPieces, $row["IdArticle"]);
            $sql->execute();
        }
    }

    $sql = $conn->prepare("DELETE FROM carts WHERE Id = $idCart");
    $sql->execute();
    header("location: ../my-account.php?msg=Order deleted successfully!");
} else
    header("location: ../my-account.php");
