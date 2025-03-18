<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

if (!isset($_POST['wishlist_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No wishlist ID provided']);
    exit;
}

$wishlist_id = $_POST['wishlist_id'];
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM wishlist WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $wishlist_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to remove item']);
}

?>