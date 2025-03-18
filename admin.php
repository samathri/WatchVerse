<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
    font-family:"Poppins", serif;
    background-color: #f8f9fa;
}

.sidebar {
    height: 100vh;
    padding-top: 20px;
    background-color: #fff;
}

.sidebar .btn {
    margin-bottom: 10px;
    text-align: left;
    background-color: orange;
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
    padding: 15px 30px;
    font-size: 18px; 
    font-weight:lighter !important;
}

.card {
    background-color:orange;
    color: black;
    text-align: center;
    font-size: 18px;
    font-weight:lighter;
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
    border-color: orange;
}

.product-upload input {
    margin-bottom: 10px;
}

.table thead {
    background-color: black;
    color: white;
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}

footer {
    background-color: #343a40;
    color: white;
}

#imagePreview {
    width: 100px;
    height: 100px;
    border: 1px solid #ddd;
    background-size: cover;
    background-position: center;
}
.btn-secondary{
    background-color: black !important;
    color: white;
}
.btn-secondary:hover{
    background-color: orange !important;
    color: white;

}
.btn-dark{
    background-color: black !important;
    color: white;
}
.btn-dark:hover{
    background-color: orange !important;
    color: white;
}
.form-control{
    border-color:black;
}
.form-control:hover{
    border-color: orange;
}
.table-bordered{
    border-color: black;
}
.btn-danger {
    padding: 12px 24px; 
    font-size: 16px; 
    border-radius: 5px;
    
}
.btn-success{
        padding: 12px 24px; 
        font-size: 16px; 
        border-radius: 5px; 
}

.custom-container {
    max-width: 1200px;
}

.custom-card {
    background: black;
    color: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    width: 32%;
}

.custom-card img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
}

.custom-stars {
    color: rgb(255, 123, 0);
}

.custom-btn {
    background: white;
    color: black;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}

.custom-filter-btn {
    background: white;
    border: none;
    font-size: 16px;
    cursor: pointer;
}

@media (max-width: 992px) {
    .custom-card {
        width: 48%;
    }
}

@media (max-width: 768px) {
    .custom-card {
        width: 100%;
    }
    .sidebar {
        height: auto;
    }
    .sidebar .btn {
        padding: 10px 20px;
        font-size: 16px;
    }
    .card {
        font-size: 16px;
    }
    .product-upload input {
        width: 100%;
    }
    .table-responsive {
        overflow-x: auto;
    }
}
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Dashboard Header -->
        <header class="d-flex justify-content-between align-items-center p-3">
            <h2>DASHBOARD</h2>
            <div class="profile d-flex align-items-center">
                <img src="images/profile.png" alt="Profile Picture" class="rounded-circle me-2" width="40">
                <span>WELCOME! SARA</span>
            </div>
        </header>
        
        <!-- Sidebar and Main Content -->
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block sidebar bg-light">
                <ul class="nav flex-column">
                    <li class="nav-item"><button class="btn btn-warning w-100">Dashboard</button></li>
                    <li class="nav-item"><button class="btn btn-warning w-100">Product Upload</button></li>
                    <li class="nav-item"><button class="btn btn-warning w-100">Customer Details</button></li>
                    <li class="nav-item"><button class="btn btn-warning w-100">Order Details</button></li>
                    <li class="nav-item"><button class="btn btn-warning w-100">Review Details</button></li>
                    <li class="nav-item"><button class="btn btn-warning w-100">Logout</button></li>
                </ul>
            </nav>
            <main class="col-md-9 col-lg-10 px-md-4">
                <!-- Dashboard Cards -->
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3"><div class="card p-3">Total Users <span>900</span></div></div>
                    <div class="col-md-3 col-sm-6 mb-3"><div class="card p-3">Total Sales <span>200</span></div></div>
                    <div class="col-md-3 col-sm-6 mb-3"><div class="card p-3">Total Rates <span>2000</span></div></div>
                    <div class="col-md-3 col-sm-6 mb-3"><div class="card p-3">Total Delivery <span>200</span></div></div>
                </div>
                
                <!-- Product Upload Form -->
                <div class="product-upload mt-4">
                    <h4>Product Upload</h4>
                    <form id="uploadForm">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 mb-3">
                                <input type="file" class="form-control" id="imageUpload" accept="image/*">
                                <div id="imagePreview" class="mt-2"></div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3"><input type="text" class="form-control" placeholder="Product Name"></div>
                            <div class="col-md-3 col-sm-6 mb-3"><input type="text" class="form-control" placeholder="Category"></div>
                            <div class="col-md-3 col-sm-6 mb-3"><input type="text" class="form-control" placeholder="Price"></div>
                        </div>
                        <div class="text-end mt-2">
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-dark">Submit</button>
                        </div>
                    </form>
                </div>
                
                <!-- Product Details Sections -->
                <div class="details-sections mt-4">
                    <h4>Product Details</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr><th>P_ID</th><th>P_Image</th><th>P_Name</th><th>P_Category</th><th>P_Description</th><th>P_Price</th><th>Action</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>1</td><td>-</td><td>Sample</td><td>Category</td><td>Unique Design</td><td>$100</td><td><button class="delete btn btn-danger">Delete</button></td><td><button class="edit btn btn-success">Edit</button></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                 <!-- Customer Details Sections -->
                 <div class="details-sections mt-4">
                    <h4>Customer Details</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr><th>C_ID</th><th>C_FullName</th><th>C_Gender</th><th>C_Contact No</th><th>C_Email</th><th>C_Address</th><th>C_City</th><th>C_Country</th><th>Action</th><th>Action</th> </tr>
                            </thead>
                            <tbody>
                                <tr><td>1</td><td>Anushani Dayaratne</td><td>Female</td><td>0777 45 7890</td><td>anushani@gmail.com</td><td>Ratnapura Rd,Ratnapura</td><td>Ratnapura</td><td>Sri Lanka</td><td><button class="delete btn btn-danger">Delete</button></td><td><button class="edit btn btn-success">Edit</button></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                 <!--  Order Details Sections -->
                 <div class="details-sections mt-4">
                    <h4>Order Details</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr><th>O_ID</th><th>C_FullName</th><th>C_Address</th><th>O_Ordered Date</th><th>O_Delivered</th><th>O_Cost</th><th>O_Payment Type</th><th>O_Order Status</th> <th>Action</th><th>Action</th> </tr>
                            </thead>
                            <tbody>
                                <tr><td>1</td><td>Anushani Dayaratne</td><td>Ratnapura Rd,Ratnapura</td><td>03:04:2025</td><td>10:02:2025</td><td>Rs.1450000</td><td>Online</td><th>Pending</th><td><button class="delete btn btn-danger">Delete</button></td><td><button class="edit btn btn-success">Edit</button></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                 <!--  Review Details Sections -->
                 
                    <div id="review-container" class="custom-container mt-4">
                        <h4 id="review-title">Review Details</h4>
                        <div class="d-flex justify-content-end">
                            <button id="filter-btn" class="btn custom-filter-btn">&#9881; Filter</button>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 d-flex justify-content-between flex-wrap" id="review-list">
                                <!-- Reviews will be inserted here dynamically -->
                            </div>
                        </div>
                    </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".table tbody tr td .delete");
    deleteButtons.forEach(button => {
        button.addEventListener("click", function () {
            if (confirm("Are you sure you want to delete this entry?")) {
                this.closest("tr").remove();
            }
        });
    });

    const imageUpload = document.getElementById('imageUpload');
    const imagePreview = document.getElementById('imagePreview');

    imageUpload.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.style.backgroundImage = `url(${e.target.result})`;
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.backgroundImage = '';
        }
    });

    document.getElementById('uploadForm').addEventListener('submit', function (event) {
        event.preventDefault();
        // Handle form submission, e.g., upload image and other data to the server
        alert('Form submitted!');
    });
});


const reviews = [
    {
        name: "SARA WILLIAMS",
        rating: 3,
        review: "Good Watch, Could Be Better. I love how lightweight and comfortable the watch is. The design is beautiful, and it pairs well with both casual and formal outfits. However, I feel the smartwatch features could use a bit more refinement. Overall, a solid buy.",
        image: "images/profile.png"
    },
    {
        name: "SARA WILLIAMS",
        rating: 3,
        review: "Good Watch, Could Be Better. I love how lightweight and comfortable the watch is. The design is beautiful, and it pairs well with both casual and formal outfits. However, I feel the smartwatch features could use a bit more refinement. Overall, a solid buy.",
        image: "images/profile.png"
    },
    {
        name: "SARA WILLIAMS",
        rating: 3,
        review: "Good Watch, Could Be Better. I love how lightweight and comfortable the watch is. The design is beautiful, and it pairs well with both casual and formal outfits. However, I feel the smartwatch features could use a bit more refinement. Overall, a solid buy.",
        image: "images/profile.png"
    }
];

const reviewContainer = document.getElementById("review-list");

reviews.forEach((review, index) => {
    const card = document.createElement("div");
    card.classList.add("custom-card");
    card.id = `review-card-${index}`;

    card.innerHTML = `
        <div class="d-flex align-items-center">
            <img src="${review.image}" alt="User" id="profile-img-${index}">
            <div class="ms-3">
                <strong id="reviewer-name-${index}">${review.name}</strong>
                <div class="custom-stars" id="stars-${index}">${'★'.repeat(review.rating) + '☆'.repeat(5 - review.rating)}</div>
            </div>
        </div>
        <p id="review-text-${index}">${review.review}</p>
        
        <button class="custom-btn" id="delete-btn-${index}"> Delete</button>
    `;

    reviewContainer.appendChild(card);
});
    </script>

</body>
</html>