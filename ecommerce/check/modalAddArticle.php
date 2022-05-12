<?php
include("../db/connection.php");

echo "  <div class='modal-dialog w-auto'>
        <div class='modal-content'>
        <div class='modal-header'>
            <h4 class='modal-title'>New Article</h4>
        </div>
        <div class='modal-body'>
        <p>
            <img class='mx-auto' style='width: 215px; height: auto; object-fit: scale-down;' src='img/product-1.jpg'>
            <button class='btn'>Change</button>
        </p>
        <div class='row'>
            <div class='col-md-3'>Title: </div>
                <div class='col-md-3'><input type='text' id='title' class='form-control w-auto'></div>
        </div>
        <div class='row'>
            <div class='col-md-3'>Description: </div>
            <div class='col-md-3'><textArea id='description' class='form-control w-auto'></textArea></div>
        </div>
        <div class='row'>
            <div class='col-md-3'>Conditions: </div>
            <div class='col-md-3'><input type='text' id='conditions'  class='form-control w-auto'></div>
        </div>
        <div class='row'>
            <div class='col-md-3'>Price: </div>
            <div class='col-md-3'><input type='number' id='price' class='form-control w-auto'></div>
        </div>
        <div class='row'>
            <div class='col-md-3'>Discount: </div>
            <div class='col-md-3'><input type='number' id='discount' class='form-control w-auto'></div>
        </div>
        <div class='row'>
            <div class='col-md-3'>Pieces: </div>
            <div class='col-md-3'><input type='number' id='pieces' class='form-control w-auto'></div>
        </div>
        <div class='row'>
            <div class='col-md-3'>Category: </div>
            <div class='col-md-3'>
                <select id='category' class='form-control w-auto'>
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


echo "  </div>
        <div class='modal-footer'>
            <button class='btn' onclick='toAddArticle()'>Save</button>
            <a href='my-account.php?pag=seller'><button type='button' class='btn btn-default'>Cancel</button></a>
        </div>
        </div>
        </div>
        <script>
        function toAddArticle() {
            $.ajax({
                url: 'check/addArticle.php',
                data: {
                    title: $('#title').val(),
                    //description: $('#description').val(),
                    conditions: $('#conditions').val(),
                    price: $('#price').val(),
                    discount: $('#discount').val(),
                    pieces: $('#pieces').val(),
                    category: $('#category').val()
                },
                success: function(msg) {
                    window.location = 'my-account.php?pag=seller&msg='+msg;
                }
            });
        }
        </script>";
