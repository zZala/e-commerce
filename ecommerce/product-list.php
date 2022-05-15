<?php
include("db/connection.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>E Store - eCommerce</title>
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
                <li class="breadcrumb-item active">Product</li>
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
                                    <div class="col-md-1 w-auto">
                                        <div class="product-short">
                                            <div class="dropdown widthImportantDropdown1">
                                                <div class="dropdown-toggle" data-toggle="dropdown">Sort by</div>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="product-list.php" class="dropdown-item">Default</a>
                                                    <a href="product-list.php?filter=newest" class="dropdown-item">Newest</a>
                                                    <a href="product-list.php?filter=popular" class="dropdown-item">Popular</a>
                                                    <a href="product-list.php?filter=review" class="dropdown-item">Review</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5"></div>
                                    <div class="col-md-5"></div>
                                    <div class="col-md-1">
                                        <div class="product-price-range">
                                            <div class="dropdown widthImportantDropdown2">
                                                <div class="dropdown-toggle" data-toggle="dropdown">Price</div>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="product-list.php" class="dropdown-item">All</a>
                                                    <a href="product-list.php?filter=<25" class="dropdown-item">to $25</a>
                                                    <a href="product-list.php?filter=<50" class="dropdown-item">$25 to $50</a>
                                                    <a href="product-list.php?filter=>50" class="dropdown-item">$50 and more</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        //FILTRI
                        $sql = "SELECT articles.Title, articles.Id, Price, Discount, Pieces FROM articles ";

                        //singolo
                        if (isset($_GET["filter"])) {
                            switch ($_GET["filter"]) {
                                case "sales":
                                    $sql .= "WHERE Discount <> 0";
                                    break;
                                case "usage":
                                    $sql .= "WHERE Conditions = 'Usage'";
                                    break;
                                case "newest":
                                    $sql .= "ORDER BY articles.Id DESC";
                                    break;
                                case "popular":
                                    $sql .= "JOIN contains ON articles.Id = contains.IdArticle GROUP BY contains.IdArticle ORDER BY COUNT(*) DESC";
                                    break;
                                case "review":
                                    $sql .= "JOIN reviews ON articles.Id = reviews.IdArticle GROUP BY reviews.IdArticle ORDER BY AVG(Stars) DESC";
                                    break;
                                case "<25":
                                    $sql .= "WHERE (Price * (100 - Discount) / 100) < 25";
                                    break;
                                case "<50":
                                    $sql .= "WHERE (Price * (100 - Discount) / 100) > 25 AND (Price * (100 - Discount) / 100) < 50";
                                    break;
                                case ">50":
                                    $sql .= "WHERE (Price * (100 - Discount) / 100) > 50";
                                    break;
                                default:
                                    $sql .= "WHERE Title LIKE '%" . $_GET["filter"] . "%'";
                                    break;
                            }

                            //multipli per categorie (in index.php)
                        } else if (isset($_GET["categories"])) {
                            $categories = explode(",", $_GET["categories"]);
                            if (count($categories) < 3)
                                $categories[2] = "";
                            $sql .= "JOIN categories ON articles.IdCategory = categories.Id WHERE Type = '" . $categories[0] . "' OR Type = '" . $categories[1] . "' OR Type = '" . $categories[2] . "'";

                            //per categoria
                        } else if (isset($_GET["category"])) {
                            $sql .= "JOIN categories ON articles.IdCategory = categories.Id WHERE Type = '" . $_GET["category"] . "'";

                            //no filtri
                        } else {
                            $sql .= "JOIN categories ON articles.IdCategory = categories.Id";
                        }

                        //IMPAGINAZIONE
                        if (isset($_GET["p"]))
                            $pag = $_GET["p"];
                        else
                            $pag = 1;

                        //caricare prodotti 15 per pagina
                        $numProdPerPagina = 15;
                        //primo prodotto
                        $offset = ($numProdPerPagina * $pag) - $numProdPerPagina;

                        $sql .= " LIMIT $numProdPerPagina OFFSET $offset";

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
                                                <div class='product-image d-flex align-items-center'>
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

                                if ($row["Pieces"] > 0)
                                    echo "<a class='btn' href='checkout.php?id=" . $row["Id"] . "'><i class='fa fa-shopping-cart'></i>Buy Now</a>";
                                else
                                    echo "<a class='btn soldout'><i class='fa fa-shopping-cart'></i>Sold Out</a>";
                                echo "</div></div></div>";
                            }
                        }
                        ?>
                    </div>

                    <!-- Pagination Start -->
                    <div class="col-md-12">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <?php
                                if (isset($_GET["p"]) && $_GET["p"] != 1) {
                                    echo "  <li class='page-item active'>
                                            <a class='page-link' href='product-list.php?p=" . ($_GET["p"] - 1) . "' tabindex='-1'>Previous</a>
                                            </li>";
                                } else {
                                    echo "  <li class='page-item disabled'>
                                            <a class='page-link' href='' tabindex='-1'>Previous</a>
                                            </li>";
                                }

                                if (isset($_GET["p"])) {
                                    switch ($_GET["p"]) {
                                        case 1:
                                            echo "  <li class='page-item active'><a class='page-link' href='product-list.php?p=1'>1</a></li>
                                                        <li class='page-item'><a class='page-link' href='product-list.php?p=2'>2</a></li>
                                                        <li class='page-item'><a class='page-link' href='product-list.php?p=3'>3</a></li>";
                                            break;
                                        case 2:
                                            echo "  <li class='page-item'><a class='page-link' href='product-list.php?p=1'>1</a></li>
                                                <li class='page-item active'><a class='page-link' href='product-list.php?p=2'>2</a></li>
                                                <li class='page-item'><a class='page-link' href='product-list.php?p=3'>3</a></li>";
                                            break;
                                        case 3:
                                            echo "  <li class='page-item'><a class='page-link' href='product-list.php?p=1'>1</a></li>
                                                    <li class='page-item'><a class='page-link' href='product-list.php?p=2'>2</a></li>
                                                    <li class='page-item active'><a class='page-link' href='product-list.php?p=3'>3</a></li>";
                                            break;
                                        default:
                                            for ($i = 1; $i < $_GET["p"]; $i++) {
                                                echo "<li class='page-item'><a class='page-link' href='product-list.php?p=$i'>$i</a></li>";
                                            }
                                            echo "<li class='page-item active'><a class='page-link' href='product-list.php?p=" . $_GET["p"] . "'>" . $_GET["p"] . "</a></li>";
                                    }
                                    echo "  <li class='page-item active'>
                                                <a class='page-link' href='product-list.php?p=" . ($_GET["p"] + 1) . "' tabindex='-1'>Next</a>
                                            </li>";
                                } else {
                                    echo "  <li class='page-item active'><a class='page-link' href='product-list.php?p=1'>1</a></li>
                                                        <li class='page-item'><a class='page-link' href='product-list.php?p=2'>2</a></li>
                                                        <li class='page-item'><a class='page-link' href='product-list.php?p=3'>3</a></li>";
                                    echo "  <li class='page-item active'>
                                                <a class='page-link' href='product-list.php?p=2' tabindex='-1'>Next</a>
                                            </li>";
                                }
                                ?>
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

    <?php
    if (isset($_GET['msg']) && isset($_GET['type'])) {
        $type = $_GET["type"];
        $msg = $_GET['msg'];
        echo "<script>caricaPopup('$msg', '$type')</script>";
    }
    ?>
</body>

</html>