<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'not_logged_in'
    ]);
    exit;
}

if (!isset($_POST['product_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Product ID is required'
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];

$check_sql = "SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $user_id, $product_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    $delete_sql = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("ii", $user_id, $product_id);
    
    if ($delete_stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'action' => 'removed',
            'message' => 'Product removed from wishlist'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to remove product from wishlist'
        ]);
    }
} else {
    $insert_sql = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("ii", $user_id, $product_id);
    
    if ($insert_stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'action' => 'added',
            'message' => 'Product added to wishlist'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to add product to wishlist'
        ]);
    }
}

$conn->close();
?>