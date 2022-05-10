<?php
include("../db/connection.php");

$id = $_GET["id"];

//cerco carrello associato all'ordine
$sql = $conn->prepare("SELECT IdCart FROM orders WHERE Id = ?");
$sql->bind_param('i', $id);
$sql->execute();
$result = $sql->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idCart = $row["IdCart"];

    //trovo le quantità e gli id degli articoli acquistati
    $sql = $conn->prepare("SELECT IdArticle, Quantity, Pieces FROM contains JOIN articles ON IdArticle = Id WHERE IdCart = ?");
    $sql->bind_param('i', $idCart);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //riaggiungo le quantità disponibili nel database
            $sql = $conn->prepare("UPDATE articles SET Pieces= ? WHERE Id = ?");
            $newPieces = $row["Pieces"] + $row["Quantity"];
            $sql->bind_param('ii', $newPieces, $row["IdArticle"]);
            $sql->execute();
        }
    }
    $sql = $conn->prepare("DELETE FROM carts WHERE Id = ?");
    $sql->bind_param('i', $idCart);
    $sql->execute();
    header("location: ../my-account.php?msg=Order deleted successfully!&type=success");
} else
    header("location: ../my-account.php");
