<?php
session_start();
include 'php/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productid = $_POST["productid"];
    $review_rating = $_POST["review_rating"];
    $review_description = $_POST["reviewDetails"];
    $user_id = $_POST["user_id"];

    // Handle Multiple Image Uploads
    $uploaded_images = [];
    if (!empty($_FILES["imageUpload"]["name"][0])) {
        $target_dir = "uploads/"; 
        foreach ($_FILES["imageUpload"]["tmp_name"] as $key => $tmp_name) {
            $target_file = $target_dir . basename($_FILES["imageUpload"]["name"][$key]);
            if (move_uploaded_file($tmp_name, $target_file)) {
                $uploaded_images[] = $target_file;
            }
        }
    }

    // Convert the array of image paths to a JSON string
    $review_images = json_encode($uploaded_images);

    // Update the review in the database
    $sql = "UPDATE order_summary SET review_rating = ?, review_description = ?, review_image = ?, user_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issii", $review_rating, $review_description, $review_images, $user_id, $productid);

    if ($stmt->execute()) {
        echo "<script>alert('Review submitted successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error submitting review!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>