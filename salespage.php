<?php
include 'php/db.php';
session_start();

$limit = 12;

// Get the current page number from URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Ensure page is at least 1

// Calculate the starting row for the query
$offset = ($page - 1) * $limit;

// Get total number of sale products
$totalQuery = "SELECT COUNT(*) AS total FROM products WHERE type = 'sale'";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalProducts = $totalRow['total'];


$totalPages = ceil($totalProducts / $limit);

// Fetch products for the current page
// $sql = "SELECT * FROM products WHERE type = 'sale' LIMIT $limit OFFSET $offset";
// $result = $conn->query($sql);


$sort = isset($_GET['sort']) ? $_GET['sort'] : 'bestseller';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$orderBy = "";
switch ($sort) {
    case 'low_to_high':
        $orderBy = "ORDER BY salePrice ASC";
        break;
    case 'high_to_low':
        $orderBy = "ORDER BY salePrice DESC";
        break;
    case 'bestseller':
    default:
        $orderBy = "ORDER BY sold_quantity DESC"; 
        break;
}

$categoryFilter = $category ? "AND gender = '$category'" : "";

$query = "SELECT * FROM products WHERE type = 'sale' OR  sold_quantity = 1 $categoryFilter $orderBy LIMIT $limit";
$result = $conn->query($query);

$totalFilteredProducts = $result->num_rows;
?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style/collection_style.css">
    <link rel="stylesheet" href="style/styles.css">
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
        <div class="mt-5">
            <span style="text-decoration: underline; text-decoration-color: #FC8C1C; text-underline-offset: 8px;">
              <h5>Buy On Sale</h5>
            </span>
        </div>
        <div class="row mt-5">
            <div class="col-md-8">
                <h1 class="title">Timeless Elegance Awaits You</h1>
                <p class="secondtext">Discover a curated collection of brand-new and pre-owned luxury watches at unbeatable prices. 
                    Perfect craftsmanship, just a click away.</p>
                <div class="text-start">
                    <button class="btn buy-button">Buy Now</button>
                </div>
                <p class="lasttext">Hurry! Exclusive deals for a limited time only.</p>
            </div>
            <div class="col-md-4">
                <img src="./images/image 24.png" class="img-fluid" alt="Watch">
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 d-flex flex-wrap gap-4 justify-content-center">
                <button class="btn radio-button">All</button>
                <button class="btn radio-button" data-category="Men">Men</button>
                <button class="btn radio-button">Women</button>
                <button class="btn radio-button">Rolex</button>
                <button class="btn radio-button">Breitling</button>
                <button class="btn radio-button">Cartier</button>
                <button class="btn radio-button">Jaeger-LeCoultre</button>
                <button class="btn radio-button">Vacheron Constantin</button>
                <button class="btn radio-button">Oris</button>
            </div>
        </div>
        
        <hr class="mt-5">

        <div class="mt-5">
            <div class="filters">
                <span>Showing 1 - 12 of <?php echo $totalProducts; ?> results</span>
                <div class="d-flex align-items-center gap-3">
                <select class="form-select w-auto" id="sort-filter">
                    <option value="bestseller">Best Seller</option>
                    <option value="low_to_high">Price: Low to High</option>
                    <option value="high_to_low">Price: High to Low</option>
                </select>

                    <div class="view-icons">
                        <span><i class="bi bi-list-ul"></i></span>
                        <span><i class="bi bi-grid-3x3-gap-fill"></i></span>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  
                    
            ?>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="product-card text-center p-3 position-relative" data-product-id="<?php echo $row['id']; ?>">
                        <div class="sale-badge">
                        <button id="sale">SALE</button>
                        </div>
                        <div class="wishlist-icon-m">
    <i class="bi bi-heart wishlist-btn-m"></i>
</div>
                        <img class="product-image" src="<?php echo htmlspecialchars($row['productImage']); ?>" class="img-fluid" alt="Watch">
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="productname"><?php echo htmlspecialchars($row['productName']); ?></h6>
                        <h6 class="mt-2 price">
                            <?php echo number_format($row['salePrice'], decimals: 0) . '$'; ?>
                            <span class="old-price"><?php echo number_format($row['productPrice'], decimals: 0) . '$'; ?></span>
                        </h6>
                    </div>
                    <h6 class="description"><?php echo htmlspecialchars($row['description']); ?></h6>
                    <div class="rating">
                        <?php
                        $rating = $row['productRating'];
                        for($i = 0; $i < 5; $i++) {
                            if($i < $rating) {
                                echo '<i class="bi bi-star-fill"></i>';
                            } else {
                                echo '<i class="bi bi-star"></i>';
                            }
                        }
                        ?>
                        <span class="ratingnumber">(<?php echo $rating; ?>)</span>
                    </div>
                    <button class="add-to-cart mt-2" onclick="viewProduct(<?php echo $row['id']; ?>)">Add To Cart</button>
                </div>
            <?php
                }
            } else {
                echo "<div class='col-12 text-center'><p>No sale items available at the moment.</p></div>";
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
                    <img src="images/logo-white.svg" alt="Logo" class="footer-logo" width="300px" style="margin-left: -20px;">
                    <hr>
                    <p class="footer-text">Absolutely love this watch! The design is elegant, and the quality is amazing. It’s comfortable to wear and looks great for any occasion. Fast shipping and well-packaged. Highly recommend!</p>
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
                    <p class="footer-contact-us"><i class="fas fa-map-marker-alt"></i> 367, lotus street, galle</p>
                    <p class="footer-contact-us"><i class="fas fa-phone"></i> 0773234685</p>
                    <p class="footer-contact-us"><i class="fas fa-envelope"></i> sampleemailaddress.com</p>

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
                <p  class="footer-contact-us" style="padding-right: 100px;">All Copyrights Reserved © ALANKARAGE HOLDINGS</p>
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
        document.getElementById("sort-filter").addEventListener("change", function() {
    let sortOption = this.value;
    window.location.href = "?sort=" + sortOption;
});

        </script>
        <script>
            document.querySelectorAll(".category-filter").forEach(button => {
    button.addEventListener("click", function () {
        let category = this.getAttribute("data-category");
        let sort = document.getElementById("sort-filter").value;
        window.location.href = "?category=" + category + "&sort=" + sort;
    });
});

document.getElementById("sort-filter").addEventListener("change", function () {
    let sort = this.value;
    let urlParams = new URLSearchParams(window.location.search);
    let category = urlParams.get("category") || "";
    window.location.href = "?category=" + category + "&sort=" + sort;
});

            </script>
        </body>
</html>