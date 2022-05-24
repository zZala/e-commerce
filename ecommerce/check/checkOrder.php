<?php
include("../db/connection.php");
session_start();

//controllo se già presenti indirizzi se no li aggiungo

//PAYMENT ADDRESS
$sql = $conn->prepare("SELECT Id FROM addresses WHERE `Address` = ? AND Country = ? AND City = ? AND Province = ? AND `ZIP Code` = ?");
$sql->bind_param('sssss', $_POST["address"], $_POST["countrySelect"], $_POST["city"], $_POST["province"], $_POST["zipCode"]);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idPaymentAddress = $row["Id"];
} else {
    //se non presente inserisco
    if (isset($_SESSION["ID"])) {
        $sql = $conn->prepare("INSERT INTO `addresses` (`Address`, `ZIP Code`, Country, City, Province, UserShippingDefault, UserPaymentDefault, IdUser) VALUES (?, ?, ?, ?, ?, 0, 0, ?)");
        $sql->bind_param('sssssi', $_POST["address"], $_POST["countrySelect"], $_POST["city"], $_POST["province"], $_POST["zipCode"], $_SESSION["ID"]);
    } else {
        $sql = $conn->prepare("INSERT INTO addresses  (`Address`, Country, City, Province, `ZIP Code`) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param('sssss', $_POST["address"], $_POST["countrySelect"], $_POST["city"], $_POST["province"], $_POST["zipCode"]);
    }
    $sql->execute();
    $idPaymentAddress = $conn->insert_id;
}


//SHIPPING ADDRESS
if (isset($_POST["check"])) {

    $sql = $conn->prepare("SELECT Id FROM addresses WHERE `Address` = ? AND Country = ? AND City = ? AND Province = ? AND `ZIP Code` = ?");
    $sql->bind_param('sssss', $_POST["addressB"], $_POST["countrySelectShip"], $_POST["cityB"], $_POST["provinceB"], $_POST["zipCodeB"]);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idShippingAddress = $row["Id"];
    } else {
        //se non presente inserisco
        if (isset($_SESSION["ID"])) {
            $sql = $conn->prepare("INSERT INTO `addresses` (`Address`, `ZIP Code`, Country, City, Province, UserShippingDefault, UserPaymentDefault, IdUser) VALUES (?, ?, ?, ?, ?, 0, 0, ?)");
            $sql->bind_param('sssssiii', $_POST["addressB"], $_POST["countrySelectShip"], $_POST["cityB"], $_POST["provinceB"], $_POST["zipCodeB"], $_SESSION["ID"]);
        } else {
            $sql = $conn->prepare("INSERT INTO addresses  (`Address`, Country, City, Province, `ZIP Code`) VALUES (?, ?, ?, ?, ?)");
            $sql->bind_param('sssss', $_POST["addressB"], $_POST["countrySelectShip"], $_POST["cityB"], $_POST["provinceB"], $_POST["zipCodeB"]);
        }
        $sql->execute();
        $idShippingAddress = $conn->insert_id;
    }
} else
    $idShippingAddress = $idPaymentAddress;


//DELIVERY DATE    
$date = new DateTime('now');
$date->add(new DateInterval('P7D'));
$date = $date->format("Y-m-d");

//PAYMENT METHOD
if (isset($_POST["radio"])) {
    if (isset($_POST["paymentAssoc"])) {
        $idPaymentMethod = $_POST["paymentAssoc"];
    } else {
        if ($_POST["radio"] == "Paypal") {
            if (isset($_SESSION["ID"])) {
                //controllo se già collegato l'indirizzo email paypal
                $sql = $conn->prepare("SELECT Id FROM payment_methods WHERE `Type` = 'Paypal' AND Email = ? AND IdUser = ?");
                $sql->bind_param('si', $_POST["emailPaypal"], $_SESSION["ID"]);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $idPaymentMethod = $row["Id"];
                } else {
                    //altrimenti aggiungo
                    $sql = $conn->prepare("INSERT INTO payment_methods(`Type`, Email, IdUser) VALUES ('Paypal',?,?)");
                    $sql->bind_param('si', $_POST["emailPaypal"], $_SESSION["ID"]);
                    $sql->execute();
                    $idPaymentMethod = $conn->insert_id;
                }
            } else {
                //guest
                $sql = $conn->prepare("INSERT INTO payment_methods(`Type`, Email) VALUES ('Paypal',?)");
                $sql->bind_param('s', $_POST["emailPaypal"]);
                $sql->execute();
                $idPaymentMethod = $conn->insert_id;
            }
        } else if ($_POST["radio"] == "Credit Card") {
            if (isset($_SESSION["ID"])) {
                //controllo se già collegato l'indirizzo email paypal
                $sql = $conn->prepare("SELECT Id FROM payment_methods WHERE `Type` = 'Credit Card' AND CardNumber = ? AND IdUser = ?");
                $sql->bind_param('si', $_POST["cardNumber"], $_SESSION["ID"]);
                $sql->execute();
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $idPaymentMethod = $row["Id"];
                } else {
                    //altrimenti aggiungo
                    $sql = $conn->prepare("INSERT INTO payment_methods(`Type`, CardNumber, NameOnCard, ExpirationDate, IdUser) VALUES ('Credit Card',?,?,?,?)");
                    $sql->bind_param('sssi', $_POST["cardNumber"], $_POST["nameOnCard"], $_POST["expirationDate"], $_SESSION["ID"]);
                    $sql->execute();
                    $idPaymentMethod = $conn->insert_id;
                }
            } else {
                //guest
                $sql = $conn->prepare("INSERT INTO payment_methods(`Type`, CardNumber, NameOnCard, ExpirationDate) VALUES ('Credit Card',?,?,?)");
                $sql->bind_param('sss', $_POST["cardNumber"], $_POST["nameOnCard"], $_POST["expirationDate"]);
                $sql->execute();
                $idPaymentMethod = $conn->insert_id;
            }
        } else {
            //Cash on delivery generico se già presente prendo id mentre in caso di prima volta lo aggiungo
            $sql = $conn->prepare("SELECT Id FROM payment_methods WHERE `Type` = 'Cash on Delivery'");
            $sql->execute();
            $result = $sql->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $idPaymentMethod = $row["Id"];
            } else {
                $sql = $conn->prepare("INSERT INTO payment_methods(`Type`) VALUES ('Cash on Delivery')");
                $sql->execute();
                $idPaymentMethod = $conn->insert_id;
            }
        }
    }
}

if (isset($_SESSION["IDCart"]))
    $idCart = $_SESSION["IDCart"];
else if (isset($_SESSION["IDCartGuest"]))
    $idCart = $_SESSION["IDCartGuest"];

$shippingCost = 5;

print_r("\n" . $idPaymentAddress . " , " . $idShippingAddress . " , " . $idPaymentMethod . " , " . $idCart);
if (isset($idPaymentAddress) && isset($idShippingAddress) && isset($idPaymentMethod) && isset($idCart)) {
    //trovo le quantità e gli id degli articoli acquistati
    $sql = $conn->prepare("SELECT IdArticle, Title, Quantity, Pieces FROM contains JOIN articles ON IdArticle = Id WHERE IdCart = ?");
    $sql->bind_param('i', $idCart);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["Pieces"] == 0) {
                header("location: ..\cart.php?msg=" . $row["Title"] . " not available!&type=danger");
                exit;
            }
            //aggiorno le quantità disponibili nel database
            $sql = $conn->prepare("UPDATE articles SET Pieces= ? WHERE Id = ?");
            $newPieces = $row["Pieces"] - $row["Quantity"];
            $sql->bind_param('ii', $newPieces, $row["IdArticle"]);
            $sql->execute();
        }
    } else {
        header("location: ..\cart.php");
        exit;
    }

    
    $sql = $conn->prepare("INSERT INTO orders (DeliveryDate, IdPaymentAddress, IdShippingAddress, IdPaymentMethod, ShippingCosts, IdCart) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->bind_param('siiiii', $date, $idPaymentAddress, $idShippingAddress, $idPaymentMethod, $shippingCost, $idCart);
    $sql->execute();
    
    if (isset($_SESSION["IDCart"])) {
        //nuovo carrello per l'utente
        $sql = $conn->prepare("INSERT INTO carts (IdUser) VALUES (?)");
        $sql->bind_param('i', $_SESSION["ID"]);
        $sql->execute();

        //ultimo id inserito
        $idNewCart = $conn->insert_id;

        //salvo nuova sessione
        $_SESSION["IDCart"] = $idNewCart;
    } else if (isset($_SESSION["IDCartGuest"])) {
        //creo nuovo carrello guest
        $sql = $conn->prepare("INSERT INTO carts () VALUES ()");
        $sql->execute();

        //ultimo id inserito
        $idNewCart = $conn->insert_id;

        //salvo nuova sessione
        $_SESSION["IDCartGuest"] = $idNewCart;

        //aggiorno cookie
        $cookie_name = "IDCartGuest";
        $cookie_value = $idNewCart;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1  
    }
    header("location: ..\cart.php?msg=Ordered successfully!&type=success");
} else
    header("location: ..\cart.php?msg=Payment method must be set!&type=warning");
