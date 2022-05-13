<?php
include("../db/connection.php");

$id = $_POST["idArticle"];

if (isset($_POST["idArticle"]) &&  isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["conditions"]) && isset($_POST["price"]) && isset($_POST["discount"]) && isset($_POST["pieces"]) && isset($_POST["category"])) {
    $sql = $conn->prepare("SELECT Id FROM categories WHERE Type = ?");
    $sql->bind_param('s', $_POST["category"]);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $categoryId = $row["Id"];
        if (isset($_FILES["fileToUpload"]["tmp_name"]) && $_FILES["fileToUpload"]["tmp_name"] != null) {
            $target_dir = "../img/";
            $target_file = $target_dir . "product-$id.jpg";
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check === false) {
                $msg .= "File is not an image.\n";
                $uploadOk = 0;
            }

            if (file_exists($target_file)) {
                unlink($target_file);
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                $msg .= "Sorry, file already exists.\n";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg") {
                $msg .= "Sorry, only JPG files are allowed.\n";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $msg .= "Sorry, your file was not uploaded.&type=danger";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $msg .= "The file product-$id.jpg has been uploaded.&type=success";
                } else {
                    $msg .= "Sorry, there was an error uploading your file.&type=danger";
                }
            }
        }
        $sql = $conn->prepare("UPDATE articles SET Title = ?, `Description` = ?, Conditions = ?, Price = ?, Discount = ?, Pieces = ?, IdCategory = ? WHERE Id = ?");
        $sql->bind_param('sssddiii', $_POST["title"], $_POST["description"], $_POST["conditions"], $_POST["price"], $_POST["discount"], $_POST["pieces"], $categoryId, $id);
        $sql->execute();
        $msg .= "Article updated successfully!&type=success";
    }
} else {
    $msg .= "Error updating the article!&type=danger";
}
header("location:../my-account.php?pag=seller&msg=$msg");
