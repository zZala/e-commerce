<?php
include("../db/connection.php");

$idOrder = $_GET["id"];

echo "  <div class='modal-dialog'>
        <div class='modal-content'>
        <div class='modal-header'>
            <h4 class='modal-title'>Order #$idOrder</h4>
        </div>
        <div class='modal-body'>";

$sql = "SELECT articles.Id, Title, Quantity, Conditions, Seller, Price, Discount FROM ((( articles JOIN `contains` ON articles.Id = `contains`.`IdArticle`)
                                        JOIN carts ON carts.Id = `contains`.IdCart)
                                            JOIN orders ON carts.Id = orders.IdCart) WHERE orders.Id = $idOrder";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<img src='img/product-" . $row["Id"] . ".jpg'>
              <p>Title: " . $row["Title"] . "<br>
               Quantity: " . $row["Quantity"] . "<br>
               Conditions: " . $row["Conditions"] . "<br>
              Seller: " . $row["Seller"] . "<br>
               Price: " . round($row["Price"] * (100 - $row["Discount"]) / 100, 2) * $row["Quantity"] . "</p>";
    }
}

echo "  </div>
        <div class='modal-footer'>
            <a href='deleteOrder.php?id=1'><button class='btn'>Delete Order</button></a>
            <a href='my-account.php'><button type='button' class='btn btn-default'>Close</button></a>
        </div>
        </div>
        </div>";
