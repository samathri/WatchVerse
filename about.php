<?php
session_start();
include 'php/db.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Header & Footer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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
                <a href="javascript:void(0);" onclick="openSearch('desktopSearch')"><i class="bi bi-search nav-link "></i></a>

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
                    <li class="nav-item"><a href="about.php" class="nav-link active">About</a></li>
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


    <h1 class="text-center mt-4">About Us</h1>
    <hr class="cart-divider mx-auto">
    
    <section class="hero-section-a text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-5">
                <div class="hero-content">
                    <img src="images/logo-white.svg" alt="Logo" class="footer-logo">
                    <p>Explore watches that match your style and elevate every moment. Find your perfect timepiece today. Explore watches that match your style and elevate every moment. Find your perfect timepiece today.</p>
                    <a href="#" id="btn1" class="btn btn-warning" style="margin-right: 20px;">Find Watch</a>
                    <a href="#" class="btn btn-warning">Buy Now</a>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="container my-5-a">
    <div class="row align-items-center">
        <div class="col-md-6">
            <img src="images/IMAGE1.png" class="img-fluid" alt="Watch">
        </div>
        <div class="col-md-6">
            <div class="ver-line">
                <h3>Vision</h3>
                <h5>Redefining Time, Inspiring Elegance</h5>
            </div>
            <p>Our vision is to redefine timekeeping by blending innovation, craftsmanship, and timeless design. We create watches that inspire elegance, celebrate life’s journey, and stand as enduring symbols of sophistication and quality. Each timepiece reflects our commitment to excellence and individuality. We aim to craft timeless treasures that </p>
            <button class="btn btn-outline-dark">Read more</button>
        </div>
    </div>
</section>



    <section class="container my-5-a mt-5">
        <div class="row align-items-center">
            <div class="col-md-6 order-md-2">
                <img src="images/IMAGE2.png" class="img-fluid" alt="Sketching a Watch">
            </div>
            <div class="col-md-6">
            <div class="ver-line">
                <h3>Mission</h3>
                <h5>Driven by Precision, Guided by Purpose</h5>
            </div>
            <p>Our mission is to craft exceptional timepieces that blend innovation and artistry, delivering quality, trust, and individuality to celebrate each customer's unique story. We aim to inspire timeless connections and create lasting memories, with every watch designed to reflect our commitment to precision and craftsmanship</p>
            <button class="btn btn-outline-dark">Read more</button>
        </div>
        </div>
    </section>
    
    
    
    <!-- Popular Brands Section -->
    <section class="brands">
        
    <h1 class="text-center mt-4">Popular Brands</h1>
    <hr class="cart-divider mx-auto" style="margin-bottom: 30px;">
        <div class="slider-container">
            <div class="brand-track">
                <div class="brand-logos" id="set1">
                    <img src="images/rolex.png" alt="Rolex">
                    <img src="images/casio.png" alt="Casio">
                    <img src="images/tag.png" alt="Tag Heuer">
                    <img src="images/tissot.svg" alt="Tissot">
                    <img src="images/patek.svg" alt="Patek">
                    <img src="images/jacob.svg" alt="Seiko">
                </div>
                <!-- Duplicate for seamless infinite scroll -->
                <div class="brand-logos" id="set2">
                    <img src="images/rolex.png" alt="Rolex">
                    <img src="images/casio.png" alt="Casio">
                    <img src="images/tag.png" alt="Tag Heuer">
                    <img src="images/tissot.svg" alt="Tissot">
                    <img src="images/patek.svg" alt="Patek">
                    <img src="images/jacob.svg" alt="Seiko">
                </div>
            </div>
        </div>
    </section>




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
   
</body>
</html>
