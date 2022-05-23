<?php
include("db/connection.php");
session_start();

if (isset($_GET['seller']) && $_GET['seller'] == 1) {
    //FARE CONTROLLO CARTE
    $sql = $conn->prepare("UPDATE users SET Seller = ? WHERE Id = ?");
    $sql->bind_param('ii', $_GET["seller"], $_SESSION["ID"]);
    $sql->execute();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>My Account</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/slick/slick.css" rel="stylesheet">
    <link href="lib/slick/slick-theme.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">


</head>

<body>
    <!-- Top bar Start -->
    <div class="top-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <i class="fa fa-envelope"></i>
                    <a href="mailto:E-StoreIT@gmail.com">E-StoreIT@gmail.com</a>
                </div>
                <div class="col-sm-6">
                    <i class="fa fa-phone-alt"></i>
                    <a href="tel:+390254562430">+39 02-5456-2430</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Top bar End -->

    <!-- Nav Bar Start -->
    <div class="nav">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto">
                        <a href="index.php" class="nav-item nav-link">Home</a>
                        <a href="product-list.php" class="nav-item nav-link">Products</a>
                        <a href="product-list.php?filter=sales" class="nav-item nav-link">Sales</a>
                        <a href="product-list.php?filter=usage" class="nav-item nav-link">Warehouse</a>
                        <a href="categories.php" class="nav-item nav-link">Categories</a>
                        <a href="contact.php" class="nav-item nav-link">Contact Us</a>
                    </div>
                    <div class="navbar-nav ml-auto pr-sm-5" style='width: 9.5rem;'>
                        <div class="nav-item dropdown pr-sm-5">
                            <?php
                            if (isset($_SESSION["Username"])) {
                                echo "<a href='#' class='nav-link dropdown-toggle' data-toggle='dropdown'>" . $_SESSION["Username"] . "</a>
                                <div class='dropdown-menu'>
                                    <a href='my-account.php' class='dropdown-item userDropdown'>My Account</a>
                                    <a href='index.php?msg=Logout successfully!' class='dropdown-item userDropdown'>Logout</a>
                                </div>";
                            } else {
                                echo "<a href='#' class='nav-link dropdown-toggle' data-toggle='dropdown'>User Account</a>
                                <div class='dropdown-menu'>
                                    <a href='login.php' class='dropdown-item userDropdown'>Login</a>
                                    <a href='login.php' class='dropdown-item userDropdown'>Register</a>
                                </div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Nav Bar End -->

    <!-- Bottom Bar Start -->
    <div class="bottom-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <div class="logo">
                        <a href="index.php">
                            <img src="img/logo.png" alt="Logo">
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="search">
                        <form action="product-list.php" method="get">
                            <input type="text" name="filter" placeholder="Search">
                            <button><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="user">
                        <a href="wishlist.php" class="btn wishlist">
                            <i class="fa fa-heart"></i>
                            <?php
                            if (isset($_SESSION["IDWishlist"])) {
                                $sql = "SELECT COUNT(*) FROM includes JOIN wishlists
                                ON includes.IdWishlist = wishlists.Id
                                WHERE wishlists.Id = '" . $_SESSION["IDWishlist"] . "'";

                                $result = $conn->query($sql);


                                $row = $result->fetch_assoc();
                                $n = $row["COUNT(*)"];
                            } else if (isset($_SESSION["IDWishlistGuest"])) {
                                $sql = "SELECT COUNT(*) FROM includes JOIN wishlists
                                ON includes.IdWishlist = wishlists.Id
                                WHERE wishlists.Id = '" . $_SESSION["IDWishlistGuest"] . "'";

                                $result = $conn->query($sql);

                                $row = $result->fetch_assoc();
                                $n = $row["COUNT(*)"];
                            } else
                                $n = 0;
                            echo "<span>(" . $n . ")</span>";
                            ?>
                        </a>
                        <a href="cart.php" class="btn cart">
                            <i class="fa fa-shopping-cart"></i>
                            <?php
                            if (isset($_SESSION["IDCart"])) {
                                $sql = "SELECT COUNT(*) FROM contains JOIN carts
                                ON contains.IdCart = carts.Id
                                WHERE carts.Id = '" . $_SESSION["IDCart"] . "'";

                                $result = $conn->query($sql);

                                $row = $result->fetch_assoc();
                                $n = $row["COUNT(*)"];
                            } else if (isset($_SESSION["IDCartGuest"])) {
                                $sql = "SELECT COUNT(*) FROM contains JOIN carts
                                ON contains.IdCart = carts.Id
                                WHERE carts.Id = '" . $_SESSION["IDCartGuest"] . "'";

                                $result = $conn->query($sql);

                                $row = $result->fetch_assoc();
                                $n = $row["COUNT(*)"];
                            } else
                                $n = 0;
                            echo "<span>(" . $n . ")</span>"
                            ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bottom Bar End -->
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">My Account</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- My Account Start -->
    <div class="my-account">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                        <a class="nav-link" id="account-nav" data-toggle="pill" href="#account-tab" role="tab"><i class="bi bi-person-fill"></i> Account Details</a>
                        <a class="nav-link" id="seller-nav" data-toggle="pill" href="#seller-tab" role="tab"><i class="bi bi-person-plus-fill"></i> Seller</a>
                        <a class="nav-link" id="orders-nav" data-toggle="pill" href="#orders-tab" role="tab"><i class="fa fa-shopping-bag"></i> Orders</a>
                        <a class="nav-link" id="payment-nav" data-toggle="pill" href="#payment-tab" role="tab"><i class="fa fa-credit-card"></i>Payment Method</a>
                        <a class="nav-link" id="address-nav" data-toggle="pill" href="#address-tab" role="tab"><i class="fa fa-map-marker-alt"></i> Address</a>
                        <a class="nav-link" href='index.php?msg=Logout successfully!&type=danger'><i class="fa fa-sign-out-alt"></i>Logout</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade" id="account-tab" role="tabpanel" aria-labelledby="account-nav">
                            <form action="check/updateUser.php" method="post">
                                <div class="container">
                                    <h4><b>Account Details</b></h4>
                                    <?php
                                    $sql = "SELECT * FROM users WHERE Id = '" . $_SESSION["ID"] . "'";

                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        echo "
                                                <div class='row'>
                                                    <div class='col-md-3'>Username: </div>
                                                    <div class='col-md-3'><input type='text' name='username' style = 'width: 300px' class='form-control' value='" . $row["Username"] . "'></div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>First Name: </div>
                                                    <div class='col-md-3'><input type='text' name='firstName' style = 'width: 300px' class='form-control' value='" . $row["FirstName"] . "'></div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>Last Name: </div>
                                                    <div class='col-md-3'><input type='text' name='lastName' style = 'width: 300px' class='form-control' value='" . $row["LastName"] . "'></div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>Birth Date: </div>
                                                    <div class='col-md-3'><input type='date' name='birthDate' style = 'width: 300px' class='form-control' value='" . $row["BirthDate"] . "'></div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>Email: </div>
                                                    <div class='col-md-3'><input type='email' name='email' style = 'width: 300px' class='form-control' style='width:auto;' value='" . $row["Email"] . "'></div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>Mobile Number: </div>
                                                    <div class='col-md-3'><input type='text' name='mobileNumber' style = 'width: 300px' class='form-control' value='" . $row["MobilePhoneNumber"] . "'></div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>Password: </div>
                                                    <div class='col-md-3'><input type='password' name='password' style = 'width: 300px' class='form-control' value=''></div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>New Password: </div>
                                                    <div class='col-md-3'><input type='password' name='retypePassword' style = 'width: 300px' class='form-control' value=''></div>
                                                </div>";
                                    }

                                    ?>
                                    <input type="submit" value="Submit" class="btn">
                                </div>

                            </form>
                        </div>
                        <div class="tab-pane fade" id="seller-tab" role="tabpanel" aria-labelledby="seller-nav">
                            <h4><b>Seller</b></h4>

                            <?php
                            $sql = $conn->prepare("SELECT Seller FROM users WHERE Id = ?");
                            $sql->bind_param('i', $_SESSION["ID"]);
                            $sql->execute();
                            $result = $sql->get_result();

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                if ($row["Seller"] == 1) {
                                    $sql = $conn->prepare("SELECT articles.Id, Title, Price, Discount, Pieces, Conditions, Type FROM articles JOIN categories ON articles.IdCategory=categories.Id WHERE Seller = ?");
                                    $sql->bind_param('s', $_SESSION["Username"]);
                                    $sql->execute();
                                    $result = $sql->get_result();
                                    echo "<table class='table table-bordered'>
                                                    <thead class='thead-dark'>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Title</th>
                                                            <th>Price</th>
                                                            <th>Discount</th>
                                                            <th>Pieces</th>
                                                            <th>Conditions</th>
                                                            <th>Category</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <p><h5 class='text-center'>Articles on sale</h5></p>";
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . $row['Id'] . "</td>
                                                    <td>" . $row['Title'] . "</td>
                                                    <td>" . $row['Price'] . "</td>
                                                    <td>" . $row['Discount'] . "</td>
                                                    <td>" . $row['Pieces'] . "</td>
                                                    <td>" . $row['Conditions'] . "</td>
                                                    <td>" . $row['Type'] . "</td>
                                                    <td><button class='btn' data-toggle='modal' data-target='#myModalSeller' onclick='caricaModalSeller(" . $row['Id'] . ")'><i class='bi bi-pencil-square'></i></button>
                                                    <button onclick='toDeleteArticle(" . $row['Id'] . ")' class='btn'><i class='bi bi-trash'></i></button></td>
                                                    </tr>";
                                        }
                                        echo "  <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><button data-toggle='modal' data-target='#myModalAdd'  class='btn'>Add new</button></td></tr>
                                                </tbody>
                                                </table>";
                                    } else
                                        echo "<tr><td>There are no articles on sale...</td><td></td><td></td><td></td><td></td><td></td><td></td><td><button data-toggle='modal' data-target='#myModalAdd' class='btn'>Add new</button></td></tr></tbody></table>";
                                } else
                                    echo "<h5>Do you want to become a seller?</h5>
                                        <p>To sell your items you must have set a payment method on your account to receive cash. Let's check and if you have no one, add it now!<br>
                                        Also you need to know that the VAT number is mandatory, unless it does not exceed a certain turnover (about 5.000 euros).</p>
                                        <p>Then you can <a href='my-account.php?pag=seller&seller=1'>start selling</a> on EStore.</p>";
                            }
                            ?>
                            <div id='myModalSeller' class='modal fade' role='dialog'>
                                <!-- Modal content in modalSeller.php-->

                            </div>
                            <div id='myModalAdd' class='modal fade' role='dialog'>
                                <div class='modal-dialog w-auto'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h4 class='modal-title'>New Article</h4>
                                        </div>
                                        <div class='modal-body'>
                                            <form id='formAdd' method='post' action='check/addArticle.php' enctype='multipart/form-data'>
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
                                                            <option hidden>Choose here</option>
                                                            <?php
                                                            include("../db/connection.php");
                                                            $sql = $conn->prepare("SELECT * FROM categories");
                                                            $sql->execute();
                                                            $result = $sql->get_result();
                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $type = $row["Type"];
                                                                    echo "<option value='$type'>$type</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class='modal-footer'>
                                            <button class='btn' onclick="$('#formAdd').submit();">Add</button>
                                            <button type='button' class='btn btn-default' data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="orders-tab" role="tabpanel" aria-labelledby="orders-nav">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Id</th>
                                            <th>Shipping Costs</th>
                                            <th>Shipping Address</th>
                                            <th>Payment Address</th>
                                            <th>Payment Method</th>
                                            <th>Submission Date</th>
                                            <th>Delivery Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <h4><b>Orders</b></h4>
                                        <?php
                                        $sql = "SELECT orders.Id, ShippingCosts, IdShippingAddress, IdPaymentAddress, IdPaymentMethod, SubmissionDate, DeliveryDate
                                                FROM orders
                                                JOIN carts ON orders.IdCart = carts.Id
                                                WHERE carts.IdUser = " . $_SESSION["ID"];
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "
                                                    <tr>
                                                        <td>" . $row["Id"] . "</td>
                                                        <td>$" . $row["ShippingCosts"] . "</td>
                                                        <td><a class='noChangeColorLink' href='my-account.php?pag=address'>" . $row["IdShippingAddress"] . "</a></td>
                                                        <td><a class='noChangeColorLink' href='my-account.php?pag=address'>" . $row["IdPaymentAddress"] . "</a></td>
                                                        <td><a class='noChangeColorLink' href='my-account.php?pag=payment'>" . $row["IdPaymentMethod"] . "</a></td>
                                                        <td>" . $row["SubmissionDate"] . "</td>
                                                        <td>" . $row["DeliveryDate"] . "</td>
                                                        <td><button class='btn' data-toggle='modal' data-target='#myModal' onclick='caricaPopupModal(" . $row["Id"] . ")'>View</button></td>
                                                    </tr>";
                                            }
                                        } else {
                                            echo "<tr><td>There are no orders...</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Modal -->
                            <!-- ORDER WINDOW -->
                            <div id='myModal' class='modal fade' role='dialog'>
                                <!-- Modal content in modalOrder.php-->

                            </div>
                        </div>
                        <div class="tab-pane fade" id="payment-tab" role="tabpanel" aria-labelledby="payment-nav">
                            <h4><b>Payment Method</b></h4>
                            <div class="row">
                                <div class="col-md-5">
                                    <h5 class="text-center">PayPal</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Email</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = $conn->prepare("SELECT * FROM payment_methods WHERE IdUser = ? AND Type = 'PayPal'");
                                                $sql->bind_param('i', $_SESSION["ID"]);
                                                $sql->execute();
                                                $result = $sql->get_result();

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "  <tr>
                                                                        <td>" . $row["Id"] . "</td>
                                                                        <td>" . $row["Email"] . "</td>
                                                                        <td><button onclick='toDeletePaymentMethod(" . $row['Id'] . ")' class='btn'><i class='bi bi-trash'></i></button></td></td>
                                                                    </tr>";
                                                    }
                                                    echo "<tr><td></td><td></td><td><button data-toggle='modal' data-target='#myModalAddPaymentMethod' onclick='caricaModalAddPaymentMethod(1)' class='btn'>Add new</button></td></tr>";
                                                } else {
                                                    echo "<tr><td>There are no linked PayPal accounts...</td><td></td><td><button data-toggle='modal' data-target='#myModalAddPaymentMethod' onclick='caricaModalAddPaymentMethod(1)' class='btn'>Add new</button></td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <h5 class="text-center">Credit Card</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Card Number</th>
                                                    <th>Name on Card</th>
                                                    <th>Expiration Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = $conn->prepare("SELECT * FROM payment_methods WHERE IdUser = ? AND Type = 'Credit Card'");
                                                $sql->bind_param('i', $_SESSION["ID"]);
                                                $sql->execute();
                                                $result = $sql->get_result();

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "  <tr>
                                                                        <td>" . $row["Id"] . "</td>
                                                                        <td>" . $row["CardNumber"] . "</td>
                                                                        <td>" . $row["NameOnCard"] . "</td>
                                                                        <td>" . $row["ExpirationDate"] . "</td>
                                                                        <td><button onclick='toDeletePaymentMethod(" . $row['Id'] . ")' class='btn'><i class='bi bi-trash'></i></button></td></td>
                                                                    </tr>";
                                                    }
                                                    echo "<tr><td></td><td></td><td></td><td></td><td><button data-toggle='modal' data-target='#myModalAddPaymentMethod' onclick='caricaModalAddPaymentMethod(2)' class='btn'>Add new</button></td></tr>";
                                                } else {
                                                    echo "<tr><td>There are no linked Credit Cards...</td><td></td><td></td><td></td><td><button data-toggle='modal' data-target='#myModalAddPaymentMethod' onclick='caricaModalAddPaymentMethod(2)' class='btn'>Add new</button></td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <!-- ORDER WINDOW -->
                            <div id='myModalAddPaymentMethod' class='modal fade' role='dialog'>
                                <!-- Modal content in modalAddPaymentMethod.php-->

                            </div>
                        </div>
                        <div class="tab-pane fade" id="address-tab" role="tabpanel" aria-labelledby="address-nav">
                            <h4><b>Address</b></h4>
                            <div class="row">
                                <div class='col-md-2'></div>
                                <?php
                                $sql = $conn->prepare("SELECT * FROM addresses WHERE IdUser = ? AND (UserPaymentDefault=1 OR UserShippingDefault=1)");
                                $sql->bind_param('i', $_SESSION["ID"]);
                                $sql->execute();
                                $result = $sql->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        if ($row["UserPaymentDefault"] == 1) {
                                            $echo1 = "<div class='col-md-2'>
                                                        <h5>Payment Address</h5>
                                                        <p>$row[Address], " . $row["ZIP Code"] . "</p>
                                                        <p>$row[City], $row[Province]</p>
                                                        <button class='btn' data-toggle='modal' data-target='#myModalEditAddress'>Edit</button>
                                                    </div>";
                                        }
                                        if ($row["UserShippingDefault"] == 1) {
                                            $echo2 = "<div class='col-md-2'>
                                                        <h5>Shipping Address</h5>
                                                        <p>$row[Address], " . $row["ZIP Code"] . "</p>
                                                        <p>$row[City], $row[Province]</p>
                                                        <button class='btn' data-toggle='modal' data-target='#myModalEditAddress'>Edit</button>
                                                    </div>";
                                        }
                                    }
                                }
                                if (!isset($echo1)) {
                                    $echo1 = "  <div class='col-md-2'>
                                                    <center>
                                                        <h5>Payment Address</h5>
                                                        <p>No one set...</p>
                                                        <button class='btn' data-toggle='modal' data-target='#myModalAddAddress'>Add</button>
                                                    </center>
                                                </div>";
                                }
                                echo $echo1 . "<div class='col-md-4'></div>";
                                if (!isset($echo2)) {
                                    $echo2 = "  <div class='col-md-2'>
                                                    <center>
                                                        <h5>Shipping Address</h5>
                                                        <p>No one set...</p>
                                                        <button class='btn' data-toggle='modal' data-target='#myModalAddAddress'>Add</button>
                                                    </center>
                                                </div>";
                                }
                                echo $echo2;
                                ?>
                                <div class='col-md-2'></div>
                            </div>
                            <!-- Modal -->
                            <div id='myModalAddAddress' class='modal fade' role='dialog'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h4 class='modal-title'>New Address</h4>
                                        </div>
                                        <div class='modal-body'>
                                            <form id='formAddAddress' method='post' action='check/addAddress.php'>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-9">
                                                        <label class="required">Address</label>
                                                        <input type="text" class="form-control" name='address' placeholder="Address" required>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label class="required">ZIP Code</label>
                                                        <input type="text" class="form-control" name='zipCode' maxlength="9" placeholder="ZIP Code" required>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label class="required">Country</label>
                                                        <input type="text" class="form-control" name='country' placeholder="Country" required>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label class="required">City</label>
                                                        <input type="text" class="form-control" name='city' placeholder="City" required>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label class="required">Province</label>
                                                        <input type="text" class="form-control" name='province' placeholder="Province" required>
                                                    </div>
                                                </div>
                                                <label>Set as default:</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="paymentDefault" id="customCheck1" value="1">
                                                    <label class="custom-control-label" for="customCheck1">Payment Address</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="shippingDefault" id="customCheck2" value="1">
                                                    <label class="custom-control-label" for="customCheck2">Shipping Address</label>
                                                </div>
                                                <b>
                                                    <p id='error'></p>
                                                </b>
                                            </form>
                                        </div>
                                        <div class='modal-footer'>
                                            <button class='btn' onclick="addAddress()">Add</button>
                                            <button type='button' class='btn btn-default' data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div id='myModalEditAddress' class='modal fade' role='dialog'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h4 class='modal-title'>Edit Address</h4>
                                        </div>
                                        <div class='modal-body'>
                                            <form id='formEditAddress' method='post' action='check/editAddress.php'>
                                                <div class="form-row">
                                                    <div class='col-md-6'>
                                                        <h5>Payment Address</h5>
                                                    </div>
                                                    <div class='col-md-6'>
                                                        <h5>Shipping Address</h5>
                                                    </div>

                                                    <?php
                                                    $sql = $conn->prepare("SELECT * FROM addresses WHERE IdUser = ?");
                                                    $sql->bind_param('i', $_SESSION["ID"]);
                                                    $sql->execute();
                                                    $result = $sql->get_result();

                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            if ($row["UserPaymentDefault"] == 1)
                                                                echo  " <div class='form-check form-check-inline'>
                                                                            <div class='col-md-6'>
                                                                                <p>
                                                                                    <input class='form-check-input' type='radio' name='paymentRadioOptions' checked value='payment_$row[Id]'>$row[Address], " . $row["ZIP Code"] . "
                                                                                    $row[City], $row[Province]
                                                                                </p>
                                                                            </div>";
                                                            else
                                                                echo  " <div class='form-check form-check-inline'>
                                                                            <div class='col-md-6'>
                                                                                <p>
                                                                                    <input class='form-check-input' type='radio' name='paymentRadioOptions' value='payment_$row[Id]'>$row[Address], " . $row["ZIP Code"] . "
                                                                                    $row[City], $row[Province]
                                                                                </p>
                                                                            </div>";

                                                            if ($row["UserShippingDefault"] == 1)
                                                                echo  "     <div class='col-md-6'>
                                                                                <p>
                                                                                    <input class='form-check-input' type='radio' name='shippingRadioOptions' checked value='shipping_$row[Id]'>$row[Address], " . $row["ZIP Code"] . "
                                                                                    $row[City], $row[Province]
                                                                                </p>
                                                                            </div>
                                                                        </div>";
                                                            else
                                                                echo  "     <div class='col-md-6'>
                                                                                <p>
                                                                                    <input class='form-check-input' type='radio' name='shippingRadioOptions' value='shipping_$row[Id]'>$row[Address], " . $row["ZIP Code"] . "
                                                                                    $row[City], $row[Province]
                                                                                </p>
                                                                            </div>
                                                                        </div>";
                                                        }
                                                    }
                                                    ?>
                                                    <b>
                                                        <p id='error'></p>
                                                    </b>
                                                </div>
                                            </form>
                                        </div>
                                        <div class='modal-footer'>
                                            <button class='btn' onclick="$('#formEditAddress').submit();">Save</button>
                                            <button class='btn' onclick="fromEditToAddAddress()">Add New</button>
                                            <button type='button' class='btn btn-default' data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- My Account End -->

    <!-- Footer Start -->
    <div class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Get in Touch</h2>
                        <div class="contact-info">
                            <p><i class="fa fa-map-marker"></i><a class="noChangeColorLink" href="https://maps.google.com/?q=Via+Giuseppe+Mengoni+3,+Milano">Via Giuseppe Mengoni 3, Milano</a></p>
                            <p><i class="fa fa-envelope"></i><a class="noChangeColorLink" href="mailto:E-StoreIT@gmail.com">E-StoreIT@gmail.com</a></p>
                            <p><i class="fa fa-phone"></i><a class="noChangeColorLink" href="tel:+390254562430">+39 02-5456-2430</a></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Follow Us</h2>
                        <div class="contact-info">
                            <div class="social">
                                <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
                                <a href="https://facebook.com"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
                                <a href="https://www.youtube.com"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="footer-widget">
                        <h5><b>Subscribe to the newsletter</b></h5>
                        <div>
                            <form action="#" method="POST">
                                <input type="text" name="emailNewsletter">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Company Info</h2>
                        <ul>
                            <li><a href="about_us.php">About Us</a></li>
                            <li><a href="privacy_policy.php">Privacy Policy</a></li>
                            <li><a href="terms_and_condition.php">Terms & Condition</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Purchase Info</h2>
                        <ul>
                            <li><a href="payment_policy.php">Payment Policy</a></li>
                            <li><a href="shipping_and_delivery_policy.php">Shipping and Delivery Policy</a></li>
                            <li><a href="return_policy.php">Return Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="row payment align-items-center">
            <div class="col-md-6">
                <div class="payment-method">
                    <h2>We Accept:</h2>
                    <img src="img/payment-method.png" alt="Payment Method" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="payment-security">
                    <h2>Secured By:</h2>
                    <img src="img/godaddy.svg" alt="Payment Security" />
                    <img src="img/norton.svg" alt="Payment Security" />
                    <img src="img/ssl.svg" alt="Payment Security" />
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-growl/1.0.0/jquery.bootstrap-growl.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="js/redirects.js"></script>

    <script>
        function fromEditToAddAddress() {
            $('#myModalEditAddress').modal('hide');
            $("#myModalAddAddress").modal('show');
        }

        function addAddress() {
            // Get first form element
            var $form = $('#formAddAddress')[0];

            // Check if valid using HTML5 checkValidity() builtin function
            if ($form.checkValidity()) {
                $form.submit();
            } else {
                $('#error').text('Enter all required fields!');
                $('.required').css("font-weight", "bold");
            }
        }

        function caricaPopupModal(id) {
            $.ajax({
                url: "check/modalOrder.php?id=" + id,
                success: function(data) {
                    $('#myModal').html(data);
                }
            });
        }

        function caricaModalSeller(id) {
            $.ajax({
                url: "check/modalSeller.php?id=" + id,
                success: function(data) {
                    $('#myModalSeller').html(data);
                }
            });
        }

        function caricaModalAddPaymentMethod(n) {
            if (n == 1) {
                var type = "PayPal";
            } else if (n == 2) {
                var type = "Credit Card";
            }
            $.ajax({
                url: "check/modalAddPaymentMethod.php?type=" + type,
                success: function(data) {
                    $('#myModalAddPaymentMethod').html(data);
                }
            });
        }
    </script>

    <?php
    if (isset($_GET['pag'])) {
        $section = $_GET['pag'];
        echo "  <script>
        $('#$section-nav').addClass(' active');
        $('#$section-tab').addClass(' show active');
        </script>";
    } else {
        echo "  <script>
        $('#account-nav').addClass(' active');
        $('#account-tab').addClass(' show active');
        </script>";
    }
    if (isset($_GET['msg']) && isset($_GET['type'])) {
        $type = $_GET["type"];
        $msg = $_GET['msg'];
        echo "<script>caricaPopup('$msg', '$type')</script>";
    }
    ?>
</body>

</html>