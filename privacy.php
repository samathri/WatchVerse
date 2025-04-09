<?php
session_start();
include 'php/db.php';

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="style/styles.css" rel="stylesheet">

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


    <div>
        <h1 style="text-align: center; font-size: 30px; font-family: 'Poppins', sans-serif;">Privacy Policy</h1>
    </div>
    <div class="divider-2"></div>






    <div class="container">



        <h2 class="title-h2">1. Name and Contact Information of the Controller and Data Privacy Officer</h2
            class="title-h2">
        <p class="content">The controller for the data processed on this website is:</p>
        <p class="content"><i class="bi bi-dot"></i>HourMarkers Ltd.<br>123 Watch Lane, TimeSquare, London, UK</p>
        <p class="content"><i class="bi bi-dot"></i>Email: <a class="email-link"
                href="mailto:info@hourmarkers.com">info@hourmarkers.com</a></p>
        <p class="content"><i class="bi bi-dot"></i>Phone: +44 123 4567 890</p>
        <p class="content">HourMarkers' Data Privacy Officer: <a class="email-link"
                href="mailto:privacy@hourmarkers.com">privacy@hourmarkers.com</a></p>

        <h2 class="title-h2">2. Information About Processors and Third-Country Transfers</h2 class="title-h2">
        <p class="content">HourMarkers may use service providers (processors) to handle personal data on our behalf. If
            data is transferred to a third country, HourMarkers ensures protection by:</p>
        <ul>
            <li class="content">Signing standard contractual clauses under GDPR regulations.</li>
            <li class="content">Working with partners who follow strong data protection measures.</li>
        </ul>

        <h2 class="title-h2">3. Collection and Use of Personal Data</h2 class="title-h2">

        <h3 class="content">3.1 Visiting the Website</h3>
        <p class="content">When visiting our website, we collect:</p>
        <ul>
            <li class="content">IP address</li>
            <li class="content">Date and time of access</li>
            <li class="content">Pages visited</li>
            <li class="content">Browser and OS details</li>
        </ul>
        <p class="content">This data helps ensure security and optimize user experience.</p>

        <h3 class="content">3.2 Registering as a User</h3>
        <p class="content">When you create an account, we collect:</p>
        <ul>
            <li class="content">Email address (mandatory)</li>
            <li class="content">Password (mandatory)</li>
            <li class="content">Full name, address, and phone number (optional)</li>
        </ul>
        <p class="content">This allows us to provide personalized services and manage accounts.</p>

        <h3 class="content">3.3 Shopping on HourMarkers</h3>
        <p class="content">When placing an order, we collect:</p>
        <ul>
            <li class="content">Billing and shipping address</li>
            <li class="content">Payment details (processed securely)</li>
        </ul>

        <h3 class="content">3.4 Cookies and Analytics</h3>
        <p class="content">We use cookies to improve your experience. Analytics tools help us understand website
            performance.</p>

        <h2 class="title-h2">4. Third-Party Services and Login Options</h2 class="title-h2">
        <p class="content">You can log in using Google or Apple. This may share the following data with us:</p>
        <ul>
            <li class="content">Full name</li>
            <li class="content">Email address</li>
            <li class="content">Profile picture</li>
        </ul>

        <h2 class="title-h2">5. Data Retention</h2 class="title-h2">
        <p class="content">We store personal data only as long as necessary:</p>
        <ul>
            <li class="content">Account data is stored until you delete your account.</li>
            <li class="content">Transaction data is kept for legal and tax purposes.</li>
        </ul>

        <h2 class="title-h2">6. Your Rights</h2 class="title-h2">
        <p class="content">Under GDPR, you have rights including:</p>
        <ul>
            <li class="content">Access: Request the data we store about you.</li>
            <li class="content">Correction: Fix incorrect information.</li>
            <li class="content">Deletion: Request account removal.</li>
            <li class="content">Objection: Object to data processing.</li>
        </ul>
        <p class="content">To exercise these rights, contact us at <a class="email-link"
                href="mailto:privacy@hourmarkers.com">privacy@hourmarkers.com</a>.</p>

        <h2 class="title-h2">7. Security Measures</h2 class="title-h2">
        <p class="content">We implement strong security measures to protect your data from unauthorized access.</p>

        <h2 class="title-h2">8. Updates to the Privacy Policy</h2 class="title-h2">
        <p class="content">This Privacy Policy may be updated as needed to reflect legal or business changes.</p>
        <p style="margin-top: 100px;"><strong>Last Updated: January 21, 2025</strong></p>
    </div>

</body>

</html>


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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>

</html>