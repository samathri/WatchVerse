<?php
include 'php/db.php';
session_start();

// Get filter values from URL parameters
$movementFilter = isset($_GET['movement']) ? $_GET['movement'] : "";
$displaytypeFilter = isset($_GET['display-type']) ? $_GET['display-type'] : "";
$casesizeFilter = isset($_GET['case_size']) ? $_GET['case_size'] : "";
$waterresistance = isset($_GET['water_resistance']) ? $_GET['water_resistance'] : "";
$glassmaterial = isset($_GET['glass_material']) ? $_GET['glass_material'] : "";
$brandFilter = isset($_GET['brand']) ? $_GET['brand'] : "";
$minPrice = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
$maxPrice = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 200000;
$genderFilter = isset($_GET['gender']) ? $_GET['gender'] : "";
$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : "best-seller"; 

// Base SQL query
$sql = "SELECT * FROM products WHERE type IN ('New', 'other')";

$conditions = [];

// Apply filters if they are set
if (!empty($movementFilter)) {
    $conditions[] = "movement = '$movementFilter'";
}
if (!empty($displaytypeFilter)) {
    $conditions[] = "display_type = '$displaytypeFilter'";
}
if (!empty($casesizeFilter)) {
    $conditions[] = "case_size = '$casesizeFilter'";
}
if (!empty($waterresistance)) {
    $conditions[] = "water_resistance = '$waterresistance'";
}
if (!empty($glassmaterial)) {
    $conditions[] = "glass_material = '$glassmaterial'";
}
if (!empty($brandFilter)) {
    $conditions[] = "brand = '$brandFilter'";
}
if (!empty($genderFilter) && $genderFilter !== "unisex") {
    $conditions[] = "gender = '$genderFilter'";
}
if (!empty($minPrice) || !empty($maxPrice)) {
    $conditions[] = "productPrice BETWEEN $minPrice AND $maxPrice";
}

// Append conditions to the query if any filters exist
if (!empty($conditions)) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

// Apply sorting
switch ($sortOrder) {
    case "price-asc":
        $sql .= " ORDER BY productPrice ASC";
        break;
    case "price-desc":
        $sql .= " ORDER BY productPrice DESC";
        break;
    case "best-seller":
    default:
        $sql .= " ORDER BY sold_quantity DESC"; // Assuming "sold_quantity" represents best sellers
        break;
}

$countResult = $conn->query($sql);
$totalProducts = $countResult->num_rows;

$itemsPerPage = 12; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalPages = ceil($totalProducts / $itemsPerPage);
$offset = ($page - 1) * $itemsPerPage; 

$sql .= " LIMIT $offset, $itemsPerPage";
  
$result = $conn->query($sql);
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
    <link rel="stylesheet" href="style/styles.css">
<style>

@media (max-width: 768px) {

    .add-to-cart{
        font-size: 10px;
    }

    .price ,.productname {
    text-align: left;
    width: 100%;
}


}
</style>
    

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
                    <li class="nav-item"><a href="collection.php" class="nav-link active">Shop</a></li>
                </ul>
                <a href="home.php" class="navbar-brand mx-4">
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



    <h1 class="text-center mt-4">Collection</h1>
    <hr class="cart-divider mx-auto">



    <section class="hero d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-5">
                    <div class="hero-content text-white text-center">
                        <h2 class="fw-bold">TIME IS A LUXURY</h2>
                        <p>Explore watches that match your style and elevate every moment. Find your perfect timepiece
                            today.</p>
                        <a href="#" class="btn btn-warning">Buy Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-5">
        <h2 class="shop-title text-center fw-bold">EXPLORE THE SHOP</h2>
        <div class="shop-underline mx-auto"></div>

        <!-- Tabs for Men & Women -->
        <div class="tabs-container text-center mt-3">
            <ul class="nav nav-tabs justify-content-center border-0">
            <li class="nav-item">
            <a class="nav-link active gender-tab" data-gender="unisex" href="#">Unisex</a>
        </li>
            <li class="nav-item">
            <a class="nav-link  gender-tab" data-gender="men" href="#">Men</a>
        </li>
        <li class="nav-item">
            <a class="nav-link gender-tab" data-gender="women" href="#">Women</a>
        </li>
        </ul>
        </div>


        <div class="container mt-4">
            <h2 class="text-center mb-4">Watches Collection</h2>
            <div class="filter-sort-container d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="filter-info-container">
                    <span class="fw-bold">Filter</span> 
                    <i class="fas fa-filter" data-bs-toggle="modal" data-bs-target="#filterModal"></i>
                    <span class="ms-3">Showing 1 - 12 of  <?php echo $totalProducts; ?> results</span>
                </div>
                <div class="sort-options-container">
                    <select class="form-select d-inline w-auto" id="sortSelect">
                        <option value="best-seller" selected>Best Seller</option>
                        <option value="price-asc">Price: Low to High</option>
                        <option value="price-desc">Price: High to Low</option>
                    </select>
                    <i class="bi bi-list-ul"></i>
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                </div>
            </div>
        </div>
    
        <!-- Filter Modal -->
        <div class="modal fade filter-modal" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="filterModalLabel">Filter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                    <label class="form-label">Brand</label>
                        <div class="row text-center">
                            <section class="brand-section" data-type="brand">
                                <div class="brand-grid">
                                    <div class="brand-option" data-value="jacob">
                                        <img src="images/jacob.svg" alt="Jacob" class="brand-img">
                                    </div>
                                    <div class="brand-option" data-value="rolex">
                                        <img src="images/rolex.svg" alt="Rolex" class="brand-img">
                                    </div>
                                    <div class="brand-option" data-value="patek">
                                        <img src="images/patek.svg" alt="Patek" class="brand-img">
                                    </div>
                                    <div class="brand-option" data-value="casio">
                                        <img src="images/casio.svg" alt="Casio" class="brand-img">
                                    </div>
                                    <div class="brand-option" data-value="tissot">
                                        <img src="images/tissot.svg" alt="Tissot" class="brand-img">
                                    </div>
                                </div>
                            </section>
                        </div>
                        <span class="selected-brand" data-type="brand">Select Brand</span>
                                                
                        
                        <label class="form-label">Price Range</label>
                        <div class="price-range-container">
                            <input type="range" class="form-range" min="0" max="200000" id="priceRangeMin" value="0">
                            <input type="range" class="form-range" min="0" max="200000" id="priceRangeMax" value="200000">
                        </div>
                        <div class="d-flex justify-content-between price-values">
                            <span id="startPrice">$0</span>
                            <span id="endPrice">$200000</span>
                        </div>
                        
                        
                        
                        <div class="custom-select">
                        <label class="form-label">Movement</label>
                            <div class="select-box">
                                <span class="selected-option" data-type="movement">Select</span>
                            </div>
                            <div class="options-container">
                                <div class="option" data-value="automatic">Automatic</div>
                                <div class="option" data-value="eco-drive">Eco-Drive</div>
                                <div class="option" data-value="quartz">Quartz</div>
                                <div class="option" data-value="na">N/A</div>
                            </div>
                        </div>

                        <div class="custom-select">
                        <label class="form-label">Display Type</label>
                            <div class="select-box">
                                <span class="selected-option" data-type="display-type">Select</span>
                            </div>
                            <div class="options-container">
                                <div class="option" data-value="analog">Analog</div>
                                <div class="option" data-value="digital">Digital</div>
                                <div class="option" data-value="analog-dual-time">Analog-Dual Time</div>
                                <div class="option" data-value="analog-chronograph">Analog Chronograph</div>
                                <div class="option" data-value="digital-chronograph">Digital Chronograph</div>
                            </div>
                        </div>

                        
                        
                            
                            <div class="custom-select">
                            <label class="form-label">Case Size</label>
                                <div class="select-box">
                                    <span class="selected-option"  data-type="case_size">Select</span>
                                    <div class="arrow"></div>
                                </div>
                                <div class="options-container">
                                    <div class="option" data-value="20-25mm">20-25mm</div>
                                    <div class="option" data-value="25-30mm">25-30mm</div>
                                    <div class="option" data-value="30-35mm">30-35mm</div>
                                    <div class="option" data-value="35-40mm">35-40mm</div>
                                    <div class="option" data-value="40-45mm">40-45mm</div>
                                    <div class="option" data-value="50-55mm">50-55mm</div>
                                </div>
                            </div>
                        
                        
                       
                            
                            <div class="custom-select">
                            <label class="form-label">Water Resistance</label>
                                <div class="select-box">
                                    <span class="selected-option" data-type="water_resistance">Select</span>
                                    <div class="arrow"></div>
                                </div>
                                <div class="options-container">
                                    <div class="option" data-value="30m">30M</div>
                                    <div class="option" data-value="50m">50M</div>
                                    <div class="option" data-value="100m">100M</div>
                                    <div class="option" data-value="200m">200M</div>
                                </div>
                            </div>
                        
                        
                        
                            
                        <div class="custom-select">
                            <label class="form-label">Glass Material</label>
                                <div class="select-box">
                                    <span class="selected-option" data-type="glass_material">Select</span>
                                    <div class="arrow"></div>
                                </div>
                                <div class="options-container">
                                    <div class="option" data-value="hardlex">Hardlex</div>
                                    <div class="option" data-value="mineral">Mineral</div>
                                    <div class="option" data-value="sapphire">Sapphire</div>
                                    <div class="option" data-value="mineral-glass">Mineral Glass</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Color</label>
                            <div class="d-flex flex-wrap" id="colorContainer"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Apply Filters</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <!-- Product Card -->
            <?php
               if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Split the product name into two parts
                    $parts = explode(" ", $row['productName'], 2);
            ?>
            <div class="col-md-3 col-sm-6 mb-4 g-4">
            <div class="product-card text-center p-3 position-relative" data-product-id="<?php echo $row['id']; ?>">
            
            <?php if ($row['type'] == 'New') : ?>
                <div class="sale-badge">
                <button id="sale">NEW</button>
                </div>
            <?php endif; ?>
                
            <div class="wishlist-icon-m">
    <i class="bi bi-heart wishlist-btn-m"></i>
</div>
                    <img class="product-image" src="<?php echo htmlspecialchars($row['productImage']); ?>" class="img-fluid" alt="Watch">
                </div>
                <div class="d-flex justify-content-between align-items-center">
                <h6 class="productname">
                  <?php 
                    echo "<br>" . htmlspecialchars($parts[0]); 
                      if (isset($parts[1])) {
                        echo "<br>" . htmlspecialchars($parts[1]);
                     }
                  ?>
                </h6>
                    <h6 class="mt-2 price"><?php echo number_format($row['productPrice'], 0) . '$'; ?></h6>
                </div>
                <h6 class="description"><?php echo htmlspecialchars($row['description']); ?></h6>
                <div class="rating">
                <?php
                // Display rating stars
                for($i = 1; $i <= 5; $i++) {
                    if($i <= $row['productRating']) {
                        echo '<i class="bi bi-star-fill"></i>';
                    } else {
                        echo '<i class="bi bi-star"></i>';
                    }
                }
                ?>
                <span class="ratingnumber">(<?php echo $row['productRating']; ?>)</span>
            </div>
            <button class="add-to-cart mt-2" onclick="viewProduct(<?php echo $row['id']; ?>)">Add To Cart</button>
        </div>
        <?php
        }
    } else {
        echo "<p class='text-center w-100'>No products found</p>";
    }
    ?>
   </div>
<hr class="breaklineshop">


            <div class="container d-flex justify-content-center mt-5 mb-5">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <!-- Always Show Previous Icon -->
            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo max($page - 1, 1); ?>" aria-label="Previous">
                    <span>&lt;</span>
                </a>
            </li>

            <!-- Pagination Numbers -->
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>

            <!-- Always Show Next Icon -->
            <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo min($page + 1, $totalPages); ?>" aria-label="Next">
                    <span>&gt;</span>
                </a>
            </li>
        </ul>
    </nav>
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
                <p class="footer-contact-us text-center" style="padding-right: 100px;">All Copyrights Reserved © ALANKARAGE HOLDINGS
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
    function viewProduct(productId) {
        window.location.href = "details.php?id=" + productId;
    }
</script>
<script>
let selectedBrand = "";

// Brand selection logic
document.querySelectorAll(".brand-option").forEach(brand => {
    brand.addEventListener("click", function () {
        document.querySelectorAll(".brand-option").forEach(b => b.classList.remove("selected"));
        this.classList.add("selected");
        selectedBrand = this.getAttribute("data-value");
        document.querySelector(".selected-brand").innerText = selectedBrand;
    });
});

// Select price range inputs
const minPriceInput = document.getElementById("priceRangeMin");
const maxPriceInput = document.getElementById("priceRangeMax");
const minPriceDisplay = document.getElementById("startPrice");
const maxPriceDisplay = document.getElementById("endPrice");

// Update displayed price range values dynamically
minPriceInput.addEventListener("input", function () {
    minPriceDisplay.innerText = "$" + minPriceInput.value;
});
maxPriceInput.addEventListener("input", function () {
    maxPriceDisplay.innerText = "$" + maxPriceInput.value;
});

// Update button click event to include price range filter
document.querySelector(".btn-primary").addEventListener("click", function () {
    let selectedMovement = document.querySelector(".selected-option[data-type='movement']").innerText;
    let selectedDisplayType = document.querySelector(".selected-option[data-type='display-type']").innerText;
    let selectedCaseSize = document.querySelector(".selected-option[data-type='case_size']").innerText;
    let selectedWaterResistance = document.querySelector(".selected-option[data-type='water_resistance']").innerText;
    let selectedGlassMaterial = document.querySelector(".selected-option[data-type='glass_material']").innerText;
   
    let minPrice = minPriceInput.value;
    let maxPrice = maxPriceInput.value;

    let url = "collection.php?";

    if (selectedBrand) url += "brand=" + encodeURIComponent(selectedBrand) + "&";
    if (selectedMovement && selectedMovement !== "Select") url += "movement=" + encodeURIComponent(selectedMovement) + "&";
    if (selectedDisplayType && selectedDisplayType !== "Select") url += "display-type=" + encodeURIComponent(selectedDisplayType) + "&";
    if (selectedCaseSize && selectedCaseSize !== "Select") url += "case_size=" + encodeURIComponent(selectedCaseSize) + "&";
    if (selectedWaterResistance && selectedWaterResistance !== "Select") url += "water_resistance=" + encodeURIComponent(selectedWaterResistance) + "&";
    if (selectedGlassMaterial && selectedGlassMaterial !== "Select") url += "glass_material=" + encodeURIComponent(selectedGlassMaterial) + "&";
    if (minPrice) url += "min_price=" + encodeURIComponent(minPrice) + "&";
    if (maxPrice) url += "max_price=" + encodeURIComponent(maxPrice) + "&";

    url = url.slice(0, -1); // Remove last '&'
    window.location.href = url;
});


</script>
<script>
document.querySelectorAll(".gender-tab").forEach(tab => {
    tab.addEventListener("click", function (e) {
        e.preventDefault();
        
        // Remove active class from all tabs
        document.querySelectorAll(".gender-tab").forEach(t => t.classList.remove("active"));
        
        // Add active class to clicked tab
        this.classList.add("active");

        // Get the selected gender
        let selectedGender = this.getAttribute("data-gender");

        // Construct URL with gender filter
        let url = new URL(window.location.href);

        if (selectedGender === "unisex") {
            url.searchParams.delete("gender"); // Remove gender filter to show all products
        } else {
            url.searchParams.set("gender", selectedGender);
        }

        // Redirect to the updated URL
        window.location.href = url.toString();
    });
});


    </script>
    <script>
        document.getElementById("sortSelect").addEventListener("change", function () {
    let selectedSort = this.value;

    // Construct URL with sorting filter
    let url = new URL(window.location.href);
    url.searchParams.set("sort", selectedSort);

    // Redirect to the updated URL
    window.location.href = url.toString();
});

        </script>
</body>

</html>