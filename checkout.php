<?php
session_start();
include 'php/db.php';


$subtotal = 0;
$discount = 20;
$finaltotal = 0;
$alldiscount = 0;
$totalQuantity = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += $item['price'] * $item['quantity'];
        $alldiscount = $subtotal * $discount / 100;
        $finaltotal = $subtotal - $alldiscount;
        $totalQuantity += $item['quantity'];
    }

    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Please log in first.'); window.location.href='login.php';</script>";
        exit();

    }
}
// 
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_address'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Check for empty fields
    if (!empty($name) && !empty($phone) && !empty($address)) {
        $sql = "INSERT INTO shipping_details (user_id, name, phone, address) VALUES ('$user_id', '$name', '$phone', '$address')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Address saved successfully!'); window.location.href='checkout.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error: Could not save your address.'); window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('Please fill in all fields.'); window.history.back();</script>";
        exit();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_details'])) {
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $cardHolderName = mysqli_real_escape_string($conn, $_POST['cardHolderName']);
    $cardNumber = mysqli_real_escape_string($conn, $_POST['cardNumber']);
    $month = mysqli_real_escape_string($conn, $_POST['month']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $cvv = mysqli_real_escape_string($conn, $_POST['cvv']);


    // Check for empty fields
    if (
        !empty($category) && !empty($cardHolderName) && !empty($cardNumber) &&
        !empty($month) && !empty($year) && !empty($cvv)
    ) {

        $sql = "INSERT INTO payment_details (user_id, category, cardHolderName, cardNumber, month, year, cvv) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isssssi", $user_id, $category, $cardHolderName, $cardNumber, $month, $year, $cvv);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Payment Successfully Processed!'); window.location.href='checkout.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error: Payment not successful.'); window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('Please fill in all fields.'); window.history.back();</script>";
        exit();
    }
}


// Ensure your database connection file is included

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Step 1: Insert the order data into the orders table
    if (isset($_POST['subtotal'], $_POST['discount'], $_POST['finaltotal'])) {
        $subtotal = $_POST['subtotal'];
        $discount = $_POST['discount'];
        $finaltotal = $_POST['finaltotal'];

        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Use null if the user is not logged in

        // Insert order data into orders table
        $sql = "INSERT INTO orders (user_id, subtotal, discount, finaltotal) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iddd", $user_id, $subtotal, $discount, $finaltotal);
        if (!$stmt->execute()) {
            die("Error inserting order: " . $stmt->error);
        }

        // Get the order ID of the newly inserted order
        $order_id = $stmt->insert_id;
        $stmt->close();

        // Step 2: Insert the order items into the order_items table
        if (isset($_POST['product_id'], $_POST['product_name'])) {
            $product_ids = $_POST['product_id'];
            $product_names = $_POST['product_name'];
            $product_prices = $_POST['product_price'];
            $product_quantities = $_POST['product_quantity'];
            $product_totals = $_POST['product_total'];

            for ($i = 0; $i < count($product_ids); $i++) {
                $product_id = $product_ids[$i];
                $name = $product_names[$i];
                $price = $product_prices[$i];
                $quantity = $product_quantities[$i];
                $total = $product_totals[$i];

                // Insert order product into the order_items table
                $sql = "INSERT INTO order_itemss (user_id, order_id, product_id, product_name, product_price, product_quantity, total)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iiisddi", $user_id, $order_id, $product_id, $name, $price, $quantity, $total);
                if (!$stmt->execute()) {
                    die("Error inserting order items: " . $stmt->error);
                }
                $stmt->close();

                // Step 3: Update the sold_quantity in products table
                $update_sql = "UPDATE products SET sold_quantity = sold_quantity + ? WHERE id = ?";
                $stmt = $conn->prepare($update_sql);
                $stmt->bind_param("ii", $quantity, $product_id);
                if (!$stmt->execute()) {
                    die("Error updating sold_quantity: " . $stmt->error);
                }
                $stmt->close();
            }
        } else {
            die("Error: No products found in POST request.");
        }

        unset($_SESSION['cart']); // Remove cart data from session

        // Step 4: Redirect to home page with alert
        echo "<script>
                alert('Your order has been successfully placed!');
                window.location.href = 'index.php';
              </script>";
        exit();
    }
}
?>






<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style/styles.css">

    <style>
        @media (max-width: 992px) {
            .form-control {
                width: 90% !important;
                max-width: 800px;
                margin: 0 auto;
            }

            .col-md-6 {
                width: 90% !important;
                margin: 0 auto;
            }

            .btn-warning {
                width: 90% !important;
                max-width: 250px;
                margin: 20px auto;
                display: block;
            }
        }

        @media (max-width: 768px) {
            .form-control {
                width: 600px !important;
                max-width: 1000px;
            }

            .col-md-6 {
                width: 100% !important;
            }
        }
    </style>
</head>

</head>

<body>


    <div class="container">



        <!-- Mobile Header -->
        <header class="mobile-nav p-3">
            <div class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></div>
            <a href="index.php" class="navbar-brand">
                <img src="images/logo-black.svg" alt="Logo" class="logo" width="150px">
            </a>
            <a href="mycart.php"><i class="bi bi-cart3"></i></a>
        </header>

        <!-- Desktop Header -->
        <header class="desktop-nav py-3">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="d-flex gap-5">
                    <a href="wishlist.php"><i class="bi bi-heart"></i></a>
                    <a href="javascript:void(0);" onclick="openSearch('desktopSearch')"><i
                            class="bi bi-search nav-link "></i></a>

                </div>
                <nav class="d-flex align-items-center">
                    <ul class="nav">
                        <li class="nav-item"><a href="news.php" class="nav-link">News</a></li>
                        <li class="nav-item"><a href="collection.php" class="nav-link">Shop</a></li>
                    </ul>
                    <a href="index.php" class="navbar-brand mx-4">
                        <img src="images/logo-black.svg" alt="Logo" class="logo" width="225px">
                    </a>
                    <ul class="nav">
                        <li class="nav-item"><a href="faq.php" class="nav-link">FAQ</a></li>
                        <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
                    </ul>
                </nav>
                <div class="d-flex gap-5 align-items-center">
                    <!-- Profile Dropdown -->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                            id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person" style="font-size: 24px;"></i>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <span class="ms-2"
                                    style="text-transform: none;"><?php echo htmlspecialchars($_SESSION['first_name']); ?></span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <li><a class="dropdown-item" href="profile.php" style="color:#000;">Profile</a></li>
                                <li><a class="dropdown-item" href="./php/logout.php" style="color:#000;">Logout</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="login.php" style="color:#000;">Login</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>



                    <a href="mycart.php"><i class="bi bi-cart3" style="color: #000;"></i></a>

                </div>
            </div>
        </header>

        <!-- Search Bar for Desktop -->
        <div class="search-popup" id="desktopSearch" style="border: 1px solid black;">
            <div class="search-box">
                <input type="text" placeholder="&nbsp; &nbsp; &nbsp; Search..." class="search-input">
                <button class="search-close" onclick="closeSearch('desktopSearch')"><i class="bi bi-x"></i></button>
            </div>
        </div>

        <!-- Search Bar for Mobile -->
        <div class="search-popup mobile-search" id="mobileSearch">
            <div class="search-box">
                <input type="text" placeholder="Search..." class="search-input">
                <button class="search-close" onclick="closeSearch('mobileSearch')"><i class="bi bi-x"></i></button>
            </div>
        </div>

        <!-- Mobile Sidebar Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <div class="menu-header">
                <button class="menu-icon search-btn" id="mobileSearchIcon"><i class="bi bi-search"></i></button>
                <!-- Hidden Search Bar (Initially Hidden) -->
                <div class="search-bar" id="mobileSearchBar">
                    <input type="text" class="search-input" placeholder="Search...">
                </div>
                <button class="menu-icon close-btn" id="closeMenu"><i class="bi bi-x"></i></button>
            </div>



            <nav class="menu-links">
                <a href="news.php">News</a>
                <a href="collection.php">Shop</a>
                <a href="faq.php">FAQ</a>
                <a href="about.php">About</a>
            </nav>

            <!-- Icons Section -->
            <div class="menu-icons">
                <a href="profile.php"><i class="bi bi-person"></i> Profile</a>
                <a href="wishlist.php"><i class="bi bi-heart"></i> Wishlist</a>
            </div>
        </div>


        <div class="container">
            <div class="d-flex justify-content-center mt-5">
                <span style="text-decoration: underline; text-decoration-color: #FC8C1C; text-underline-offset: 6px;">
                    <h3 style="font-size: 30px;">Check out</h3>
                </span>
            </div>

            <div class="row mt-5">
                <div class="col-12 col-md-5">
                    <h6 style="font-size: 28px; font-weight: 500; font-family: poppins; margin-bottom: 15%;"><b>Shipping
                            Details</b></h6>
                    <form class="mt-4" method="post" action="checkout.php">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6">
                                <div class="mb-3 position-relative">
                                    <i class="bi bi-person position-absolute"
                                        style="left: 10px; top: 50%; transform: translateY(-50%); color: #F29D38; font-size: 1.2rem;"></i>
                                    <input type="text" class="form-control" id="fullName" name="name"
                                        placeholder="Full Name">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3 position-relative">
                                    <i class="bi bi-telephone"
                                        style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #F29D38; font-size: 1.1rem; padding-left: 10px;"></i>
                                    <input type="text" class="form-control" id="fullName" name="phone"
                                        placeholder="Phone Number" style="padding-left: 40px;">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <i class="bi bi-geo-alt"
                                style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #F29D38; font-size: 1.1rem; padding-left: 10px;"></i>
                            <input type="text" class="form-control" id="fullName" name="address" placeholder="Address"
                                style="padding-left: 50px; padding-right: 20px; width: 100%; height: 80px;">
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-warning" name="submit_address"
                                style=" font-size:13px;  font-family: poppins; width: 150px; background-color: #FC8C1C; color: white; border-color: #FC8C1C;">
                                Save Address
                            </button>
                        </div>
                    </form>

                    <div class="card-body mt-5">
                        <h6 class="mb-3"
                            style="font-size: 28px; font-weight: 500; font-family: poppins; margin-bottom: 15%;">
                            <b>Payment Details</b></h6>
                        <form class="form mt-5" id="detail-form" method="POST" action="checkout.php">
                            <div style="margin-top: 20%;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="display: flex; align-items: center; margin-right: 3%;">
                                        <input type="radio" name="category" value="mastercard" id="mastercard" required
                                            style="margin-right: 10px; width: 20px; height: 20px; accent-color:rgb(0, 0, 0);">
                                        <label for="mastercard" style="margin: 0; cursor: pointer;">
                                            <button type="button"
                                                style="border-radius: 15px; border-color: #FC8C1C; border-width: 13px; border-style: solid; background: none; padding: 0; cursor: pointer;">
                                                <img src="./images/Mastercard.png" alt="Card Image" class="img-fluid"
                                                    style="height: 25px;">
                                            </button>
                                        </label>
                                    </div>

                                    <div style="display: flex; align-items: center;">
                                        <input type="radio" name="category" value="visa" id="visa" required
                                            style="margin-right: 10px; width: 20px; height: 20px; accent-color:rgb(0, 0, 0);">
                                        <label for="visa" style="margin: 0; cursor: pointer;">
                                            <button type="button"
                                                style="border-radius: 15px; border-color: #FC8C1C; border-width: 13px; border-style: solid; background: none; padding: 0; cursor: pointer;">
                                                <img src="./images/Visa.png" alt="Card Image" class="img-fluid"
                                                    style="height: 25px;">
                                            </button>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 position-relative mt-3">
                                <i class="bi bi-person-lines-fill"
                                    style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #F29D38; font-size: 1.2rem; padding-left: 10px;"></i>
                                <input type="text" class="form-control" name="cardHolderName"
                                    placeholder="Cardholder Name" required style="padding-left: 40px;">
                            </div>

                            <div class="mb-3 position-relative">
                                <i class="bi bi-person-vcard"
                                    style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #F29D38; font-size: 1.2rem; padding-left: 10px;"></i>
                                <input type="text" class="form-control" name="cardNumber" placeholder="Card Number"
                                    required style="padding-left: 40px;" maxlength="16" pattern="\d{16}">
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="mb-3 position-relative">
                                        <i class="bi bi-calendar-month"
                                            style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #F29D38; font-size: 1.2rem; padding-left: 10px;"></i>
                                        <input type="text" class="form-control" name="month" placeholder="MM" required
                                            style="padding-left: 40px;" maxlength="2" pattern="(0[1-9]|1[0-2])">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="mb-3 position-relative">
                                        <i class="bi bi-calendar-date-fill"
                                            style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #F29D38; font-size: 1.2rem; padding-left: 10px;"></i>
                                        <input type="text" class="form-control" name="year" placeholder="YYYY" required
                                            style="padding-left: 40px;" maxlength="4" pattern="\d{4}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="mb-3 position-relative">
                                        <i class="bi bi-bag-plus"
                                            style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #F29D38; font-size: 1.2rem; padding-left: 10px;"></i>
                                        <input type="text" class="form-control" name="cvv" placeholder="CVV" required
                                            style="padding-left: 40px;" maxlength="3" pattern="\d{3}">
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-warning mb-5" name="submit_details"
                                    style="width: 150px; font-size:13px; font-family: poppins; background-color: #FC8C1C; color: white; border-color: #FC8C1C;">
                                    Save Details
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-2"></div>

                <div class="col-12 col-md-5">
                    <div class="row">
                        <div class="col-1 d-none d-md-block">
                            <div class="box">
                                <div class="circle"></div>
                                <div class="circle" id="checkout"></div>
                            </div>
                        </div>
                        <div class="col-12 col-md-11">
                            <div class="order-summary" id="firstdiv">
                                <form method="POST" action="">

                                    <h5 class="mb-5">Order Summary</h5>
                                    <div class="odersummary" id="odersummary">
                                        <p>Item &nbsp &nbsp &nbsp &nbsp &nbsp : <span
                                                class="float-end text-end"><?php echo $totalQuantity ?></span></p>
                                        <p>Sub Total &nbsp : <span
                                                class="float-end text-end"><?php echo number_format($subtotal, 2); ?></span>
                                        </p>
                                        <p>Discount &nbsp &nbsp: <span
                                                class="float-end text-end">-<?php echo number_format($discount); ?></span>
                                        </p>
                                        <hr>
                                        <p class="total">Total Amount: <span
                                                class="float-end text-end">$<?php echo number_format($finaltotal); ?></span>
                                        </p>
                                    </div>
                                    <hr>
                                    <h5 class="mt-5 mb-5">Shipping Summary</h5>
                                    <p>K D Harshi</p>
                                    <p>No 63/1, Somadasa Road</p>
                                    <p>Colombo 5</p>
                                    <br><br><br><br><br><br><br>
                            </div>



                            <form method="POST" action="">
                                <input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>">
                                <input type="hidden" name="discount" value="<?php echo $discount; ?>">
                                <input type="hidden" name="finaltotal" value="<?php echo $finaltotal; ?>">

                                <?php
                                if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                                    foreach ($_SESSION['cart'] as $index => $item) {
                                        $total = $item['price'] * $item['quantity'];
                                        ?>
                                        <!-- Hidden inputs for each product -->
                                        <input type="hidden" name="product_id[]"
                                            value="<?php echo htmlspecialchars($item['id']); ?>">
                                        <input type="hidden" name="product_name[]"
                                            value="<?php echo htmlspecialchars($item['name']); ?>">
                                        <input type="hidden" name="product_price[]"
                                            value="<?php echo htmlspecialchars($item['price']); ?>">
                                        <input type="hidden" name="product_quantity[]" value="<?php echo $item['quantity']; ?>">
                                        <input type="hidden" name="product_total[]"
                                            value="<?php echo number_format($total, 2); ?>">
                                    <?php
                                    }
                                }
                                ?>

                                <button type="submit" class="confirm-btn" id="confirm"
                                    style="height: 100px; font-size: 25px;">
                                    Confirm <i class="bi bi-check-circle custom-icon-space"></i>
                                </button>
                            </form>


                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>






        <!-- Footer Section -->
        <footer class="footer mt-5">
            <div class="container">
                <div class="row">
                    <!-- Column 1 -->
                    <div class="col-lg-4 column-gap">
                        <img src="images/logo-white.svg" alt="Logo" class="footer-logo" width="300px"
                            style="margin-left: -20px;">
                        <hr>
                        <p class="footer-text">Absolutely love this watch! The design is elegant, and the quality is
                            amazing. It’s comfortable to wear and looks great for any occasion. Fast shipping and
                            well-packaged. Highly recommend!</p>
                        <div class="social-icons">
                            <a href="#"><i class="bi bi-facebook"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                            <a href="#"><i class="bi bi-youtube"></i></a>
                            <a href="#"><i class="bi bi-twitter"></i></a>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="col-lg-2 text column-gap">
                        <h4 class="menu-title">Quick Menu</h4>
                        <hr>
                        <ul class="footer-menu">
                            <li><a href="#">News</a></li>
                            <li><a href="#">Shop</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Wishlist</a></li>
                            <li><a href="#">Cart</a></li>
                        </ul>
                    </div>

                    <!-- Column 3 -->
                <div class="col-lg-4">
                    <h4 class="menu-title">Contact Us</h4>
                    <hr>
                    <p class="footer-contact-us"><i class="bi bi-geo-alt-fill"></i> 367, lotus street, galle</p>
                    <p class="footer-contact-us"><i class="bi bi-telephone-fill"></i> 0773234685</p>
                    <p class="footer-contact-us"><i class="bi bi-envelope-fill"></i> sampleemailaddress.com</p>

                    <h4 class="menu-title" style=" margin-top: 30px;">Payment Methods</h4>
                    <hr>
                    <div class="payment-icons">
                        <img src="images/koko.png" alt="koko">
                        <img src="images/visa.png" alt="Visa">
                        <img src="images/Mastercard.png" alt="Mastercard">
                        <img src="images/American Express.png" alt="Amex">
                    </div>
                </div>
            </div>

                <!-- Footer Bottom -->
                <hr>
                <div class="footer-bottom d-flex justify-content-center align-items-center text-center">
                    <p class="footer-contact-us" style="padding-right: 100px;">All Copyrights Reserved ©HourMarkers</p>
                    <p>
                        <a href="#" style="font-weight: 100;">Privacy Policy</a>
                        <a href="#" style="font-weight: 100;">Terms of Use</a>
                    </p>
                </div>

            </div>
        </footer>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <script src="script.js"></script>

</body>

</html>