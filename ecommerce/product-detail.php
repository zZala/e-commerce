<?php
include("db/connection.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Product Detail</title>
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
                <li class="breadcrumb-item"><a href="product-list.php">Products</a></li>
                <li class="breadcrumb-item active">Product Detail</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Detail Start -->
    <div class="product-detail">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-detail-top">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="product-slider-single normal-slider">
                                    <?php
                                    echo "<img src='img/product-" . $_GET["id"] . ".jpg' alt='Product Image'>";
                                    ?>
                                </div>
                                <!-- SLIDER PER PIU FOTO
                                <div class="product-slider-single-nav normal-slider">
                                    <div class="slider-nav-img"><img src="img/product-1.jpg"></div>
                                    <div class="slider-nav-img"><img src="img/product-3.jpg" alt="Product Image"></div>
                                    <div class="slider-nav-img"><img src="img/product-5.jpg" alt="Product Image"></div>
                                    <div class="slider-nav-img"><img src="img/product-7.jpg" alt="Product Image"></div>
                                    <div class="slider-nav-img"><img src="img/product-9.jpg" alt="Product Image"></div>
                                    <div class="slider-nav-img"><img src="img/product-10.jpg" alt="Product Image"></div>
                                </div>
                                -->
                            </div>
                            <div class="col-md-9">
                                <div class="product-content">
                                    <?php
                                    $sql = "SELECT articles.Id, articles.Title, Price, Discount, AVG(Stars), Pieces FROM articles JOIN reviews ON articles.Id = reviews.IdArticle WHERE articles.Id = '" . $_GET["id"] . "' GROUP BY articles.Id";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        echo "<form method='get' action='check/addToCart.php'><div class='title'>
                                                <h2>" . $row["Title"] . "</h2>
                                            </div>
                                            <div class='ratting'>";
                                        for ($i = 0; $i < $row["AVG(Stars)"]; $i++) {
                                            echo "<i class='fa fa-star'></i>";
                                        }
                                        for ($i = $row["AVG(Stars)"]; $i < 5; $i++) {
                                            echo "<i class='far fa-star'></i>";
                                        }
                                    } else {
                                        $sql = "SELECT articles.Id, articles.Title, Price, Discount, Pieces FROM articles WHERE articles.Id = '" . $_GET["id"] . "'";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            echo "<form method='get' action='check/addToCart.php'><div class='title'>
                                                <h2>" . $row["Title"] . "</h2>
                                            </div>
                                            <div class='ratting'>";
                                            for ($i = 0; $i < 5; $i++) {
                                                echo "<i class='far fa-star'></i>";
                                            }
                                        }
                                    }
                                    echo "</div>
                                        <div class='price'>
                                            <h4>Price:</h4>";
                                    if ($row["Discount"] != 0)
                                        echo "<p>$" . round($row["Price"] * (100 - $row["Discount"]) / 100, 2) . "<span>$" . $row["Price"] . "</span></p>";
                                    else
                                        echo "<p>$" . $row["Price"] . "</p>";
                                    echo "  </div>
                                            <div class='quantity'>
                                                <h4>Quantity:</h4>
                                                <div class='qty'>";
                                    if ($row["Pieces"] >= 1)
                                        echo "  <input type='number' name='q' value='1' min=1 max=" . $row["Pieces"] . ">
                                                <input type='hidden' name='id' value='" . $row["Id"] . "'>
                                                </div>
                                                </div>
                                                <div class='action'>
                                                    <button class='btn'><i class='fa fa-shopping-cart'></i>Add to Cart</button>
                                                    <button class='btn'><i class='fa fa-shopping-bag'></i>Buy Now</button>
                                                </div>";
                                    else
                                        echo "  <input type='number' name='q' value='0' min=0 max=0>
                                                <input type='hidden' name='id' value='" . $row["Id"] . "'>
                                                </div>
                                                </div>
                                                <div class='action'>
                                                    <button class='btn soldout'><i class='fa fa-shopping-cart'></i>Sold Out</button>
                                                </div>";
                                    echo "</form>";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row product-detail-bottom">
                        <div class="col-lg-12">
                            <ul class="nav nav-pills nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#description">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#specification">Specification</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#reviews">Reviews</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="description" class="container tab-pane active">
                                    <h4>Product description</h4>

                                    <?php
                                    $sql = "SELECT * FROM articles WHERE Id = '" . $_GET["id"] . "'";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        echo "<p>" . $row["Description"] . "</p>";
                                    }
                                    echo "</div>
                                        <div id='specification' class='container tab-pane fade'>
                                            <h4>Product specification</h4>
                                            <ul>
                                                <li>Seller: " . $row["Seller"] . "</li>
                                                <li>Conditions: " . $row["Conditions"] . "</li>
                                                <li>Available pieces: " . $row["Pieces"] . "</li>
                                            </ul>
                                        </div>";
                                    echo "<div id='reviews' class='container tab-pane fade'>";
                                    $sql = "SELECT * FROM reviews JOIN users ON reviews.IdUser = users.Id WHERE IdArticle = '" . $_GET["id"] . "'";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<div class='reviews-submitted'>
                                            <div class='reviewer'>" . $row["Username"] . " - <span>" . $row["Date"] . "</span></div>
                                                <div class='ratting'>";
                                            for ($i = 0; $i < $row["Stars"]; $i++) {
                                                echo "<i class='fa fa-star'></i>";
                                            }
                                            echo "</div><h5>" . $row["Title"] . "</h5><p>" . $row["Comment"] . "</p></div>";
                                        }
                                    }
                                    ?>
                                    <div class="reviews-submit">

                                        <h4>Give your Review:</h4>
                                        <div class="ratting">
                                            <i class="far fa-star" name="1" id="1" onclick="setStars(1)"></i>
                                            <i class="far fa-star" name="2" id="2" onclick="setStars(2)"></i>
                                            <i class="far fa-star" name="3" id="3" onclick="setStars(3)"></i>
                                            <i class="far fa-star" name="4" id="4" onclick="setStars(4)"></i>
                                            <i class="far fa-star" name="5" id="5" onclick="setStars(5)"></i>
                                        </div>
                                        <form action="check/addReview.php" method="get">
                                            <div class="row form">
                                                <div class="col-sm-6">
                                                    <input type="title" name='title' placeholder="Title" required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?php
                                                    echo "<input type='hidden' name='id' value=" . $_GET['id'] . ">";
                                                    ?>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?php
                                                    echo "<input type='hidden' name='stars' id='stars' value='0'>";
                                                    ?>
                                                </div>
                                                <div class="col-sm-12">
                                                    <textarea placeholder="Review" name='text' required></textarea>
                                                </div>
                                                <div class="col-sm-12">
                                                    <button>Submit</button>
                                                </div>
                                        </form>
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
    <!-- Product Detail End -->

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
    <script src='js/stars.js'></script>
    <script src="js/redirects.js"></script>


    <?php
    if (isset($_GET['msg'])) {
        switch ($_GET['msg']) {
            case "Review added successfully!":
                $type = 'success';
                break;
            case "Stars must be more than zero!":
                $type = 'warning';
                break;
        }

        echo "<script>caricaPopup('" . $_GET['msg'] . "', '$type')</script>";
    }
    ?>

</body>

</html>