<?php

include("../db/connection.php");

if (isset($_GET["idArticle"]) && isset($_GET["title"]) && isset($_GET["conditions"]) && isset($_GET["price"]) && isset($_GET["discount"]) && isset($_GET["pieces"]) && isset($_GET["category"])) {
    $sql = $conn->prepare("SELECT Id FROM categories WHERE Type = ?");
    $sql->bind_param('s', $_GET["category"]);
    $sql->execute();

    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $categoryId = $row["Id"];

        $sql = $conn->prepare("UPDATE articles SET Title = ?, Conditions = ?, Price = ?, Discount = ?, Pieces = ?, IdCategory = ? WHERE Id = ?");
        $sql->bind_param('ssddiii', $_GET["title"],  $_GET["conditions"], $_GET["price"], $_GET["discount"], $_GET["pieces"], $categoryId, $_GET["idArticle"]);
        $sql->execute();
        echo "Article updated successfully!&type=success";
    }
} else {
    echo "Article update error!&type=danger";
}
