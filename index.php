<?php
session_start();
include 'php/db.php';

$sql = "SELECT * FROM news ORDER BY id ASC LIMIT 3";
$result = $conn->query($sql);

$productlimit = 4;
$sql = "SELECT * FROM products WHERE type = 'New' LIMIT $productlimit";
$resultproduct = $conn->query($sql);

$sql = "SELECT os.*, u.userFname, u.userLname
        FROM order_summary os
        JOIN user_registration u ON os.user_id = u.id
        ORDER BY os.order_date DESC 
        LIMIT 5";
$resultreview = $conn->query($sql);

// For Best Sellers tab - fetch 4 random products
$sql_bestsellers = "SELECT * FROM products ORDER BY sold_quantity DESC LIMIT 4";
$result_bestsellers = $conn->query($sql_bestsellers);

// For Trending tab - fetch 4 different random products
$sql_trending = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
$result_trending = $conn->query($sql_trending);

// For Latest Arrivals tab - fetch 4 newest products that are not on sale
$sql_latest = "SELECT * FROM products WHERE type != 'Sale' ORDER BY id DESC LIMIT 4";
$result_latest = $conn->query($sql_latest);

// For Offers tab - fetch 4 newest sale products
$sql_offers = "SELECT * FROM products WHERE type = 'Sale' ORDER BY id DESC LIMIT 4";
$result_offers = $conn->query($sql_offers);

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style/styles.css">
  <link rel="stylesheet" href="style/collection_style.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <style>
    .news-card {
      font-family: 'Poppins', sans-serif;
    }
  </style>

</head>

<body class="">

  <!-- Mobile Header -->
  <header class="mobile-nav p-3">
    <div class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></div>
    <a href="index.php" class="navbar-brand">
      <img src="images/logo-black.svg" alt="Logo" class="logo" width="150px">
    </a>
    <a href="mycart.html"><i class="bi bi-cart3"></i></a>
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
        <a href="#" class="navbar-brand mx-4">
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

        <a href="#"><i class="bi bi-cart3" style="color: #000;"></i></a>

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

  <!-- Hero Section -->
  <header class="hero-section-h text-center text-white">
    <h1 class="hero-title-home">Elevate Every Moment – Find </h1>
    <h1 class="hero-title-home">Your Watch</h1>
    <div class="secondhero">
      <h6 style=" letter-spacing: 1px;">Explore watches that match your style and elevate every moment. Find your
        perfect timepiece today </h6>
    </div>
    <button class="btn btn-primary-hero mt-3" id="hero-home">Find Watch</button>
    <button class="btn btn-primary-hero mt-3">buy Now</button>
  </header>



  <section class="homepage container my-5">
  <h2 class="text-center">Trending Watches</h2>
  <div class="news-divider-h"></div>

  <!-- Category Tabs -->
  <div class="container text-center mt-4">
    <div class="category-tabs">
      <span class="tab active" onclick="changeTab(this, 'best-sellers')">Best Sellers</span>
      <span class="tab" onclick="changeTab(this, 'trending')">Trending</span>
      <span class="tab" onclick="changeTab(this, 'latest-arrivals')">Latest Arrivals</span>
      <span class="tab" onclick="changeTab(this, 'offers')">Offers</span>
    </div>
  </div>

  <!-- Product Lists -->
  <div class="row mt-5 trending">

    <!-- Best Sellers (Default Active) -->
    <div class="product-list active" id="best-sellers">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php
        if ($result_bestsellers->num_rows > 0) {
          while ($product = $result_bestsellers->fetch_assoc()) {
        ?>
          <div class="col">
          <div class="product-card text-center p-3 position-relative" data-product-id="<?php echo $product['id']; ?>">              <?php if ($product['type'] == 'Sale') { ?>
                <div class="sale-badge"><button id="sale">SALE</button></div>
              <?php } ?>
              <div class="wishlist-icon-m">
                <i class="bi bi-heart wishlist-btn-m"></i>
              </div>
              <img class="productImage-h" src="<?php echo htmlspecialchars($product['productImage']); ?>" class="img-fluid" alt="Watch">
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="productname"><?php echo htmlspecialchars($product['productName']); ?></h6>
              <h6 class="mt-2 price"><?php echo htmlspecialchars($product['productPrice']); ?>$ 
                <?php if (!empty($product['old_price'])) { ?>
                  <span class="old-price"><?php echo htmlspecialchars($product['salePrice']); ?>$</span>
                <?php } ?>
              </h6>
            </div>
            <h6 class="description"><?php echo htmlspecialchars($product['description']); ?></h6>
            <div class="rating">
              <?php 
              // Display stars based on rating
              $rating = isset($product['rating']) ? $product['rating'] : 5;
              for ($i = 0; $i < 5; $i++) {
                if ($i < $rating) {
                  echo '<i class="bi bi-star-fill"></i>';
                } else {
                  echo '<i class="bi bi-star"></i>';
                }
              }
              ?>
              <span class="ratingnumber">(<?php echo isset($product['rating_count']) ? $product['rating_count'] : '212'; ?>)</span>
            </div>
            <button class="add-to-cart mt-2" onclick="addToCart(<?php echo $product['id']; ?>)">Add To Cart</button>
          </div>
        <?php
          }
        } else {
          echo "<div class='col-12 text-center'>No products found</div>";
        }
        ?>
      </div>
    </div>

    <!-- Trending Tab -->
    <div class="product-list d-none" id="trending">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php
        if ($result_trending->num_rows > 0) {
          while ($product = $result_trending->fetch_assoc()) {
        ?>
          <div class="col">
          <div class="product-card text-center p-3 position-relative" data-product-id="<?php echo $product['id']; ?>">
              <?php if ($product['type'] == 'Sale') { ?>
                <div class="sale-badge"><button id="sale">SALE</button></div>
              <?php } ?>
              <div class="wishlist-icon-m">
                <i class="bi bi-heart wishlist-btn-m"></i>
              </div>
              <img class="productImage-h" src="<?php echo htmlspecialchars($product['productImage']); ?>" class="img-fluid" alt="Watch">
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="productname"><?php echo htmlspecialchars($product['productName']); ?></h6>
              <h6 class="mt-2 price"><?php echo htmlspecialchars($product['productPrice']); ?>$ 
                <?php if (!empty($product['old_price'])) { ?>
                  <span class="old-price"><?php echo htmlspecialchars($product['salePrice']); ?>$</span>
                <?php } ?>
              </h6>
            </div>
            <h6 class="description"><?php echo htmlspecialchars($product['description']); ?></h6>
            <div class="rating">
              <?php 
              // Display stars based on rating
              $rating = isset($product['rating']) ? $product['rating'] : 5;
              for ($i = 0; $i < 5; $i++) {
                if ($i < $rating) {
                  echo '<i class="bi bi-star-fill"></i>';
                } else {
                  echo '<i class="bi bi-star"></i>';
                }
              }
              ?>
              <span class="ratingnumber">(<?php echo isset($product['rating_count']) ? $product['rating_count'] : '212'; ?>)</span>
            </div>
            <button class="add-to-cart mt-2" onclick="addToCart(<?php echo $product['id']; ?>)">Add To Cart</button>
          </div>
        <?php
          }
        } else {
          echo "<div class='col-12 text-center'>No products found</div>";
        }
        ?>
      </div>
    </div>

    <!-- Latest Arrivals Tab -->
    <div class="product-list d-none" id="latest-arrivals">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php
        if ($result_latest->num_rows > 0) {
          while ($product = $result_latest->fetch_assoc()) {
        ?>
          <div class="col">
          <div class="product-card text-center p-3 position-relative" data-product-id="<?php echo $product['id']; ?>">
              <div class="wishlist-icon-m">
                <i class="bi bi-heart wishlist-btn-m"></i>
              </div>
              <img class="productImage-h" src="<?php echo htmlspecialchars($product['productImage']); ?>" class="img-fluid" alt="Watch">
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="productname"><?php echo htmlspecialchars($product['productName']); ?></h6>
              <h6 class="mt-2 price"><?php echo htmlspecialchars($product['productPrice']); ?>$ 
                <?php if (!empty($product['old_price'])) { ?>
                  <span class="old-price"><?php echo htmlspecialchars($product['salePrice']); ?>$</span>
                <?php } ?>
              </h6>
            </div>
            <h6 class="description"><?php echo htmlspecialchars($product['description']); ?></h6>
            <div class="rating">
              <?php 
              // Display stars based on rating
              $rating = isset($product['rating']) ? $product['rating'] : 5;
              for ($i = 0; $i < 5; $i++) {
                if ($i < $rating) {
                  echo '<i class="bi bi-star-fill"></i>';
                } else {
                  echo '<i class="bi bi-star"></i>';
                }
              }
              ?>
              <span class="ratingnumber">(<?php echo isset($product['rating_count']) ? $product['rating_count'] : '212'; ?>)</span>
            </div>
            <button class="add-to-cart mt-2" onclick="addToCart(<?php echo $product['id']; ?>)">Add To Cart</button>
          </div>
        <?php
          }
        } else {
          echo "<div class='col-12 text-center'>No latest arrivals found</div>";
        }
        ?>
      </div>
    </div>

    <!-- Offers Tab -->
    <div class="product-list d-none" id="offers">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php
        if ($result_offers->num_rows > 0) {
          while ($product = $result_offers->fetch_assoc()) {
        ?>
          <div class="col">
          <div class="product-card text-center p-3 position-relative" data-product-id="<?php echo $product['id']; ?>">
              <div class="sale-badge"><button id="sale">SALE</button></div>
              <div class="wishlist-icon-m">
                <i class="bi bi-heart wishlist-btn-m"></i>
              </div>
              <img class="productImage-h" src="<?php echo htmlspecialchars($product['productImage']); ?>" class="img-fluid" alt="Watch">
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="productname"><?php echo htmlspecialchars($product['productName']); ?></h6>
              <h6 class="mt-2 price"><?php echo htmlspecialchars($product['productPrice']); ?>$ 
                <?php if (!empty($product['old_price'])) { ?>
                  <span class="old-price"><?php echo htmlspecialchars($product['salePrice']); ?>$</span>
                <?php } ?>
              </h6>
            </div>
            <h6 class="description"><?php echo htmlspecialchars($product['description']); ?></h6>
            <div class="rating">
              <?php 
              // Display stars based on rating
              $rating = isset($product['rating']) ? $product['rating'] : 5;
              for ($i = 0; $i < 5; $i++) {
                if ($i < $rating) {
                  echo '<i class="bi bi-star-fill"></i>';
                } else {
                  echo '<i class="bi bi-star"></i>';
                }
              }
              ?>
              <span class="ratingnumber">(<?php echo isset($product['rating_count']) ? $product['rating_count'] : '212'; ?>)</span>
            </div>
            <button class="add-to-cart mt-2" onclick="addToCart(<?php echo $product['id']; ?>)">Add To Cart</button>
          </div>
        <?php
          }
        } else {
          echo "<div class='col-12 text-center'>No offers found</div>";
        }
        ?>
      </div>
    </div>
  </div>
</section>

  <div class="wrapper-n">
    <section class="subscribe-container-n">
      <div class="subscribe-content-n">
        <h2 class="subscribe-title-n">Be the First to Know</h2>
        <p class="subscribe-text-n">
          Discover how to find the best watch and exclusive products and offers via email
        </p>
        <div class="input-container-n">
          <input type="email" class="subscribe-input-n" placeholder="your email">
          <button class="subscribe-button-n"><i class="bi bi-send-fill"></i></button>
        </div>
      </div>
    </section>
  </div>


  <!-- Watch Selector Section -->
  <section class="watch-selector-section-s">
    <h2 class="watch-title-s">Let's Find You A Watch</h2>
    <div class="filter-controls-s mt-3">

      <!-- Color Dropdown -->
      <div class="dropdown-s">
        <button class="btn-s dropdown-toggle" type="button" data-bs-toggle="dropdown">
          Color
        </button>
        <ul class="dropdown-menu dropdown-menu-s">
          <li><a class="dropdown-item dropdown-item-s" href="#">Black</a></li>
          <li><a class="dropdown-item dropdown-item-s" href="#">Silver</a></li>
          <li><a class="dropdown-item dropdown-item-s" href="#">Gold</a></li>
        </ul>
      </div>

      <span class="divider-s"></span>

      <!-- Material Dropdown -->
      <div class="dropdown-s">
        <button class="btn-s dropdown-toggle" type="button" data-bs-toggle="dropdown">
          Material
        </button>
        <ul class="dropdown-menu dropdown-menu-s">
          <li><a class="dropdown-item dropdown-item-s" href="#">Stainless Steel</a></li>
          <li><a class="dropdown-item dropdown-item-s" href="#">Leather</a></li>
          <li><a class="dropdown-item dropdown-item-s" href="#">Titanium</a></li>
        </ul>
      </div>

      <span class="divider-s"></span>

      <!-- Type Dropdown -->
      <div class="dropdown-s">
        <button class="btn-s dropdown-toggle" type="button" data-bs-toggle="dropdown">
          Type
        </button>
        <ul class="dropdown-menu dropdown-menu-s">
          <li><a class="dropdown-item dropdown-item-s" href="#">Analog</a></li>
          <li><a class="dropdown-item dropdown-item-s" href="#">Digital</a></li>
          <li><a class="dropdown-item dropdown-item-s" href="#">Smart</a></li>
        </ul>
      </div>

      <span class="divider-s"></span>

      <!-- Brand Dropdown -->
      <div class="dropdown-s">
        <button class="btn-s dropdown-toggle" type="button" data-bs-toggle="dropdown">
          Brand
        </button>
        <ul class="dropdown-menu dropdown-menu-s">
          <li><a class="dropdown-item dropdown-item-s" href="#">Rolex</a></li>
          <li><a class="dropdown-item dropdown-item-s" href="#">Tag Heuer</a></li>
          <li><a class="dropdown-item dropdown-item-s" href="#">Omega</a></li>
        </ul>
      </div>
    </div>

    <hr class="custom-hr-n">


    <!-- Carousel Section -->
    <section class="carousel-container-s">
      <button class="nav-button-s prev-button-s">&#10094;</button>
      <div class="carousel-track-s">
        <div class="carousel-item-s">
          <div class="action-icons">
            <span class="action-icon" data-action="favorite"><i class="fas fa-heart"></i></span>
            <span class="action-icon" data-action="view"><i class="fas fa-eye"></i></span>
            <span class="action-icon" data-action="lock"><i class="fas fa-lock"></i></span>
          </div>
          <img src="images/s3.png" alt="Tag Heuer">
          <h3 class="watch-brand-s">A</h3>
          <p class="watch-model-s">Sky-Dweller</p>
          <div class="rating">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
          </div>
        </div>
        <div class="carousel-item-s">
          <div class="action-icons">
            <span class="action-icon" data-action="favorite"><i class="fas fa-heart"></i></span>
            <span class="action-icon" data-action="view"><i class="fas fa-eye"></i></span>
            <span class="action-icon" data-action="lock"><i class="fas fa-lock"></i></span>
          </div>
          <img src="images/s1.png" alt="Tag Heuer">
          <h3 class="watch-brand-s">B</h3>
          <p class="watch-model-s">Sky-Dweller</p>
          <div class="rating">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
          </div>
        </div>
        <div class="carousel-item-s active-s">
          <div class="action-icons">
            <span class="action-icon" data-action="favorite"><i class="fas fa-heart"></i></span>
            <span class="action-icon" data-action="view"><i class="fas fa-eye"></i></span>
            <span class="action-icon" data-action="lock"><i class="fas fa-lock"></i></span>
          </div>
          <img src="images/s2.png" alt="Tag Heuer">
          <h3 class="watch-brand-s">C</h3>
          <p class="watch-model-s">Globemaster</p>
          <div class="rating">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
          </div>
        </div>
        <div class="carousel-item-s">
          <div class="action-icons">
            <span class="action-icon" data-action="favorite"><i class="fas fa-heart"></i></span>
            <span class="action-icon" data-action="view"><i class="fas fa-eye"></i></span>
            <span class="action-icon" data-action="lock"><i class="fas fa-lock"></i></span>
          </div>
          <img src="images/s5.png" alt="Tag Heuer">
          <h3 class="watch-brand-s">D</h3>
          <p class="watch-model-s">Conquest Chrono</p>
          <div class="rating">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
          </div>
        </div>
        <div class="carousel-item-s">
          <div class="action-icons">
            <span class="action-icon" data-action="favorite"><i class="fas fa-heart"></i></span>
            <span class="action-icon" data-action="view"><i class="fas fa-eye"></i></span>
            <span class="action-icon" data-action="lock"><i class="fas fa-lock"></i></span>
          </div>
          <img src="images/s4.png" alt="Tag Heuer">
          <h3 class="watch-brand-s">E</h3>
          <p class="watch-model-s">Hybris Mechanica</p>
          <div class="rating">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
          </div>
        </div>
      </div>
      <button class="nav-button-s next-button-s">&#10095;</button>
    </section>

  </section>

  <hr class="custom-hr-n">


  <h1 class="news-heading-h">Latest News</h1>
  <div class="news-divider-h"></div>

  <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="0" class="active" aria-current="true"
        aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <br><br>

    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="d-flex justify-content-center gap-3">

          <?php while ($row = $result->fetch_assoc()) { ?>

            <div class="news-card">
              <h2 class="news-date-h"><b>Posted: <?php echo htmlspecialchars($row["date"]); ?></b></h2>
              <div class="news-img-container">
                <img src="<?php echo htmlspecialchars($row["image"]); ?>" class="news-img" alt="News Image 1">
              </div>
              <div class="news-card-body">
                <h3 class="news-title-h"><?php echo htmlspecialchars($row["title"]); ?></h3>
                <h4 class="news-desc"><?php echo htmlspecialchars($row["description"]); ?></h4>
                <a href="#" class="news-link">Read More</a>
              </div>
            </div>

            <?php
          }
          ?>




        </div>
      </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <br>
  <br>

  <section class="promo-section">
    <div class="promo-content">
      <div class="promo-text">

        <h2>Don't Miss The Moment</h2>
        <p>Timeless watches for life's unforgettable seconds. Make every second count with elegance and precision.</p>
        <button class="promo-btn">Buy Now</button>
      </div>
    </div>
  </section>




  <!-- Testimonials Section -->
  <section class="testimonials-section text-center">
    <h2>Testimonials</h2>
    <div class="news-divider-h"></div>
    <div class="outerdiv">
      <div class="innerdiv">
        <!-- div1 -->
        <div class="div1 eachdiv">
          <div class="userdetails">
            <div class="imgbox">
              <img
                src="https://raw.githubusercontent.com/RahulSahOfficial/testimonials_grid_section/5532c958b7d3c9b910a216b198fdd21c73112d84/images/image-daniel.jpg"
                alt="">
            </div>
            <?php
            if ($resultreview->num_rows > 0) {
              $firstRow = $resultreview->fetch_assoc();
              ?>
              <div class="detbox">

                <p class="name"><?php echo htmlspecialchars($firstRow["userFname"]); ?>
                  <?php echo htmlspecialchars($firstRow["userLname"]); ?>
                </p>

              </div>
            </div>
            <div class="review">

              <p><?php echo htmlspecialchars($firstRow["review_description"]); ?></p>
            </div>
            <?php
            }
            ?>
        </div>

        <!-- div2 -->
        <div class="div2 eachdiv">
          <div class="userdetails">
            <div class="imgbox">
              <img
                src="https://raw.githubusercontent.com/RahulSahOfficial/testimonials_grid_section/5532c958b7d3c9b910a216b198fdd21c73112d84/images/image-jonathan.jpg"
                alt="">
            </div>
            <?php
            if ($resultreview->num_rows > 0) {
              $firstRow = $resultreview->fetch_assoc();
              ?>
              <div class="detbox">
                <p class="name"><?php echo htmlspecialchars($firstRow["userFname"]); ?>
                  <?php echo htmlspecialchars($firstRow["userLname"]); ?>
                </p>

              </div>
            </div>
            <div class="review">

              <p><?php echo htmlspecialchars($firstRow["review_description"]); ?></p>
            </div>
            <?php
            }
            ?>
        </div>
        <!-- div3 -->
        <div class="div3 eachdiv">
          <div class="userdetails">
            <div class="imgbox">
              <img
                src="https://raw.githubusercontent.com/RahulSahOfficial/testimonials_grid_section/5532c958b7d3c9b910a216b198fdd21c73112d84/images/image-kira.jpg"
                alt="">
            </div>
            <?php
            if ($resultreview->num_rows > 0) {
              $firstRow = $resultreview->fetch_assoc();
              ?>

              <div class="detbox">
                <p class="name dark"><?php echo htmlspecialchars($firstRow["userFname"]); ?>
                  <?php echo htmlspecialchars($firstRow["userLname"]); ?>
                </p>

              </div>
            </div>
            <div class="review dark">

              <p><?php echo htmlspecialchars($firstRow["review_description"]); ?></p>
            </div>
            <?php
            }
            ?>
        </div>
        <!-- div4 -->
        <div class="div4 eachdiv">
          <div class="userdetails">
            <div class="imgbox">
              <img
                src="https://raw.githubusercontent.com/RahulSahOfficial/testimonials_grid_section/5532c958b7d3c9b910a216b198fdd21c73112d84/images/image-jeanette.jpg"
                alt="">
            </div>
            <?php
            if ($resultreview->num_rows > 0) {
              $firstRow = $resultreview->fetch_assoc();
              ?>
              <div class="detbox">
                <p class="name dark"><?php echo htmlspecialchars($firstRow["userFname"]); ?>
                  <?php echo htmlspecialchars($firstRow["userLname"]); ?>
                </p>

              </div>
            </div>
            <div class="review dark">

              <p><?php echo htmlspecialchars($firstRow["review_description"]); ?></p>
            </div>
            <?php
            }
            ?>
        </div>
        <!-- div5 -->
        <div class="div5 eachdiv">
          <div class="userdetails">
            <div class="imgbox">
              <img
                src="https://raw.githubusercontent.com/RahulSahOfficial/testimonials_grid_section/5532c958b7d3c9b910a216b198fdd21c73112d84/images/image-patrick.jpg"
                alt="">
            </div>
            <?php
            if ($resultreview->num_rows > 0) {
              $firstRow = $resultreview->fetch_assoc();
              ?>
              <div class="detbox">
                <p class="name"><?php echo htmlspecialchars($firstRow["userFname"]); ?>
                  <?php echo htmlspecialchars($firstRow["userLname"]); ?>
                </p>

              </div>
            </div>
            <div class="review">

              <p><?php echo htmlspecialchars($firstRow["review_description"]); ?></p>
            </div>
            <?php
            }
            ?>
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

  


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="script.js"></script>
  <script>
    function viewProduct(productId) {
        window.location.href = "details.php?id=" + productId;
    }
</script>

  <script>
    function changeTab(selectedTab, category) {
      // Remove active class from all tabs
      document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
      selectedTab.classList.add('active');

      // Hide all product lists
      document.querySelectorAll('.product-list').forEach(list => list.classList.add('d-none'));

      // Show the selected category
      document.getElementById(category).classList.remove('d-none');
    }
  </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded, fetching wishlist status...');
    
    function updateHeartIcon(productId, isInWishlist) {
        console.log(Updating product ${productId}, wishlist status: ${isInWishlist});
        
        const productCards = document.querySelectorAll(.product-card[data-product-id="${productId}"]);
        console.log(Found ${productCards.length} product cards for ID ${productId});
        
        productCards.forEach(card => {

            const heartIcons = card.querySelectorAll('.wishlist-btn-m, .wishlist-btn');
            console.log(Found ${heartIcons.length} heart icons in this card);
            
            heartIcons.forEach(icon => {
                if (isInWishlist) {
                    icon.classList.remove('bi-heart');
                    icon.classList.add('bi-heart-fill');
                    icon.style.color = '#FC8C1C'; 
                    console.log('Set heart to filled and orange');
                } else {
                    icon.classList.remove('bi-heart-fill');
                    icon.classList.add('bi-heart');
                    icon.style.color = ''; 
                    console.log('Set heart to outline and default color');
                }
            });
        });
    }
    
    // Fetch wishlist status when page loads
    fetch('php/get_wishlist_status.php')
        .then(response => {
            console.log('Wishlist status response received');
            return response.json();
        })
        .then(data => {
            console.log('Wishlist data:', data);
            if (data.status === 'success') {
                data.items.forEach(productId => {
                    updateHeartIcon(productId, true);
                });
            } else {
                console.error('Error in wishlist status:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching wishlist status:', error);
        });
    
    // Add click handlers to all wishlist buttons
    const wishlistButtons = document.querySelectorAll('.wishlist-btn-m, .wishlist-btn');
    console.log(Found ${wishlistButtons.length} wishlist buttons on the page);
    
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Wishlist button clicked');
            
            const productCard = this.closest('.product-card');
            const productId = productCard.dataset.productId;
            console.log(Processing product ID: ${productId});
            
            fetch('php/handle_wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: product_id=${productId}
            })
            .then(response => response.json())
            .then(data => {
                console.log('Wishlist update response:', data);
                if (data.status === 'success') {
                    updateHeartIcon(productId, data.action === 'added');
                    
                    if (data.action === 'added') {
                        showToast('Product added to wishlist!', 'success');
                    } else {
                        showToast('Product removed from wishlist!', 'info');
                    }
                } else {
                    if (data.message === 'not_logged_in') {
                        window.location.href = 'login.php';
                    } else {
                        showToast('Error: ' + data.message, 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error updating wishlist:', error);
                showToast('An error occurred. Please try again.', 'error');
            });
        });
    });
});

    </script>

  <script>
    const track = document.querySelector('.carousel-track-s');
    let items = Array.from(document.querySelectorAll('.carousel-item-s'));
    const prevButton = document.querySelector('.prev-button-s');
    const nextButton = document.querySelector('.next-button-s');

    let currentIndex = 2;

    function updateCarousel() {
      items.forEach((item, index) => {
        item.classList.remove('active-s');
      });

      items[currentIndex].classList.add('active-s');

      // Circular loop logic with sliding effect
      const totalItems = items.length;
      let visibleItems = 5;
      let offset = -((currentIndex - Math.floor(visibleItems / 2) + totalItems) % totalItems) * 150;


      track.style.transform = translateX(${offset}px);
    }

    function moveForward() {

      let firstItem = items.shift();
      items.push(firstItem);
      track.appendChild(firstItem);
      currentIndex = 2;
      updateCarousel();
    }

    function moveBackward() {


      let lastItem = items.pop();
      items.unshift(lastItem);
      track.prepend(lastItem);
      currentIndex = 2;
      updateCarousel();
    }

    prevButton.addEventListener('click', moveBackward);
    nextButton.addEventListener('click', moveForward);

    updateCarousel();


  </script>


</body>

</html>