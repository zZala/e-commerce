<?php
include("../db/connection.php");

$id = $_GET["id"];

//cerco carrello associato all'ordine
$sql = $conn->prepare("DELETE articles FROM articles WHERE Id = ?");
$sql->bind_param('i', $id);
$sql->execute();
header("location: ../my-account.php?msg=Article deleted successfully!&type=success&pag=seller");
