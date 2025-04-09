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
        <h1 style="text-align: center; font-size: 30px; font-family: 'Poppins', sans-serif;">Hourmarkers Terms and
            Conditions</h1>
    </div>
    <div class="divider"></div>

    <div class="container">

        <h2 class="title-h2">1. Scope</h2>
        <p class="content">1.1 Hourmarkers operates as an online platform for buying and selling brand-new and pre-owned
            branded watches (hereinafter referred to as the "Platform").</p>
        <p class="content">1.2 These Terms apply to all users of the Platform, including buyers, sellers, and visitors.
        </p>
        <p class="content">1.3 By using the Platform, you accept these Terms and agree to abide by them.</p>

        <h2 class="title-h2">2. Registration and Account</h2>
        <p class="content">2.1 Registration is required to access certain features of the Platform. By registering, you
            represent that you are of legal age and have the authority to enter into contracts.</p>
        <p class="content">2.2 Users must provide accurate and up-to-date information during registration, including a
            valid email address.</p>
        <p class="content">2.3 You are responsible for maintaining the confidentiality of your account credentials and
            agree to notify Hourmarkers immediately if you suspect unauthorized use.</p>
        <p class="content">2.4 Each user is allowed only one account. Account sharing, transfer, or use by third parties
            is prohibited.</p>
        <p class="content">2.5 Hourmarkers reserves the right to suspend or terminate accounts in cases of suspected
            misuse or violation of these Terms.</p>

        <h2 class="title-h2">3. Use of the Platform</h2>
        <p class="content">3.1 Hourmarkers provides a platform for buyers and sellers to connect. Hourmarkers does not
            own or sell watches directly unless explicitly stated.</p>
        <p class="content">3.2 All sales contracts are formed exclusively between the buyer and the seller. Hourmarkers
            is not a party to these contracts and assumes no liability for the fulfillment of any agreements between
            users.</p>
        <p class="content">3.3 Users may not:</p>
        <ul>
            <li class="content">Use automated tools or scripts to scrape, copy, or interact with the Platform’s content.
            </li>
            <li class="content">Disrupt or attempt to interfere with the operation of the Platform.</li>
            <li class="content">Post content that is unlawful, fraudulent, or infringes on third-party rights.</li>
        </ul>
        <p class="content">3.4 Hourmarkers reserves the right to modify, suspend, or discontinue any features of the
            Platform at any time without prior notice.</p>

        <h2 class="title-h2">4. Listing and Purchasing</h2>
        <p class="content">4.1 Sellers are responsible for providing accurate, complete, and truthful information about
            the watches they list on the Platform. Hourmarkers does not verify the accuracy of these listings.</p>
        <p class="content">4.2 Buyers must exercise due diligence and review all details of a listing before making a
            purchase. Hourmarkers is not liable for disputes arising from misrepresented or inaccurate listings.</p>
        <p class="content">4.3 Hourmarkers may, at its discretion, remove or block listings that violate these Terms or
            applicable laws.</p>

        <h2 class="title-h2">5. Fees and Payments</h2>
        <p class="content">5.1 Registration on the Platform is free. However, Hourmarkers may charge fees for premium
            features, advertising, or other services. These fees will be clearly communicated before purchase.</p>
        <p class="content">5.2 Buyers and sellers are responsible for any taxes, duties, or fees associated with their
            transactions.</p>
        <p class="content">5.3 Hourmarkers may charge a transaction fee for sales completed on the Platform. Such fees
            will be disclosed to sellers in advance.</p>

        <h2 class="title-h2">6. User Obligations</h2>
        <p class="content">6.1 Users must comply with all applicable laws when using the Platform. This includes
            adhering to local regulations regarding the sale or purchase of luxury goods.</p>
        <p class="content">6.2 Users may not use the Platform to send unsolicited communications (spam) or engage in
            fraudulent activities.</p>
        <p class="content">6.3 Users are required to report any suspicious activity, misuse, or breaches of these Terms
            to Hourmarkers immediately.</p>

        <h2 class="title-h2">7. Liability and Warranties</h2>
        <p class="content">7.1 Hourmarkers strives to provide a reliable and uninterrupted service but cannot guarantee
            the Platform’s availability at all times.</p>
        <p class="content">7.2 Hourmarkers does not pre-screen user-generated content or listings and is not responsible
            for inaccuracies or misrepresentations.</p>
        <p class="content">7.3 To the extent permitted by law, Hourmarkers disclaims liability for:</p>
        <ul>
            <li class="content">Any direct or indirect damages resulting from use of the Platform.</li>
            <li class="content">Transactions or disputes between buyers and sellers.</li>
            <li class="content">Loss of data, revenue, or profits.</li>
        </ul>
        <p class="content">7.4 Nothing in these Terms limits Hourmarkers’ liability for intentional misconduct, gross
            negligence, or statutory obligations.</p>

        <h2 class="title-h2">8. Termination</h2>
        <p class="content">8.1 Users may terminate their account at any time by contacting Hourmarkers support or using
            the account deletion feature.</p>
        <p class="content">8.2 Hourmarkers reserves the right to terminate or suspend access to the Platform for users
            who violate these Terms or engage in prohibited conduct.</p>
        <p class="content">8.3 Upon termination, users lose access to their accounts and any associated data, except as
            required by law.</p>

        <h2 class="title-h2">9. Intellectual Property</h2>
        <p class="content">9.1 All content on the Platform, including text, images, logos, and software, is the property
            of Hourmarkers or its licensors and is protected under copyright and intellectual property laws.</p>
        <p class="content">9.2 Users may not reproduce, distribute, or modify Platform content without prior written
            consent from Hourmarkers.</p>

        <h2 class="title-h2">10. Data Protection</h2>
        <p class="content">10.1 Hourmarkers handles user data in accordance with its Privacy Policy. By using the
            Platform, you consent to the collection, processing, and storage of your data as described in the Privacy
            Policy.</p>

        <h2 class="title-h2">11. Indemnification</h2>
        <p class="content">11.1 Users agree to indemnify and hold Hourmarkers harmless from any claims, damages, or
            expenses arising out of their use of the Platform or violation of these Terms.</p>
        <p class="content">11.2 Hourmarkers reserves the right to assume the exclusive defense and control of any matter
            subject to indemnification by a user.</p>

        <h2 class="title-h2">12. Governing Law and Dispute Resolution</h2>
        <p class="content">12.1 These Terms are governed by the laws of Sri Lanka.</p>
        <p class="content">12.2 Any disputes arising from or relating to these Terms or the use of the Platform shall be
            resolved through arbitration or mediation in accordance with local laws.</p>

        <h2 class="title-h2">13. Amendments</h2>
        <p class="content">13.1 Hourmarkers reserves the right to update these Terms at any time. Users will be notified
            of significant changes via email or Platform notifications.</p>
        <p class="content">13.2 Continued use of the Platform after changes to these Terms constitutes acceptance of the
            updated Terms.</p>

        <h2 class="title-h2">14. Contact Us</h2>
        <p class="content">For any questions, concerns, or support, please contact us at:</p>
        <p class="content"><i class="bi bi-dot"></i>Hourmarkers Support.<br>Email: <a class="email-link"
                href="mailto:support@hourmarkers.com">support@hourmarkers.com</a><br>Phone: 01178945612</p>

        <p class="content" style="margin-top: 100px;"><strong>Last Updated: January 21, 2025</strong></p>
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
</body>

</html>