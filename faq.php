<?php
session_start();
include 'php/db.php';

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
  <link href="style/styles.css" rel="stylesheet">
  <link href="script.js" rel="stylesheet">
</head>

<body>

  <!-- Mobile Header -->
  <header class="mobile-nav p-3">
    <div class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></div>
    <a href="home.php" class="navbar-brand">
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
        <a href="home.php" class="navbar-brand mx-4">
          <img src="images/logo-black.svg" alt="Logo" class="logo" width="225px">
        </a>
        <ul class="nav">
          <li class="nav-item"><a href="faq.php" class="nav-link active">FAQ</a></li>
          <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
        </ul>
      </nav>
      <div class="d-flex gap-5 align-items-center">
        <!-- Profile Dropdown -->
        <div class="dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" id="dropdownMenuLink"
            data-bs-toggle="dropdown" aria-expanded="false">
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
    <div class="d-flex justify-content-center mt-5">
      <span style="text-decoration: underline; text-decoration-color: #FC8C1C; text-underline-offset: 10px;">
        <h3 style="font-size: 30px;">FAQ</h3>
      </span>
    </div>
    <div class="row">
      <div class="col-12 col-md-5">
        <h1 class="first">Let's Make Something Awesome Together .....</h1>
        <div class="second_p">
          <p class="ff">We’re not just another watch company – we’re your timeless style partners. With years of
            craftsmanship and innovation, our team is dedicated to delivering premium quality watches that make every
            moment unforgettable.</p>
        </div>
        <hr id="breaklinefaq">
        <div class="third d-flex align-items-center gap-5">
          <label><img src="./images/high-quality.png" style="width: 50px; height: 50px;"></label>
          <label class="mb-0">Top-Quality Service</label>
        </div>
        <div class="third d-flex align-items-center gap-5 mt-3">
          <label><img src="./images/product (1).png" style="width: 50px; height: 50px;"></label>
          <label class="mb-0">Product Excellence</label>
        </div>
        <div class="third d-flex align-items-center gap-5 mt-3">
          <label><img src="./images/top-up2.png" style="width: 50px; height: 50px;"></label>
          <label class="mb-0">Seamless Shopping Experience</label>
        </div>

        <hr id="breaklinefaq" style="color: #FC8C1C;">
      </div>
      <div class="col-12 col-md-2"></div>
      <div class="col-12 col-md-5">
        <div class="right_side">
          <div class="faq-item">
            <div class="faq-box" onclick="toggleFaq(this)">
              <span>Are the watches pre-owned or brand new?</span>
              <i class="bi bi-plus faq-icon"></i>
            </div>
            <div class="faq-answer">
              <p>We offer both pre-owned and brand-new watches, all thoroughly inspected for authenticity.</p>
            </div>
          </div>
          <br>
          <div class="faq-item mt-3">
            <div class="faq-box" onclick="toggleFaq(this)">
              <span>What kind of warranty do you offer on your watches?</span>
              <i class="bi bi-plus faq-icon"></i>
            </div>
            <div class="faq-answer">
              <p>We offer a 1-year warranty on all our watches, whether pre-owned or brand new.</p>
            </div>
          </div>
          <br>
          <div class="faq-item mt-3">
            <div class="faq-box" onclick="toggleFaq(this)">
              <span>How can I check the availability of a watch?</span>
              <i class="bi bi-plus faq-icon"></i>
            </div>
            <div class="faq-answer">
              <p>You can check the availability directly on our website or contact our customer service team for
                assistance.</p>
            </div>
          </div>
          <br>
          <div class="faq-item mt-3">
            <div class="faq-box" onclick="toggleFaq(this)">
              <span>Do you ship internationally?</span>
              <i class="bi bi-plus faq-icon"></i>
            </div>
            <div class="faq-answer">
              <p>Yes, we offer international shipping to most countries. Please check our shipping policy for more
                details.</p>
            </div>
          </div>
          <br>
          <div class="faq-item mt-3">
            <div class="faq-box" onclick="toggleFaq(this)">
              <span>What payment methods do you accept?</span>
              <i class="bi bi-plus faq-icon"></i>
            </div>
            <div class="faq-answer">
              <p>We accept all major credit cards, PayPal, and other secure payment methods.</p>
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
          <img src="images/logo-white.svg" alt="Logo" class="footer-logo" width="300px" style="margin-left: -20px;">
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>