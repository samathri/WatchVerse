<?php
session_start();
include 'php/db.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']); // Sanitize input
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Create a cart item array
        $cart_item = [
            'id' => $product['id'],
            'name' => $product['productName'],
            'price' => $product['productPrice'],
            'image' => $product['productImage'],
            'quantity' => 1 // Default quantity

        ];

        // Initialize the cart if it's empty
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if product is already in cart, if so, increase quantity
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product['id']) {
                $item['quantity'] += 1;
                $found = true;
                break;
            }
        }

        // If not found, add new product to cart
        if (!$found) {
            $_SESSION['cart'][] = $cart_item;
        }


    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    // echo "<p>No product selected.</p>";
}


$sql = "SELECT * FROM products ORDER BY id DESC LIMIT 4";
$results = $conn->query($sql);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style/collection_style.css">
    <link rel="stylesheet" href="style/index.css">
    <link rel="stylesheet" href="style/styles.css">
    <style>
        .bi-trash3 {
            padding: 30px;
            color: #000;
        }
    </style>
</head>

<body>

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
                <a href="mycart.php"><i class="bi bi-cart3 nav-link active" style="color: #000;"></i></a>

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
            <button class="menu-icon search-btn" id="mobileSearchIcon"><i class="fas bi bi-search"></i></button>
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

    <h2 class="cart-title text-center">My Cart</h2>
    <hr class="cart-divider mx-auto">

    <div class="container">
        <div class="row">
            <!-- Left: Cart Items -->
            <div class="col-lg-7 col-md-12">

                <?php
                $subtotal = 0;
                $discount = 20;
                $finaltotal = 0;
                $alldiscount = 0;
                $totalQuantity = 0;
                if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                    foreach ($_SESSION['cart'] as $index => $item) {

                        $total = $item['price'] * $item['quantity'];
                        $subtotal += $total;
                        $totalQuantity += $item['quantity'];
                        ?>
                        <div class="cart-card d-flex align-items-center">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image"
                                class="cart-item-image">
                            <div class="cart-item-details">
                                <p class="cart-item-name"><strong><?php echo htmlspecialchars($item['name']); ?></strong></p>
                                <p class="cart-item-price"><?php echo htmlspecialchars($item['price']); ?></p>
                            </div>
                            <div class="cart-quantity-container d-flex">
                                <!-- Decrease Quantity -->
                                <a href="update_cart.php?action=decrease&index=<?php echo $index; ?>" class="btn btn-sm"
                                    title="Decrease Quantity">−</a>

                                <!-- Display Quantity -->
                                <p class="cart-quantity"><?php echo $item['quantity']; ?></p>

                                <!-- Increase Quantity -->
                                <a href="update_cart.php?action=increase&index=<?php echo $index; ?>" class="btn btn-sm"
                                    title="Increase Quantity">+</a>
                            </div>

                            <p class="cart-total-price">
                                <span>Total &nbsp; </span>

                                <span><?php echo $total ?> $</span>
                            </p>
                            <p></p>

                            <a href="remove_from_cart.php?index=<?php echo $index; ?>"><i class="bi bi-trash3"></i></a>


                        </div>
                        <?php
                    }
                } else {
                    echo "<p>Your cart is empty.</p>";
                }
                ?>
            </div>

            <!-- Right: Price Details -->

            <div class="col-lg-5 col-md-12">
                <div class="price-container">
                    <div class="price-bar">
                        <a href="#" class="dot-link active"></a>
                        <a href="#" class="dot-link"></a>
                    </div>
                    <h5 class="price-title">Price Details</h5>
                    <div class="price-box">
                        <div class="price-row">
                            <p>Item</p>
                            <!-- <p class="price-value"><?php echo count($_SESSION['cart']); ?></p> -->
                            <p class="price-value"><?php echo $totalQuantity ?></p>

                        </div>
                        <div class="price-row">
                            <p>Sub Total</p>
                            <p class="price-value"><?php echo $subtotal ?></p>
                        </div>
                        <div class="price-row">
                            <p>Discount</p>
                            <p class="price-value">- <?php echo $discount; ?> $</p> <!-- Display discount -->

                        </div>
                        <?php
                        $alldiscount = $subtotal * $discount / 100;
                        $finaltotal = $subtotal - $alldiscount;
                        ?>
                        <hr class="price-ruler">
                        <div class="price-row total">
                            <p>Total Amount</p>
                            <p class="price-total"> $<?php echo $finaltotal; ?></p>
                        </div>
                    </div>

                </div>
                <a><button class="checkout-btn"><a href="checkout.php" style="color:white">Check Out</a> <span
                            class="checkout-arrow">&raquo;</span></button></a>

            </div>

        </div>
    </div>


    <h2 class="cart-title text-center">Latest Items</h2>
    <hr class="cart-divider mx-auto">


    <div class="container">


        <div class="mt-5">
            <div class="row mt-5">
                <?php

                while ($row = mysqli_fetch_assoc($results)) {
                    ?>


                    <!-- Product Card 1 -->
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="product-card text-center p-3 position-relative">
                            <?php if ($row['type'] == 'New'): ?>
                                <div class="sale-badge">
                                    <button id="sale">NEW</button>
                                </div>
                            <?php endif; ?>
                            <div class="wishlist-icon-m">
                                <i class="bi bi-heart wishlist-btn-m"></i>
                            </div>

                            <img src="./images/rb_27322 1.png" class="img-fluid" alt="Watch">
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="productname"><?php echo htmlspecialchars($row['productName']); ?></h6>
                            <h6 class="mt-2 price">250$ <span class="old-price">270$</span></h6>
                        </div>
                        <h6 class="description">41 mm, steel - Sedna™ gold on leather strap</h6>
                        <div class="rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <span class="ratingnumber">(212)</span>
                        </div>
                        <button class="add-to-cart mt-2">Add To Cart</button>
                    </div>

                    <?php
                }

                ?>
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
                <p class="footer-contact-us" style="padding-right: 100px;">All Copyrights Reserved © ALANKARAGE HOLDINGS
                </p>
                <p>
                    <a href="#" style="font-weight: 100;">Privacy Policy</a>
                    <a href="#" style="font-weight: 100;">Terms of Use</a>
                </p>
            </div>

        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="script.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".wishlist-icon").forEach(icon => {
                icon.addEventListener("click", function () {
                    if (this.classList.contains("bi-heart")) {
                        this.classList.remove("bi-heart");
                        this.classList.add("bi-heart-fill");
                    } else {
                        this.classList.remove("bi-heart-fill");
                        this.classList.add("bi-heart");
                    }
                });
            });
        });
    </script>

    <script>
        function viewProduct(productId) {
            window.location.href = "checkout.php?id=" + productId;
        }
    </script>
</body>

</html>