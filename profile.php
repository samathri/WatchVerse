<?php
session_start();
include 'php/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}



// Process form submission for profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $user_id = $_SESSION['user_id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $contactNo = $_POST['contactNo'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    
    // Update user_registration table
    $updateUserSql = "UPDATE user_registration SET 
                      userFname = ?, 
                      userLname = ?, 
                      userEmail = ?, 
                      userPhone = ? 
                      WHERE id = ?";
    
    $updateUserStmt = $conn->prepare($updateUserSql);
    $updateUserStmt->bind_param("ssssi", $firstName, $lastName, $email, $contactNo, $user_id);
    $userUpdateSuccess = $updateUserStmt->execute();
    
    // Check if shipping_details record exists
    $checkShippingSql = "SELECT * FROM shipping_details WHERE user_id = ?";
    $checkShippingStmt = $conn->prepare($checkShippingSql);
    $checkShippingStmt->bind_param("i", $user_id);
    $checkShippingStmt->execute();
    $shippingResult = $checkShippingStmt->get_result();
    
    if ($shippingResult->num_rows > 0) {
        // Update existing shipping_details
        $updateShippingSql = "UPDATE shipping_details SET address = ? WHERE user_id = ?";
        $updateShippingStmt = $conn->prepare($updateShippingSql);
        $updateShippingStmt->bind_param("si", $address, $user_id);
        $shippingUpdateSuccess = $updateShippingStmt->execute();
    } else {
        // Insert new shipping_details record
        $insertShippingSql = "INSERT INTO shipping_details (user_id, address) VALUES (?, ?)";
        $insertShippingStmt = $conn->prepare($insertShippingSql);
        $insertShippingStmt->bind_param("is", $user_id, $address);
        $shippingUpdateSuccess = $insertShippingStmt->execute();
    }
    
    if ($userUpdateSuccess && $shippingUpdateSuccess) {
        $updateMessage = "Profile updated successfully!";
    } else {
        $updateMessage = "Error updating profile. Please try again.";
    }
    
    // Redirect to avoid form resubmission
    header("Location: profile.php?message=" . urlencode($updateMessage));
    exit;
}

// For AJAX update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_update'])) {
    $user_id = $_SESSION['user_id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $contactNo = $_POST['contactNo'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    
    // Update user_registration table
    $updateUserSql = "UPDATE user_registration SET 
                      userFname = ?, 
                      userLname = ?, 
                      userEmail = ?, 
                      userPhone = ? 
                      WHERE id = ?";
    
    $updateUserStmt = $conn->prepare($updateUserSql);
    $updateUserStmt->bind_param("ssssi", $firstName, $lastName, $email, $contactNo, $user_id);
    $userUpdateSuccess = $updateUserStmt->execute();
    
    // Check if shipping_details record exists
    $checkShippingSql = "SELECT * FROM shipping_details WHERE user_id = ?";
    $checkShippingStmt = $conn->prepare($checkShippingSql);
    $checkShippingStmt->bind_param("i", $user_id);
    $checkShippingStmt->execute();
    $shippingResult = $checkShippingStmt->get_result();
    
    if ($shippingResult->num_rows > 0) {
        // Update existing shipping_details
        $updateShippingSql = "UPDATE shipping_details SET address = ? WHERE user_id = ?";
        $updateShippingStmt = $conn->prepare($updateShippingSql);
        $updateShippingStmt->bind_param("si", $address, $user_id);
        $shippingUpdateSuccess = $updateShippingStmt->execute();
    } else {
        // Insert new shipping_details record
        $insertShippingSql = "INSERT INTO shipping_details (user_id, address) VALUES (?, ?)";
        $insertShippingStmt = $conn->prepare($insertShippingSql);
        $insertShippingStmt->bind_param("is", $user_id, $address);
        $shippingUpdateSuccess = $insertShippingStmt->execute();
    }
    
    if ($userUpdateSuccess && $shippingUpdateSuccess) {
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating profile: ' . $conn->error]);
    }
    
    exit;
}


$user_id = $_SESSION['user_id'];
$sql = "SELECT p.*, w.id as wishlist_id 
        FROM wishlist w 
        JOIN products p ON w.product_id = p.id 
        WHERE w.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();


$sql = "SELECT * FROM order_summary ORDER BY order_date Desc";
$result1 = $conn->query($sql);

// Check for errors in the shipping_details query
$sql1 = "SELECT ur.userFname, ur.userLname, ur.userEmail, ur.userPhone, 
         sd.address 
         FROM user_registration ur
         LEFT JOIN shipping_details sd ON ur.id = sd.user_id
         WHERE ur.id = ?";
         
$stmt1 = $conn->prepare($sql1);
// Check if prepare was successful
if ($stmt1 === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt1->bind_param("i", $user_id);
$stmt1->execute();
$user_result = $stmt1->get_result();
$user_data = $user_result->fetch_assoc();


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <link href="checkout_syle.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="style/styles.css" rel="stylesheet">
    <link href="script.js" rel="stylesheet">

    <style>
        .content-box{
            margin-top: 30px;
  width: 100%;
  border-radius: 10px;
  padding: 25px;
  background-color: #f4f4f4;
  box-shadow: 2px 2px #b0aead;
  margin-top:
   90px;
        }

        .wishlist-box{
            font-size: 18px;
            margin-top: 30px;
  width: 100%;
  border-radius: 10px;
  padding: 25px;
  background-color: #f4f4f4;
  box-shadow: 2px 2px #b0aead;
  margin-top:
   90px;
            
        }

        .wishlist-box #watchimage{

            height:150px;


        }

        .wishlist-box h1{
            font-size: 20px;
            
           
        }

 #orderSummarySection, #mywishlistSection, #buyonsaleSection,
 #myreviewsSection, #mypaymentsSection, #introductionSection {
            display: none;
        }

.divider {
    width: 80%;
    background-color:#FF7700;
    margin: 8px 0;
}



button:last-child {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}

.menu-button {
            display: block;
            width: 90%;
            padding: 12px;
            font-weight: 600;
            border: none;
            margin-top: 20px;
            background-color: #ffffff;
            color: black;
            text-align: center;
            font-size: 15px;
            cursor: pointer;
            border-radius: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            
        }

        /* Active button styling */
        .menu-button.active-btn {
        
            color: #FC8C1C;
            
        }

        #watchimage{
            height: 100px;
        }

        .wishlist-box table {
    width: 100%;
    text-align: center;
}

.wishlist-box td {
    padding: 10px;
}

.wishlist-box .flex {
    display: flex;
    align-items: center;
    justify-content: center;
}

.wishlist-box .flex > * + * {
    margin-left: 10rem; 
}



        
        .btn-primaryR{
            background-color: #FC8C1C;
            color: white;
            font-size:10px;
            width: 250px;
        }
        .btn-primaryR:hover{
            background-color: #000000;
            color: white;
        }
        
        /* Star Rating Styles */
        .rating {
            font-size: 2rem;
            color: orange; 
            cursor: pointer;
        }
        
        .rating .star {
            transition: color 0.2s;
        }
        
        .rating .star:hover,
        .rating .star.active {
            color: orange;
        }
        
        /* Submit Button Styles */
        .btn-submit {
            background-color: #FC8C1C;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        
        .btn-submit:hover {
            background-color: darkorange;
        }
        
        /* Upload Button Styles */
        .btn-upload {
            background-color: #000000;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        
        .btn-upload:hover {
            background-color: #FC8C1C;
        }
        
        /* Image Preview Styles */
        .image-preview {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .image-preview img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        
        .image-preview .actions {
            display: flex;
            gap: 5px;
        }
        
        .image-preview .actions button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .image-preview .actions button:hover {
            background-color: #cc0000;
        }
        
        /* Modal Styles */
        .modal-content {
            border-radius: 10px;
        }
        
        .modal-header {
            border-bottom: 1px solid #ddd;
        }
        
        .modal-footer {
            border-top: 1px solid #ddd;
        }
            

.introductionSection {
        background: white;
        border-radius: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 40px;
        margin-top: 90px;
    }

    .personal-info-form {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .personal-info-form .form-group {
        margin-bottom: 20px;
    }

    .personal-info-form label {
        display: block;
        font-size: 14px;
        color: #333;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .personal-info-form input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
    }

    .personal-info-form .edit-btn {
        grid-column: 2;
        justify-self: end;
        padding: 10px 30px;
        background: #1a1a1a;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .personal-info-form .edit-btn i {
        font-size: 16px;
    }

    .section-title {
        font-size: 18px;
        font-weight: bold;
        color: #1a1a1a;
        margin-bottom: 30px;
        text-transform: uppercase;
    }

    </style>

</head>
  <body>
      
    <!-- Mobile Header -->
    <header class="mobile-nav p-3">
        <div class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></div>
        <a href="#" class="navbar-brand">
            <img src="images/logo-black.svg" alt="Logo" class="logo" width="150px">
        </a>
        <a href="mycart.php"><i class="bi bi-cart3"></i></a>
    </header>

    <!-- Desktop Header -->
    <header class="desktop-nav py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex gap-5">
                <a href="#"><i class="bi bi-heart"></i></a>
                <a href="#"><i class="bi bi-search"></i></a>
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
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person nav-link active" style="font-size: 24px;"></i>
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
            <button class="menu-icon search-btn" id="mobileSearchIcon"><i class="fas fa-search"></i></button>
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
        <div class="row">
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="profile flex flex-col items-center">
                        <img src="./images/Ellipse 11 1.png" class="w-24 h-24 mb-2" style="margin-top:10px">
                        <p class="text-center" style="margin-top: 10px"><b>SARA</b></p>
                        <div class="divider"></div>
                        
                <button class="menu-button" onclick="showSection('introductionSection', this)">INTRODUCTION</button>
                <button class="menu-button" onclick="showSection('mywishlistSection', this)">MY WISHLIST</button>
                <button class="menu-button" onclick="showSection('buyonsaleSection', this)">BUY ON SALE</button>
                <button class="menu-button" onclick="showSection('orderSummarySection', this)">ORDER SUMMARY</button>
                <button class="menu-button" onclick="showSection('mypaymentsSection', this)">MY PAYMENTS</button>
                <button class="menu-button" onclick="showSection('', this)">LOG OUT <i class="bi bi-box-arrow-right"></i></button>
                    </div>

                    
                </div>
                
    
                <div class="col-12 col-md-9">
                <div id="orderSummarySection">
                    <div class="odersummarydiv" style="background-color: #d9d9d91F;">
                        <h4 class="mb-4">Orders Summary</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead></thead>
                                <tbody>

                            
                                <?php
if ($result1->num_rows > 0) {
    while ($firstRow = $result1->fetch_assoc()) {
        $hasReview = !empty($firstRow['review_rating']);
        $productid = $firstRow['id'];
?>
        <tr class="dd">
            <td class="py-2 px-4 flex items-center space-x-2">
                <img src="<?php echo htmlspecialchars($firstRow["image"]); ?>" alt="Watch" class="w-5 h-5" id="watchimage">
            </td>
            <td class="py-2 px-4"><?php echo htmlspecialchars($firstRow["name"]); ?></td>
            <td class="py-2 px-4">$<?php echo htmlspecialchars($firstRow["price"]); ?></td>
            <td class="py-2 px-4">Item <?php echo htmlspecialchars($firstRow["quantity"]); ?></td>
            <td class="py-2 px-4">Order Date <?php echo htmlspecialchars($firstRow["order_date"]); ?></td>
            <td class="py-2 px-4">
            <?php if ($hasReview && $firstRow['review_rating'] > 0): ?>
    <!-- Display Review -->
    <div class="review" style="display: flex; align-items: flex-start; gap: 12px;">
        <div style="flex: 1;">
            <div class="rating" style="white-space: nowrap;"> <!-- Prevent stars from wrapping -->
                <?php
                // Display stars based on rating
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $firstRow['review_rating']) {
                        echo '<i class="fas fa-star" style="font-size: 14px;"></i>';
                    } else {
                        echo '<i class="far fa-star" style="font-size: 14px;"></i>';
                    }
                }
                ?>
            </div>
            <p style="color: #000000; margin-top: 10px;"><?php echo htmlspecialchars($firstRow['review_description']); ?></p>
        </div>

        <?php if (!empty($firstRow['review_image'])): ?>
            <?php
            // Decode the JSON string into an array
            $imagePaths = json_decode($firstRow['review_image'], true);
            if (is_array($imagePaths)): ?>
                <div style="display: flex; gap: 5px; flex-wrap: wrap; margin-top: 10px;">
                    <?php foreach ($imagePaths as $image): ?>
                        <div style="flex-shrink: 0;">
                            <img src="<?php echo htmlspecialchars(trim($image)); ?>" alt="Review Image" class="review-image" style="height: 35px; width: 35px; border-radius: 5px; object-fit: cover;">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php elseif ($firstRow['review_rating'] == 0): ?>
    <!-- Write Review Button -->
    <button class="btn btn-primaryR" data-bs-toggle="modal" data-bs-target="#reviewModal" data-product-id="<?php echo $productid; ?>">
        Write Review
    </button>
<?php endif; ?>

</tr>
<?php
    
    } 
} else {
?>
    <tr>
        <td colspan="6" class="text-center py-5">
            <h3>Your Order Summary is empty</h3>
        </td>
    </tr>
<?php
}
?>


            </td>
        </tr>

                    

                                        </td>
                                    </tr>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="profile_review.php" method="POST" enctype="multipart/form-data">
                    <!-- Product ID (Hidden) -->
                    <input type="hidden" name="productid" id="modalProductId" value="">

                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

                    <!-- Star Ratings -->
                    <div class="rating mb-4">
                        <span class="star" data-value="1"><i class="far fa-star"></i></span>
                        <span class="star" data-value="2"><i class="far fa-star"></i></span>
                        <span class="star" data-value="3"><i class="far fa-star"></i></span>
                        <span class="star" data-value="4"><i class="far fa-star"></i></span>
                        <span class="star" data-value="5"><i class="far fa-star"></i></span>
                    </div>
                    <input type="hidden" name="review_rating" id="review_rating" value="0">

                    <!-- Review Details -->
                    <div class="mb-4">
                        <label for="reviewDetails" class="form-label">Review Details</label>
                        <textarea class="form-control" id="reviewDetails" name="reviewDetails" rows="4" required></textarea>
                    </div>

                    <!-- Upload Images -->
                    <div class="mb-4">
                        <label for="imageUpload" class="form-label">Upload Images</label>
                        <input type="file" class="form-control" id="imageUpload" name="imageUpload[]" accept="image/*" multiple>
                        <div id="imagePreview" class="mt-3"></div> <!-- Preview Section -->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


                </tbody>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>

document.getElementById('imageUpload').addEventListener('change', function() {
    const imagePreview = document.getElementById('imagePreview');
    imagePreview.innerHTML = ''; // Clear previous previews

    const files = this.files;
    if (files.length > 0) {
        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.classList.add('preview-image');
                imgElement.style.width = '100px'; // Adjust preview size
                imgElement.style.margin = '5px';
                imagePreview.appendChild(imgElement);
            };
            reader.readAsDataURL(file);
        });
    }
});


document.addEventListener("DOMContentLoaded", function () {
    // Add event listeners to all "Write Review" buttons
    document.querySelectorAll('.btn-primaryR').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            document.getElementById('modalProductId').value = productId;
        });
    });

    // Star Rating Functionality
    let stars = document.querySelectorAll(".star");
    let ratingInput = document.getElementById("review_rating");

    stars.forEach(function (star) {
        star.addEventListener("click", function () {
            let rating = this.getAttribute("data-value");
            ratingInput.value = rating; // Store rating as a number

            // Update star UI
            stars.forEach(function (s) {
                s.firstElementChild.classList.remove("fas");
                s.firstElementChild.classList.add("far");
            });

            for (let i = 0; i < rating; i++) {
                stars[i].firstElementChild.classList.remove("far");
                stars[i].firstElementChild.classList.add("fas");
            }
        });
    });
});


        
// Star Rating Functionality
const stars = document.querySelectorAll('.rating .star');

stars.forEach(star => {
    star.addEventListener('click', function () {
        const value = parseInt(this.getAttribute('data-value'));
        stars.forEach((s, index) => {
            if (index < value) {
                s.classList.add('active');
                s.innerHTML = '<i class="fas fa-star"></i>'; 
            } else {
                s.classList.remove('active');
                s.innerHTML = '<i class="far fa-star"></i>';
            }
        });
    });
});

// Image Upload Functionality
const imageUpload = document.getElementById('imageUpload'); 
const uploadButton = document.getElementById('uploadButton'); 
const imagePreview = document.getElementById('imagePreview');  

uploadButton.addEventListener('click', () => {     
    imageUpload.click(); // Trigger file input 
});  

imageUpload.addEventListener('change', () => {     
    imagePreview.innerHTML = ''; // Clear previous images
    const files = imageUpload.files;     

    if (files.length > 0) {         
        Array.from(files).forEach(file => {             
            const reader = new FileReader();             
            reader.onload = (e) => {                 
                const imageContainer = document.createElement('div');                 
                imageContainer.classList.add('image-container');                 
                imageContainer.innerHTML = `                     
                    <img src="${e.target.result}" alt="Uploaded Image">                     
                    <div class="actions">                         
                        <button onclick="editImage(this)"><i class="bi bi-pencil-square"></i></button>                         
                        <button onclick="deleteImage(this)"><i class="bi bi-trash"></i></button>                     
                    </div>                 
                `;                 
                imagePreview.appendChild(imageContainer);             
            };             
            reader.readAsDataURL(file);         
        });     
    } 
}); 

// Edit Image Function
function editImage() {
    imageUpload.click(); 
}

// Delete Image Function
function deleteImage() {
    imagePreview.innerHTML = ''; 
    imageUpload.value = ''; 
}

// Submit Button Functionality
const submitButton = document.querySelector('.btn-submit');
submitButton.addEventListener('click', () => {
    const reviewDetails = document.getElementById('reviewDetails').value;
    const selectedStars = document.querySelectorAll('.rating .star.active').length;
    const imageUploaded = imageUpload.files.length > 0;

    if (!reviewDetails || selectedStars === 0) {
        alert('Please fill out all fields and select a rating.');
        return;
    }

    console.log('Review Details:', reviewDetails);
    console.log('Selected Stars:', selectedStars);
    console.log('Image Uploaded:', imageUploaded ? 'Yes' : 'No');

    alert('Review submitted successfully!');
    document.getElementById('reviewModal').classList.remove('show'); 
    document.body.classList.remove('modal-open'); 
    document.querySelector('.modal-backdrop').remove(); 
});
    </script>
                                   
                                    
      
                            </table>
                        </div>
    
                        <div class="container d-flex justify-content-center mt-5 mb-5">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span>&lt;</span>
                                        </a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span>&gt;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    
                </div>
                <div id="introductionSection" class="content-box">

    <h4 class="section-title">Personal Information</h4>
    <form class="personal-info-form">
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user_data['userFname'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($user_data['userLname'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="contactNo">Contact No</label>
            <input type="text" id="contactNo" name="contactNo" value="<?php echo htmlspecialchars($user_data['userPhone'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($user_data['userEmail'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user_data['address'] ?? ''); ?>">
        </div>   
        <button type="button" class="edit-btn">
            EDIT <i class="bi bi-pencil"></i>
        </button>
    </form>
</div>

            
                <div id="mywishlistSection" class="wishlist-box">
    <h4 class="mb-4">My Wishlist</h4>
    <div class="overflow-x-auto">
    <div class="wishlist-items">
        <?php 
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { ?>
                <div class="wishlist-item" data-wishlist-id="<?php echo $row['wishlist_id']; ?>">
                    <img src="<?php echo htmlspecialchars($row['productImage']); ?>" alt="<?php echo htmlspecialchars($row['productName']); ?>">
                    <div class="item-details">
                        <h4><?php echo htmlspecialchars($row['productName']); ?></h4>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                    </div>
                    <span class="price">$<?php echo number_format($row['productPrice'], 2); ?></span>
                    <i class="bi bi-heart"></i>
                    <button class="remove-item" onclick="removeFromWishlist(<?php echo $row['wishlist_id']; ?>)">&times;</button>
                </div>
            <?php }
        } else { ?>
            <div class="text-center py-5">
                <h3>Your wishlist is empty</h3>
                <p>Browse our collection and add items to your wishlist!</p>
                <a href="collection.php" class="btn btn-primary mt-3">Shop Now</a>
            </div>
        <?php } ?>
    </div>
</div>
   

    <div class="container d-flex justify-content-center mt-5 mb-5">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span>&lt;</span>
                    </a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span>&gt;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

            
                <div id="buyonsaleSection" class="content-box">
                <h4 class="mb-4">Buy on Sale</h4>
                <p>This is the Buy on Sale section. You can add content here.</p>
            </div>

            
                <div id="myreviewsSection" class="content-box">
                <h4 class="mb-4">My Reviews</h4>
                <p>This is the My Reviews section. You can add content here.</p>
            </div>

            
                <div id="mypaymentsSection" class="content-box">
                <h4 class="mb-4">My Payments</h4>
                <p>This is the My Payments section. You can add content here.</p>
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
                <p  class="footer-contact-us" style="padding-right: 100px;">All Copyrights Reserved © ALANKARAGE HOLDINGS</p>
                <p>
                    <a href="#" style="font-weight: 100;">Privacy Policy</a> 
                    <a href="#" style="font-weight: 100;">Terms of Use</a>
                </p>
            </div>
            
        </div>
        <script>
    function showSection(sectionId) {
        document.querySelectorAll('.col-12.col-md-9 > div').forEach(div => {
            div.style.display = 'none';
        });

        document.getElementById(sectionId).style.display = 'block';
    }
</script>
<script>
    function showSection(sectionId, clickedButton) {
        document.querySelectorAll('.col-12.col-md-9 > div').forEach(div => {
            div.style.display = 'none';
        });

        if (sectionId) {
            document.getElementById(sectionId).style.display = 'block';
        }

        document.querySelectorAll('.menu-button').forEach(button => {
            button.classList.remove('active-btn');
        });

        clickedButton.classList.add('active-btn');
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    showSection('introductionSection', document.querySelector('.menu-button'));
  
    document.querySelector('.menu-button').classList.add('active-btn');
});

function showSection(sectionId, clickedButton) {
    document.querySelectorAll('.col-12.col-md-9 > div').forEach(div => {
        div.style.display = 'none';
    });

    if (sectionId) {
        document.getElementById(sectionId).style.display = 'block';
    }

    document.querySelectorAll('.menu-button').forEach(button => {
        button.classList.remove('active-btn');
    });

    clickedButton.classList.add('active-btn');
}
</script>

<script>
function removeFromWishlist(wishlistId) {
    if (confirm('Are you sure you want to remove this item from your wishlist?')) {
        fetch('php/remove_from_wishlist.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `wishlist_id=${wishlistId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const item = document.querySelector(`[data-wishlist-id="${wishlistId}"]`);
                item.remove();
                
                const remainingItems = document.querySelectorAll('.wishlist-item');
                if (remainingItems.length === 0) {
                    const wishlistItems = document.querySelector('.wishlist-items');
                    wishlistItems.innerHTML = `
                        <div class="text-center py-5">
                            <h3>Your wishlist is empty</h3>
                            <p>Browse our collection and add items to your wishlist!</p>
                            <a href="collection.php" class="btn btn-primary mt-3">Shop Now</a>
                        </div>
                    `;
                }
            } else {
                alert('Error removing item from wishlist');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while removing the item');
        });
    }
}
</script>

<script>
    window.alert = function() {};
window.confirm = function() { return true; };

</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBtn = document.querySelector('.edit-btn');
    
    editBtn.addEventListener('click', function() {
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const contactNo = document.getElementById('contactNo').value;
        const email = document.getElementById('email').value;
        const address = document.getElementById('address').value;

        const formData = new FormData();
        formData.append('ajax_update', '1');
        formData.append('firstName', firstName);
        formData.append('lastName', lastName);
        formData.append('contactNo', contactNo);
        formData.append('email', email);
        formData.append('address', address);

        fetch('profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the profile');
        });
    });
});
</script>


    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>