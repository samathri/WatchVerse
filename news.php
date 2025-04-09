<?php
session_start();
include 'php/db.php';

$sql = "SELECT id, date, image, title, description FROM news";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Section</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style/styles.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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
                    <li class="nav-item"><a href="news.php" class="nav-link active">News</a></li>
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


    <div class="container">
        <!-- Title Section -->
        <h1 class="news-title text-center">News Articles</h1>
        <hr class="cart-divider mx-auto">

        <!-- News Section -->
        <div class="row g-4 mt-4">
            <!-- First Column: Main Article -->
            <div class="col-lg-6">
                <?php
                if ($result->num_rows > 0) {
                    $firstRow = $result->fetch_assoc();
                    ?>
                    <div class="news-item">
                        <img src="<?php echo htmlspecialchars($firstRow["image"]); ?>">
                        <div class="card-body">
                            <p class="date" style="margin-top: 10px; font-size: 18px;">
                                <?php echo htmlspecialchars($firstRow["date"]); ?></p>
                            <h4 class="card-title" style="margin-bottom: 10px;">
                                <?php echo htmlspecialchars($firstRow["title"]); ?></h4>
                            <p class="card-text"><?php echo htmlspecialchars($firstRow["description"]); ?></p>
                            <a href="#" class="btn btn-outline-dark read-more-btn">Read More</a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <!-- Second Column: Side Articles -->
            <div class="col-lg-6">
                <div class="row g-4">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-12">
                            <div class="d-flex align-items-start">
                                <img src="<?php echo htmlspecialchars($row["image"]); ?>" class="me-3" alt="Article Image">
                                <div>
                                    <p class="date"><?php echo htmlspecialchars($row["date"]); ?></p>
                                    <h6 class="fw-bold"><?php echo htmlspecialchars($row["title"]); ?></h6>
                                    <p class="small"><?php echo htmlspecialchars($row["description"]); ?></p>
                                    <a href="#" class="btn btn-outline-dark read-more-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Scrollable Image Section -->
        <div class="container">
            <h1 class="news-title text-center">Top News</h1>
            <hr class="cart-divider mx-auto" style="margin-bottom: 30px;">

            <div class="scroll-container">
                <div class="scroll-content">
                    <div class="image-card">
                        <img src="images/watch-1.png" alt="Image 1">
                        <div class="overlay">
                            <h5>Timeless Style, Perfected</h5>
                            <p>Find your perfect timepiece, where style meets precision</p>
                            <a href="#" class="btn-read">Read More</a>
                        </div>
                    </div>
                    <div class="image-card">
                        <img src="images/watch-2.png" alt="Image 2">
                        <div class="overlay">
                            <h5>Featuring Distinct Hour Markers</h5>
                            <p>Discover watches with unique hour markers, blending precision and style</p>
                            <a href="#" class="btn-read">Read More</a>
                        </div>
                    </div>
                    <div class="image-card">
                        <img src="images/watch-3.png" alt="Image 3">
                        <div class="overlay">
                            <h5>Hour Markers That Define Time!</h5>
                            <p>Watches with bold hour markers for a precise, stylish look.</p>
                            <a href="#" class="btn-read">Read More</a>
                        </div>
                    </div>
                    <div class="image-card">
                        <img src="images/watch-4.png" alt="Image 4">
                        <div class="overlay">
                            <h5>Hour Markers That Define Time!</h5>
                            <p>Watches with bold hour markers for a precise, stylish look.</p>
                            <a href="#" class="btn-read">Read More</a>
                        </div>
                    </div>
                    <div class="image-card">
                        <img src="images/watch-1.png" alt="Image 1">
                        <div class="overlay">
                            <h5>Timeless Style, Perfected</h5>
                            <p>Find your perfect timepiece, where style meets precision</p>
                            <a href="#" class="btn-read">Read More</a>
                        </div>
                    </div>
                    <div class="image-card">
                        <img src="images/watch-2.png" alt="Image 2">
                        <div class="overlay">
                            <h5>Featuring Distinct Hour Markers</h5>
                            <p>Discover watches with unique hour markers, blending precision and style</p>
                            <a href="#" class="btn-read">Read More</a>
                        </div>
                    </div>
                    <div class="image-card">
                        <img src="images/watch-3.png" alt="Image 3">
                        <div class="overlay">
                            <h5>Hour Markers That Define Time!</h5>
                            <p>Watches with bold hour markers for a precise, stylish look.</p>
                            <a href="#" class="btn-read">Read More</a>
                        </div>
                    </div>
                    <div class="image-card">
                        <img src="images/watch-4.png" alt="Image 4">
                        <div class="overlay">
                            <h5>Hour Markers That Define Time!</h5>
                            <p>Watches with bold hour markers for a precise, stylish look.</p>
                            <a href="#" class="btn-read">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter Section -->
        <div class="newsletter-container d-flex flex-column justify-content-center align-items-center">
            <h1 class="newsletter-title">Join Our Newsletter</h1>
            <p class="newsletter-description text-center">
                Subscribe now for exclusive updates on our latest watch collections and timeless designs.
            </p>

            <!-- Subscription Form -->
            <form class="newsletter-form d-flex">
                <input type="email" class="form-control" placeholder="Enter email" required>
                <button type="submit" class="btn btn-subscribe">Subscribe</button>
            </form>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>

<?php
$conn->close();
?>