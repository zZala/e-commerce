<?php
include("../db/connection.php");

$id = $_GET["id"];

//cerco carrello associato all'ordine
$sql = $conn->prepare("DELETE FROM payment_methods WHERE Id = ?");
$sql->bind_param('i', $id);
$sql->execute();
header("location: ../my-account.php?msg=Payment method deleted successfully!&type=success&pag=payment");
