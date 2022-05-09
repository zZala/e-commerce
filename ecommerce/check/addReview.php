<?php
include("../db/connection.php");
session_start();

$idArticle = $_GET["id"];

if ($_GET["stars"] != 0) {
    if (isset($_SESSION["ID"])) {
        $sql = $conn->prepare("INSERT INTO reviews (IdArticle, IdUser, Title, Comment, Stars) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param('iissi', $idArticle, $_SESSION["ID"], $_GET["title"], $_GET["text"], $_GET["stars"]);
        $sql->execute();
        header("location: ..\product-detail.php?id=$idArticle&msg=Review added successfully!&type=success");
    } else
        header("location: ..\login.php?msg=Must be logged in to post a review!&type=warning");
} else {
    header("location: ..\product-detail.php?id=$idArticle&msg=Stars must be more than zero!&type=warning");
}
