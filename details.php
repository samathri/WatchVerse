<?php
session_start();
include 'php/db.php';


if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']); // Sanitize input
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p>Product not found.</p>";
        exit;
    }
} else {
    echo "<p>No product selected.</p>";
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style/styles.css">
    <style>
        /* Tab Navigation Styling */
        .tg-nav-underline .tg-nav-link {
            color: black;
            font-weight: 400 !important;
            margin: 30px 20px;

        }

        .tg-nav-underline .tg-nav-link.active {
            color: #000;
            border-bottom: 3px solid #FC8C1C;
            font-weight: bold !important;

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


    <div class="tg-custom-product">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="tg-custom-div">
                        <ul class="nav tg-nav-underline">
                            <li class="tg-nav-item">
                                <a class="tg-nav-link" href="#" style="color: #fff;">3D VIEW</a>
                            </li>
                            <li class="tg-nav-divider"></li>
                            <li class="tg-nav-item">
                                <a class="tg-nav-link active" href="#" style="color: #fff;">GALLERY</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tg-watch-image mt-4">
                        <img src="<?php echo htmlspecialchars($row['productImage']); ?>" alt="Placeholder Image"
                            class="img-fluid rounded" style="width:350px">
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0" style="line-height: 80px;">
                    <div class="tg-caption-title">
                        COMPLIMENTARY STRAP
                    </div>
                    <div>
                        <h2 class="text-white"><?php echo htmlspecialchars($row['productName']); ?></h2>
                    </div>
                    <div>
                        <h2 class="text-white" style="font-size: 15px; line-height: 50px;">
                            <?php echo htmlspecialchars($row['thickness']); ?>,
                            <?php echo htmlspecialchars($row['materials']); ?></h2>
                    </div>
                    <div>
                        <h3 class="text-white text-decoration-underline" style="font-size: 13px;">DESCRIPTION</h3>
                    </div>
                    <div>
                        <h4 class="text-white" style="font-size: 13px;">
                            <?php echo htmlspecialchars($row['description']); ?></h4>
                    </div>
                    <div>
                        <a class="tg-nav-link text-white text-decoration-underline" href="#">
                            <i class="bi bi-caret-right" style="font-size: 13px;"></i>Customize it
                        </a>
                    </div>
                    <div>
                        <h4 class="text-white" style="font-size: 15px; line-height: 50px;">
                            <?php echo htmlspecialchars($row['productPrice']); ?> $</h4>
                    </div>
                    <div class="tg-mainbutton">
                        <button class="tg-btn-add-to-cart" onclick="viewProduct(<?php echo $row['id']; ?>)">ADD TO
                            CART</button>
                        <button class="tg-btn-buy">BUY</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tg-online">
        <div class="container">
            <h1 class="text-black" style="font-size: 20px; padding: 40px 0;">ONLINE SERVICES</h1>
            <div class="tg-onlinebutton">
                <button>Complimentary Delivery</button>
                <button>Exclusive Online Packaging</button>
                <button>Automatic Warranty</button>
                <button>Pay Later with PayPal</button>
            </div>
        </div>
    </div>

    <div class="tg-goal">
        <div class="container text-center">
            <h1>Stay ahead of your <span>Goals</span></h1>
            <div class="tg-line"></div>
            <h6>"Time is your most valuable asset—once a moment passes, it never returns. Let every tick of the clock
                remind
                you to chase your dreams,
                stay focused, and make the most of every second"</h6>
        </div>
    </div>


    <div class="container mt-4">
        <!-- Tab Navigation -->
        <ul class="nav tg-nav-underline justify-content-center" id="productTabs" role="tablist" style="margin: 50px 0;">
            <li class="tg-nav-item">
                <a class="tg-nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                    role="tab">Details</a>
            </li>
            <li class="tg-nav-item">
                <a class="tg-nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications"
                    role="tab">Specifications</a>
            </li>
            <li class="tg-nav-item">
                <a class="tg-nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                    role="tab">Reviews</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-4" id="productTabContent">
            <!-- Details Tab -->
            <div class="tab-pane fade show active" id="details" role="tabpanel">
                <!-- Details Content -->
                <div class="tg-detail-list">
                    <div id="build-design" class="tg-detail p-3">
                        <h1 class="tg-detail-title">Build and Design</h1>
                        <div class="tg-divider"></div>
                        <h4 style="color: #FC8C1C;">A sleek and durable design</h4>
                        <p style="line-height: 2;">A sleek round stainless steel case with a durable sapphire crystal.
                            Features a leather strap for a classic look, water-resistant up to 50m.</p>
                    </div>
                    <div id="functionality" class="tg-detail p-3">
                        <h1 class="tg-detail-title">Functionality</h1>
                        <div class="tg-divider"></div>
                        <h4 style="color: #FC8C1C;">Smart and practical features</h4>
                        <p style="line-height: 2;">Driven by a precise quartz movement for accurate timekeeping.
                            Includes a date display and luminous hands for enhanced readability in low light. The
                            smartwatch variant expands functionality with Bluetooth connectivity for syncing
                            notifications, fitness tracking, heart rate monitoring, and built-in GPS for activity
                            tracking. Features an intuitive touch display for easy navigation, multiple watch face
                            options, and compatibility with both iOS and Android devices.

                        </p>
                    </div>
                    <div id="additional-features" class="tg-detail p-3">
                        <h1 class="tg-detail-title">Additional Features</h1>
                        <div class="tg-divider"></div>
                        <h4 style="color: #FC8C1C;">Extra perks for the modern user</h4>
                        <p style="line-height: 2;">Includes an interchangeable strap for versatile styling, a compact
                            charging dock (for the smart version), and a 1-year international warranty for peace of
                            mind.</p>
                    </div>
                </div>
            </div>

            <!-- Specifications Section -->
            <div class="tab-pane fade specifications-container" id="specifications" role="tabpanel">
                <h3 class="accordion-title mb-4 text-center" style="color: black; letter-spacing: 2px; ">Technical
                    Specifications</h3>

                <div class="accordion" id="specificationsAccordion">
                    <!-- Case -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne">
                                Case
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse"
                            data-bs-parent="#specificationsAccordion">
                            <div class="accordion-body">
                                The TAG Heuer Connected Calibre E4 Golf Edition features a 45mm titanium case.
                            </div>
                        </div>
                    </div>

                    <!-- Strap/Bracelet -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo">
                                Strap/Bracelet
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse"
                            data-bs-parent="#specificationsAccordion">
                            <div class="accordion-body">
                                The watch comes with a premium rubber strap designed to fit various wrist sizes.
                            </div>
                        </div>
                    </div>

                    <!-- Battery -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree">
                                Battery
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse"
                            data-bs-parent="#specificationsAccordion">
                            <div class="accordion-body">
                                Powered by a rechargeable lithium-ion battery, offering up to 24 hours of usage.
                            </div>
                        </div>
                    </div>

                    <!-- Display -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour">
                                Display
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse"
                            data-bs-parent="#specificationsAccordion">
                            <div class="accordion-body">
                                1.39-inch OLED touchscreen display with high-resolution clarity.
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Reviews Tab -->
            <div class="tab-pane fade" id="reviews" role="tabpanel">

                <h1 class="reviews-title-custom">Product Reviews</h1>
                <div class="divider-custom"></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 text-center">
                            <div class="review-box-custom">
                                <h3>John Doe</h3>
                                <p class="stars-custom">⭐⭐⭐⭐⭐</p>
                                <p>Stunning design and top-notch functionality. Highly recommended!</p>
                            </div>
                            <div class="review-box-custom">
                                <h3>Jane Smith</h3>
                                <p class="stars-custom">⭐⭐⭐⭐</p>
                                <p>Great for golf enthusiasts. Accurate GPS and impressive battery life.</p>
                            </div>
                            <div class="review-box-custom">
                                <h3>Mike Johnson</h3>
                                <p class="stars-custom">⭐⭐⭐⭐⭐</p>
                                <p>Game-changer for fitness. Accurate heart rate monitor and user-friendly interface.
                                </p>
                            </div>
                            <div class="review-box-custom">
                                <h3>Sarah Lee</h3>
                                <p class="stars-custom">⭐⭐⭐</p>
                                <p>Good watch, but the price is a bit steep for the design.</p>
                            </div>
                            <div class="review-box-custom">
                                <h3>Chris Brown</h3>
                                <p class="stars-custom">⭐⭐⭐⭐⭐</p>
                                <p>Best smartwatch ever! Excellent build quality and useful golf features.</p>
                            </div>
                        </div>
                    </div>
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
                <p class="footer-contact-us" style="padding-right: 100px;">All Copyrights Reserved © ALANKARAGE HOLDINGS
                </p>
                <p>
                    <a href="#" style="font-weight: 100;">Privacy Policy</a>
                    <a href="#" style="font-weight: 100;">Terms of Use</a>
                </p>
            </div>

        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>

    <script>
        function viewProduct(productId) {
            window.location.href = "mycart.php?id=" + productId;
        }
    </script>
</body>

</html>