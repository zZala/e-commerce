<?php
include("db/connection.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>E Store - eCommerce HTML Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="eCommerce HTML Template Free Download" name="keywords">
    <meta content="eCommerce HTML Template Free Download" name="description">

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

    <?php
    if (isset($_GET['msg'])) {
        alert($_GET['msg']);
    }

    function alert($msg)
    {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
    ?>

</head>

<body>
    <!-- Top bar Start -->
    <div class="top-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <i class="fa fa-envelope"></i>
                    E-StoreIT@gmail.com
                </div>
                <div class="col-sm-6">
                    <i class="fa fa-phone-alt"></i>
                    +39 02-5456-2430
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
                        <a href="contact.html" class="nav-item nav-link">Contact Us</a>
                    </div>
                    <div class="navbar-nav ml-auto pr-sm-5" style='width: 9.5rem;'>
                        <div class="nav-item dropdown pr-sm-5">
                            <?php
                            if (isset($_SESSION["ID"])) {
                                echo "<a href='#' class='nav-link dropdown-toggle' data-toggle='dropdown'>" . $_SESSION["Username"] . "</a>
                                <div class='dropdown-menu'>
                                    <a href='my-account.php' class='dropdown-item userDropdown'>My Account</a>
                                    <a href='returns_and_orders.php' class='dropdown-item userDropdown'>Returns and Orders</a>
                                    <a href='index.php?msg=logout' class='dropdown-item userDropdown'>Logout</a>
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
                            <button><a href="#"><i class="fa fa-search"></i></a></button>
                        </form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="user">
                        <a href="wishlist.html" class="btn wishlist">
                            <i class="fa fa-heart"></i>
                            <?php
                            if (isset($_SESSION["ID"])) {
                                $sql = "SELECT COUNT(*) FROM includes JOIN wishlists
                                ON includes.IdWishlist = wishlists.Id
                                WHERE wishlists.IdUser = '" . $_SESSION["ID"] . "'";

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
                        <a href="cart.html" class="btn cart">
                            <i class="fa fa-shopping-cart"></i>
                            <?php
                            if (isset($_SESSION["ID"])) {
                                $sql = "SELECT COUNT(*) FROM contains JOIN carts
                                ON contains.IdCart = carts.Id
                                WHERE carts.IdUser = '" . $_SESSION["ID"] . "'";

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
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active">Product List</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product List Start -->
    <div class="product-view">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="product-view-top">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="product-short">
                                            <div class="dropdown">
                                                <div class="dropdown-toggle" data-toggle="dropdown">Sort by</div>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item">Newest</a>
                                                    <a href="#" class="dropdown-item">Popular</a>
                                                    <a href="#" class="dropdown-item">Most sale</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2">
                                        <div class="product-price-range">
                                            <div class="dropdown">
                                                <div class="dropdown-toggle" data-toggle="dropdown">Product price range</div>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item">$0 to $50</a>
                                                    <a href="#" class="dropdown-item">$51 to $100</a>
                                                    <a href="#" class="dropdown-item">$101 to $150</a>
                                                    <a href="#" class="dropdown-item">$151 to $200</a>
                                                    <a href="#" class="dropdown-item">$201 to $250</a>
                                                    <a href="#" class="dropdown-item">$251 to $300</a>
                                                    <a href="#" class="dropdown-item">$301 to $350</a>
                                                    <a href="#" class="dropdown-item">$351 to $400</a>
                                                    <a href="#" class="dropdown-item">$401 to $450</a>
                                                    <a href="#" class="dropdown-item">$451 to $500</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        //caricare prodotti 15 per pagina


                        $sql = "SELECT Title, articles.Id, Price FROM articles JOIN categories ON articles.IdCategory = categories.Id";
                        if (isset($_GET["filter"]))
                            $sql = "SELECT Title, articles.Id, Price FROM articles JOIN categories ON articles.IdCategory = categories.Id WHERE Title LIKE '%" . $_GET["filter"] . "%'";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='col-md-2'>
                                            <div class='product-item'>
                                                <div class='product-title'>
                                                    <a href='#'>" . $row["Title"] . "</a>
                                                    <div class='ratting'>
                                                        <i class='fa fa-star'></i>
                                                        <i class='fa fa-star'></i>
                                                        <i class='fa fa-star'></i>
                                                        <i class='fa fa-star'></i>
                                                        <i class='fa fa-star'></i>
                                                    </div>
                                                </div>
                                                <div class='product-image'>
                                                    <a href='product-detail.html'>
                                                        <img src='img/product-1.jpg' alt='Product Image'>
                                                    </a>
                                                    <div class='product-action'>
                                                        <a href='check/addToCart.php?id=" . $row["Id"] . "&q=1'><i class='fa fa-cart-plus'></i></a>
                                                        <a href='check/addToWishlist.php?id=" . $row["Id"] . "&q=1'><i class='fa fa-heart'></i></a>
                                                        <a href='#'><i class='fa fa-search'></i></a>
                                                    </div>
                                                </div>
                                                <div class='product-price'>
                                                    <h3><span>$</span>" . $row["Price"] . "</h3>
                                                    <a class='btn' href=''><i class='fa fa-shopping-cart'></i>Buy Now</a>
                                                </div>
                                            </div>
                                    </div>";
                            }
                        }
                        ?>
                    </div>

                    <!-- Pagination Start -->
                    <div class="col-md-12">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Pagination End -->
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Start -->
    <div class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Get in Touch</h2>
                        <div class="contact-info">
                            <p><i class="fa fa-map-marker"></i>Via Giuseppe Mengoni 3, Milano</p>
                            <p><i class="fa fa-envelope"></i>E-StoreIT@gmail.com</p>
                            <p><i class="fa fa-phone"></i>+39 02-5456-2430</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Follow Us</h2>
                        <div class="contact-info">
                            <div class="social">
                                <a href=""><i class="fab fa-twitter"></i></a>
                                <a href=""><i class="fab fa-facebook-f"></i></a>
                                <a href=""><i class="fab fa-instagram"></i></a>
                                <a href=""><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Company Info</h2>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms & Condition</a></li>
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

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/slick/slick.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>