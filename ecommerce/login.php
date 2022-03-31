<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>E-Commerce Login</title>
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

    <?php
    if (isset($_GET['msg']) && $_GET['msg'] == "Registered successfully!") {
        alert($msg);
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
                        <a href="product-list.html" class="nav-item nav-link">Products</a>
                        <a href="cart.html" class="nav-item nav-link">Cart</a>
                        <a href="checkout.html" class="nav-item nav-link">Checkout</a>
                        <a href="my-account.html" class="nav-item nav-link">My Account</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle active" data-toggle="dropdown">More Pages</a>
                            <div class="dropdown-menu">
                                <a href="wishlist.html" class="dropdown-item">Wishlist</a>
                                <a href="login.php" class="dropdown-item active">Login & Register</a>
                                <a href="contact.html" class="dropdown-item">Contact Us</a>
                            </div>
                        </div>
                    </div>
                    <div class="navbar-nav ml-auto">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">User Account</a>
                            <div class="dropdown-menu">
                                <a href="login.php" class="dropdown-item">Login</a>
                                <a href="login.php" class="dropdown-item">Register</a>
                            </div>
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
                        <!-- DA FARE NELL'INDEX-->
                        <form action="index.php" method="get">
                            <a href="index.php">
                                <img src="img/logo.png" alt="Logo">
                            </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="search">
                        <input type="text" placeholder="Search">
                        <button><a href="index.php"><i class="fa fa-search"></i></a></button>
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
                                $conn->close();
                            } else
                                $result = 0;
                            echo "<span>($result)</span>"
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
                                $conn->close();
                            } else
                                $result = 0;
                            echo "<span>($result)</span>"
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
                <li class="breadcrumb-item active">Login & Register</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Login Start -->
    <div class="login">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login-form">
                        <!--START FORM LOGIN-->
                        <form action="check/checkLogin.php" method="post">
                            <div class="row">
                                <?php
                                if (isset($_GET['msg']) && $_GET['msg'] == "Username and Password doesn't match!")
                                    echo "<div class='col-md-12'><b>" . $_GET['msg'] . "</b></div>";
                                ?>
                                <div class="col-md-6">
                                    <label>E-mail / Username</label>
                                    <input class="form-control" name="UsernameOrEmail" type="text" placeholder="E-mail / Username">
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <input class="form-control" name="PasswordLogin" type="password" placeholder="Password">
                                </div>
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="newaccount">
                                        <label class="custom-control-label" for="newaccount">Keep me signed in</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" value="Submit" class="btn">
                                </div>
                            </div>
                        </form>
                        <!--END FORM LOGIN-->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="register-form">
                        <!--START FORM REGISTER-->
                        <form action="check/checkRegister.php" method="post">
                            <div class="row">
                                <?php
                                if (isset($_GET['msg']) && $_GET['msg'] == "Password doesn't match!")
                                    echo "<div class='col-md-12'><b>" . $_GET['msg'] . "</b></div>";
                                ?>
                                <div class="col-md-6">
                                    <label>First Name</label>
                                    <input class="form-control" name="FirstName" type="text" placeholder="First Name" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Last Name</label>
                                    <input class="form-control" name="LastName" type="text" placeholder="Last Name" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Birth Date</label>
                                    <input class="form-control" name="BirthDate" type="text" placeholder="Birth Date" onfocus="(this.type='date')" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Mobile Number</label>
                                    <input class="form-control" name="MobileNumber" type="text" placeholder="+391234567890" required>
                                </div>
                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input class="form-control" name="E-mail" type="email" placeholder="E-mail" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Username</label>
                                    <input class="form-control" name="Username" type="text" placeholder="Username" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <input class="form-control" name="Password" type="password" placeholder="Password" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Retype Password</label>
                                    <input class="form-control" name="RetypePassword" type="password" placeholder="Password" required>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" value="Submit" class="btn">
                                </div>
                            </div>
                        </form>
                        <!--END FORM REGISTER-->
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