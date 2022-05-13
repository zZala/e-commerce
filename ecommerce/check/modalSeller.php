<?php
include("../db/connection.php");

$idArticle = $_GET["id"];

echo "  <div class='modal-dialog w-auto'>
        <div class='modal-content'>
        <div class='modal-header'>
            <h4 class='modal-title'>Article #$idArticle</h4>
        </div>
        <div class='modal-body'>
        <form id='form' method='post' action='check/updateArticle.php' enctype='multipart/form-data'>";

$sql = $conn->prepare("SELECT * FROM articles JOIN categories ON articles.IdCategory = categories.Id WHERE articles.Id = ?");
$sql->bind_param('i', $idArticle);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "  <input type='hidden' name='idArticle' value='$idArticle'>
            <p>
                <img class='mx-auto' style='width: 215px; height: auto; object-fit: scale-down;' src='img/product-" . $idArticle . ".jpg'>
                <input type='file' name='fileToUpload' id='fileToUpload' required>
            </p>
            <div class='row'>
            <div class='col-md-3'>Title: </div>
            <div class='col-md-3'><input type='text' name='title' value='" . $row["Title"] . "' class='form-control w-auto' required></div>
            </div>
            <div class='row'>
            <div class='col-md-3'>Description: </div>
            <div class='col-md-3'><textArea name='description' class='form-control w-auto' required>" . $row["Description"] . "</textArea></div>
            </div>
            <div class='row'>
            <div class='col-md-3'>Conditions: </div>
            <div class='col-md-3'>
                <select name='conditions' class='form-control w-auto' required>";
    if ($row["Conditions"] == "New")
        echo "  <option value='New' selected>New</option>
                <option value='Used'>Used</option>";
    else
        echo "  <option value='New' >New</option>
                <option value='Used' selected>Used</option>";
    echo   "</select>
            </div>
            </div>
            <div class='row'>
            <div class='col-md-3'>Price: </div>
            <div class='col-md-3'><input type='number' name='price' value='" . $row["Price"] . "' class='form-control w-auto' required></div>
            </div>
            <div class='row'>
            <div class='col-md-3'>Discount: </div>
            <div class='col-md-3'><input type='number' name='discount' value='" . $row["Discount"] . "' class='form-control w-auto' required></div>
            </div>
            <div class='row'>
            <div class='col-md-3'>Pieces: </div>
            <div class='col-md-3'><input type='number' name='pieces' value='" . $row["Pieces"] . "' class='form-control w-auto' required></div>
            </div>
            <div class='row'>
            <div class='col-md-3'>Category: </div>
            <div class='col-md-3'>
                <select name='category' class='form-control w-auto' required>
                <option selected value='" . $row["Type"] . "'>" . $row["Type"] . "</option>";
    $sql = $conn->prepare("SELECT * FROM categories WHERE Type <> ?");
    $sql->bind_param('s', $row["Type"]);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $type = $row["Type"];
            echo "<option value='$type'>$type</option>";
        }
        echo "</select>
            </div>
            </div>";
    }
}

echo "  </form>
        </div>
        <div class='modal-footer'>
            <button class='btn' onclick='toUpdateArticle()'>Save</button>
            <a href='my-account.php?pag=seller'><button type='button' class='btn btn-default'>Cancel</button></a>
        </div>
        </div>
        </div>
        <script>
        function toUpdateArticle() {
            $('#form').submit();
        }
        </script>";
