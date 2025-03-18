<?php
session_start();

// Check if cart exists
if (isset($_SESSION['cart'])) {
    // Get the action (increase or decrease)
    if (isset($_GET['action']) && isset($_GET['index'])) {
        $index = $_GET['index'];
        $action = $_GET['action'];

        // Ensure the index is valid
        if (isset($_SESSION['cart'][$index])) {
            // Increase quantity
            if ($action === 'increase') {
                $_SESSION['cart'][$index]['quantity'] += 1;
            }
            // Decrease quantity
            elseif ($action === 'decrease' && $_SESSION['cart'][$index]['quantity'] > 1) {
                $_SESSION['cart'][$index]['quantity'] -= 1;
            }
        }
    }
}

// Redirect back to the cart page after updating
header("Location: mycart.php");
exit();
?>
