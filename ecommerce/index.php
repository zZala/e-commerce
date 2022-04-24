<?php
include("db/connection.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>EStore</title>
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

    <script type="text/javascript" src="script.js"></script>

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <?php
    //login
    if (isset($_GET['msg']) && $_GET['msg'] == "Logged successfully!") {
        alert($_GET['msg']);
    }
    function alert($msg)
    {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }

    //logout
    if (isset($_GET['msg']) && $_GET['msg'] == "logout") {
        unset($_SESSION["ID"]);
        unset($_SESSION['Username']);
    }

    //se presente cookie lo carico
    if (isset($_COOKIE["IDWishlistGuest"])) {
        $_SESSION["IDWishlistGuest"] = $_COOKIE["IDWishlistGuest"];
    }
    if (isset($_COOKIE["IDCartGuest"])) {
        $_SESSION["IDCartGuest"] = $_COOKIE["IDCartGuest"];
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


    <!-- Main Slider Start -->
    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <nav class="navbar bg-light">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php"><i class="fa fa-home"></i>Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="product-list.php?filter=popular"><i class="fa fa-shopping-bag"></i>Best Selling</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="product-list.php?filter=newest"><i class="fa fa-plus-square"></i>New Arrivals</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="product-list.php?filters=Clothing,Shoes"><i class="fa fa-female"></i>Clothing & Shoes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="product-list.php?filters=Food,Beverages"><i class="fa fa-child"></i>Food & Beverages</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="product-list.php?filters=Books,Movies,Games"><i class="fa fa-tshirt"></i>Books, Movies & Games</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="product-list.php?category=Home, Garden & Tools"><i class="fa fa-mobile-alt"></i>Home, Garden & Tools</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="product-list.php?filters=Electronics,Computers"><i class="fa fa-microchip"></i>Electronics & Computers</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-6">
                    <div class="header-slider normal-slider">
                        <div class="header-slider-item">
                            <a href="product-detail.php?id=3&q=1">
                                <img src="img/slider-1.jpg" alt="Slider Image" />
                            </a>
                        </div>
                        <div class="header-slider-item">
                            <a href="">
                                <img src="img/slider-2.png" alt="Slider Image" />
                            </a>
                        </div>
                        <div class="header-slider-item">
                            <a href="product-list.php?filter=sales">
                                <img src="img/slider-3.png" alt="Slider Image" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="header-img">
                        <div class="img-item categoriesIndex">
                            <img src="img/category-1.jpg" />
                            <a class="img-text" href="product-list.php?category=Clothing">
                                <p>Clothing</p>
                            </a>
                        </div>
                        <div class="img-item categoriesIndex">
                            <img src="img/category-2.jpg" />
                            <a class="img-text" href="product-list.php?category=Shoes">
                                <p>Shoes</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Slider End -->

    <!-- Brand Start -->
    <div class="brand">
        <div class="container-fluid">
            <div class="brand-slider">
                <div class="brand-item"><img src="img/brand-1.png" alt=""></div>
                <div class="brand-item"><img src="img/brand-2.png" alt=""></div>
                <div class="brand-item"><img src="img/brand-3.png" alt=""></div>
                <div class="brand-item"><img src="img/brand-4.png" alt=""></div>
                <div class="brand-item"><img src="img/brand-5.png" alt=""></div>
                <div class="brand-item"><img src="img/brand-6.png" alt=""></div>
            </div>
        </div>
    </div>
    <!-- Brand End -->

    <!-- Feature Start-->
    <div class="feature">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fab fa-cc-mastercard"></i>
                        <h2>Secure Payment</h2>
                        <p>
                            Sensitive and financial information are encrypted to protect you from fraud and unauthorized access.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fa fa-truck"></i>
                        <h2>Worldwide Delivery</h2>
                        <p>
                            Deliveries are guaranteed all over the world.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fa fa-sync-alt"></i>
                        <h2>90 Days Return</h2>
                        <p>
                            We give the opportunity to return or exchange purchases within 90 days of the time they are shipped.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fa fa-comments"></i>
                        <h2>24/7 Support</h2>
                        <p>
                            We guarantee a quick response from our service technicians, available for you, 24/7.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End-->

    <!-- Category Start-->
    <div class="category">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="category-item ch-400 categoriesIndex">
                        <img src="img/category-3.jpg" />
                        <a class="category-name" href="product-list.php?category=Jewelry & Watches">
                            <p>Jewelry & Watches</p>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category-item ch-250 categoriesIndex">
                        <img src="img/category-4.jpg" />
                        <a class="category-name" href="product-list.php?category=Books">
                            <p>Books</p>
                        </a>
                    </div>
                    <div class="category-item ch-150 categoriesIndex">
                        <img src="img/category-5.jpg" />
                        <a class="category-name" href="product-list.php?category=Movies">
                            <p>Movies</p>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category-item ch-150 categoriesIndex">
                        <img src="img/category-6.jpg" />
                        <a class="category-name" href="product-list.php?category=Games">
                            <p>Games</p>
                        </a>
                    </div>
                    <div class="category-item ch-250 categoriesIndex">
                        <img src="img/category-7.jpg" />
                        <a class="category-name" href="product-list.php?category=Electronics">
                            <p>Electronics</p>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category-item ch-400 categoriesIndex">
                        <img src="img/category-8.jpg" />
                        <a class="category-name" href="product-list.php?category=Food">
                            <p>Food</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Category End-->

    <!-- Call to Action Start -->
    <div class="call-to-action">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>call us for any queries</h1>
                </div>
                <div class="col-md-6">
                    <a href="tel:+390254562430">+39 02-5456-2430</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Call to Action End -->

    <!-- Popular Product Start -->
    <div class="featured-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>Popular Product</h1>
            </div>
            <div class="row align-items-center product-slider product-slider-6">
                <?php
                $sql = "SELECT Title, articles.Id, Price, Discount FROM articles JOIN contains ON articles.Id = contains.IdArticle GROUP BY contains.IdArticle ORDER BY COUNT(*) DESC";
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
                                            <a href='product-detail.php'>
                                                <img src='img/product-" . $row["Id"] . ".jpg' alt='Product Image'>
                                            </a>
                                            <div class='product-action'>
                                                <a href='check/addToCart.php?id=" . $row["Id"] . "&q=1'><i class='fa fa-cart-plus'></i></a>
                                                <a href='check/addToWishlist.php?id=" . $row["Id"] . "&q=1'><i class='fa fa-heart'></i></a>
                                                <a href='product-detail.php?id=" . $row["Id"] . "&q=1'><i class='fa fa-search'></i></a>
                                            </div>
                                        </div>
                                        <div class='product-price'>";
                        if ($row["Discount"] != 0)
                            echo "<h3><span><s>$" . $row["Price"] . "</s> </span>$" . round($row["Price"] * (100 - $row["Discount"]) / 100, 2) . "</h3>";
                        else
                            echo "<h3>$" . $row["Price"] . "</h3>";

                        echo "<a class='btn' href='checkout.php?id=" . $row["Id"] . "'><i class='fa fa-shopping-cart'></i>Buy Now</a>
                                        </div>
                                    </div>
                            </div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Featured Product End -->

    <!-- Newsletter Start -->
    <div class="newsletter">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h1>Subscribe Our Newsletter</h1>
                </div>
                <div class="col-md-6">
                    <div class="form">
                        <input type="email" value="Your email here">
                        <button>Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Newsletter End -->

    <!-- Recent Product Start -->
    <div class="recent-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>Recent Product</h1>
            </div>
            <div class="row align-items-center product-slider product-slider-6">
                <?php
                $sql = "SELECT Title, articles.Id, Price, Discount FROM articles ORDER BY articles.Id DESC";
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
                                            <a href='product-detail.php'>
                                                <img src='img/product-" . $row["Id"] . ".jpg' alt='Product Image'>
                                            </a>
                                            <div class='product-action'>
                                                <a href='check/addToCart.php?id=" . $row["Id"] . "&q=1'><i class='fa fa-cart-plus'></i></a>
                                                <a href='check/addToWishlist.php?id=" . $row["Id"] . "&q=1'><i class='fa fa-heart'></i></a>
                                                <a href='product-detail.php?id=" . $row["Id"] . "&q=1'><i class='fa fa-search'></i></a>
                                            </div>
                                        </div>
                                        <div class='product-price'>";
                        if ($row["Discount"] != 0)
                            echo "<h3><span><s>$" . $row["Price"] . "</s> </span>$" . round($row["Price"] * (100 - $row["Discount"]) / 100, 2) . "</h3>";
                        else
                            echo "<h3>$" . $row["Price"] . "</h3>";

                        echo "<a class='btn' href='checkout.php?id=" . $row["Id"] . "'><i class='fa fa-shopping-cart'></i>Buy Now</a>
                                        </div>
                                    </div>
                            </div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Recent Product End -->

    <!-- Review Start -->
    <div class="review">
        <div class="container-fluid">
            <div class="row align-items-center review-slider normal-slider">
                <div class="col-md-6">
                    <div class="review-slider-item">
                        <div class="review-img">
                            <img src="img/review-3.jpg" alt="Image">
                        </div>
                        <div class="review-text">
                            <h2>Giorgia Cozza</h2>
                            <h3>Call Center Agent</h3>
                            <p>
                                She works at a virtual call center. She’ll answer phone or email inquiries from customers, she is expected to handle a high volume of calls and to have excellent communication and problem-solving skills.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="review-slider-item">
                        <div class="review-img">
                            <img src="img/review-2.jpg" alt="Image">
                        </div>
                        <div class="review-text">
                            <h2>Simone Gerosa</h2>
                            <h3>Technical Support</h3>
                            <p>
                                He has solid technical skills; product-specific software, application, or hardware skills; and the ability to troubleshoot, solve problems, and deal well with people, consider a tech support role.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="review-slider-item">
                        <div class="review-img">
                            <img src="img/review-1.jpg" alt="Image">
                        </div>
                        <div class="review-text">
                            <h2>Ilaria Gatti</h2>
                            <h3>Social Media Customer</h3>
                            <p>
                                She associates handles tweets and Facebook posts from dissatisfied customers. This role involves monitoring an organization’s social media accounts, responding to inquiries and resolving issues.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Review End -->

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