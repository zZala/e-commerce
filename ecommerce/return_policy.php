<?php
include("db/connection.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Return Policy</title>
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
                            if (isset($_SESSION["ID"])) {
                                echo "<a href='#' class='nav-link dropdown-toggle' data-toggle='dropdown'>" . $_SESSION["Username"] . "</a>
                                <div class='dropdown-menu'>
                                    <a href='my-account.php' class='dropdown-item userDropdown'>My Account</a>
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
                            <button><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="user">
                        <a href="wishlist.php" class="btn wishlist">
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
                        <a href="cart.php" class="btn cart">
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
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Return Policy</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Login Start -->
    <div class="login">
        <div class="container-fluid">
            <div class="login-form">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Return Policy</h1>
                        <p>If for any reason you are unsatisfied with the quality of the tattoos we sent you, we will refund your entire purchase price.
                            We think that you should be completely happy with our products.
                            If your tattoos were not everything you had hoped for, please email us at
                            <a style="pointer-events: none; cursor: default;" href="#">E-StoreIT@gmail.com</a>&nbsp;and we will straighten things out.
                        </p>
                        <br>
                        <h5><b>What is your return policy?</b></h5>
                        <p>
                            We at EStore want you to be completely satisfied with your purchase. If, for any reason, the purchased product is not all you were hoping for,
                            please email us at <a style="pointer-events: none; cursor: default;" href="#">E-StoreIT@gmail.com</a> and we will handle the return with care.
                            <br><br>
                        <h6><b>Both national and international orders:</b></h6>
                        we happily accept the return of unused and undamaged products for a full refund, minus the original shipping costs, in the form of original payment.

                        We ship far and wide and are quite proud of it. However, we are not responsible for the customs and duties determined by each country's customs agency.
                        <br><b>Duties, taxes and other charges are the responsibility of the recipient.</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login End -->

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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>