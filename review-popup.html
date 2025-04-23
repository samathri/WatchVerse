<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Review</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        
.btn-primaryR{
    background-color: #ff9d00;
    color: white;
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
    background-color: orange;
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
    background-color: #ff9d00;
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
    </style>
</head>
<body>
    <!-- Write Review Button -->
    <div class="text-center mt-5">
        <button class="btn btn-primaryR" data-bs-toggle="modal" data-bs-target="#reviewModal">Write Review</button>
    </div>

    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Star Ratings -->
                    <div class="rating mb-4">
                        <span class="star" data-value="1"><i class="far fa-star"></i></span>
                        <span class="star" data-value="2"><i class="far fa-star"></i></span>
                        <span class="star" data-value="3"><i class="far fa-star"></i></span>
                        <span class="star" data-value="4"><i class="far fa-star"></i></span>
                        <span class="star" data-value="5"><i class="far fa-star"></i></span>
                    </div>

                    <!-- Review Details -->
                    <div class="mb-4">
                        <label for="reviewDetails" class="form-label">Review Details</label>
                        <textarea class="form-control" id="reviewDetails" rows="4" placeholder="Write your review here..."></textarea>
                    </div>

                    <!-- Upload Image -->
                    <div class="mb-4">
                        <label for="imageUpload" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="imageUpload" accept="image/*" style="display: none;">
                        <div class="image-upload-container">
                            <button class="btn btn-upload" id="uploadButton">
                                <i class="fas fa-upload"></i> Upload Image
                            </button>
                            <div class="image-preview mt-3" id="imagePreview">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-submit">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        
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
    const file = imageUpload.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.innerHTML = `
                <img src="${e.target.result}" alt="Uploaded Image">
                <div class="actions">
                    <button onclick="editImage()"><i class="fas fa-edit"></i></button>
                    <button onclick="deleteImage()"><i class="fas fa-trash"></i></button>
                </div>
            `;
        };
        reader.readAsDataURL(file);
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
    document.getElementById('reviewModal').classList.remove('show'); l
    document.body.classList.remove('modal-open'); 
    document.querySelector('.modal-backdrop').remove(); 
});
    </script>
</body>
</html>