<?php
include("../db/connection.php");
session_start();

$stars = $_GET["stars"];
$title = $_GET["title"];
$id = $_GET["id"];
$text = $_GET["text"];
echo $stars;
if (isset($_SESSION["ID"])) {
    $sql = $conn->prepare("INSERT INTO reviews (IdArticle, IdUser, Title, Comment, Stars) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param('iissi', $id, $_SESSION["ID"], $title, $text, $stars);
    $sql->execute();
    header("location: ..\product-detail.php?id=$id&msg=Review added successfully!");
} else
    header("location: ..\login.php?msg=Must be logged in to post a review!");
