<?php
include("../db/connection.php");

echo "  <div class='modal-dialog w-auto'>
        <div class='modal-content'>
        <div class='modal-header'>
            <h4 class='modal-title'>New Article</h4>
        </div>
        <div class='modal-body'>
        <form id='form' method='post' action='check/addArticle.php' enctype='multipart/form-data'>
        <p>
        Select image to upload:
            <input type='file' name='fileToUpload' id='fileToUpload' required>
        </p>
        <div class='row'>
            <div class='col-md-3'>Title: </div>
                <div class='col-md-3'><input type='text' name='title' class='form-control w-auto' required></div>
        </div>
        <div class='row'>
            <div class='col-md-3'>Description: </div>
            <div class='col-md-3'><textArea name='description' class='form-control w-auto' required></textArea></div>
        </div>
        <div class='row'>
            <div class='col-md-3'>Conditions: </div>
            <div class='col-md-3'>
                <select name='conditions' class='form-control w-auto' required>
                    <option hidden>Conditions</option>
                    <option value='New'>New</option>
                    <option value='Used'>Used</option>
                </select>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-3'>Price: </div>
            <div class='col-md-3'><input type='number' name='price' min=0 class='form-control w-auto' required></div>
        </div>
        <div class='row'>
            <div class='col-md-3'>Discount: </div>
            <div class='col-md-3'><input type='number' name='discount' min=0 class='form-control w-auto' required></div>
        </div>
        <div class='row'>
            <div class='col-md-3'>Pieces: </div>
            <div class='col-md-3'><input type='number' name='pieces' min=1 class='form-control w-auto' required></div>
        </div>
        <div class='row'>
            <div class='col-md-3'>Category: </div>
            <div class='col-md-3'>
                <select name='category' class='form-control w-auto' required>
                <option hidden>Category</option>";
$sql = $conn->prepare("SELECT * FROM categories");
$sql->execute();
$result = $sql->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $type = $row["Type"];
        echo "<option value='$type'>$type</option>";
    }
    echo "      </select>
            </div>
        </div>";
}


echo "  </form></div>
        <div class='modal-footer'>
            <button class='btn' onclick='toAddArticle()'>Add</button>
            <a href='my-account.php?pag=seller'><button type='button' class='btn btn-default'>Cancel</button></a>
        </div>
        </div>
        </div>
        <script>
        function toAddArticle() {
            $('#form').submit();
        }
        </script>";
