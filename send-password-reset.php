<?php 
session_start(); 

require __DIR__ . "/mailer.php";
include __DIR__ . "/php/db.php";  

function setNotification($message, $type = "success") {
    $_SESSION['notification'] = [
        "message" => $message,
        "type" => $type
    ];
}

// Check if email was submitted
if (isset($_POST["userEmail"])) {
    $userEmail = $_POST["userEmail"];
    
    // Generate token
    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    
    // Set expiry time (30 minutes from now)
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Check if email exists
    $check_sql = "SELECT userEmail FROM user_registration WHERE userEmail = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $userEmail);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows === 0) {
        setNotification("No account found with the provided email address.", "error");
        header("Location: reset.php");
        exit;
    }
    
    // Update token and expiry
    $sql = "UPDATE user_registration 
            SET reset_token_hash = ?, 
                reset_token_expires_at = ? 
            WHERE userEmail = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        setNotification("Database error: " . $conn->error, "error");
        header("Location: reset.php");
        exit;
    }
    $stmt->bind_param("sss", $token_hash, $expiry, $userEmail);
    
    if (!$stmt->execute()) {
        setNotification("Error updating the reset token.", "error");
        header("Location: reset.php");
        exit;
    }
    
    // Verify the update and send email
    if ($conn->affected_rows > 0) {
        if (sendPasswordResetEmail($userEmail, $token)) {
            setNotification("Password reset email sent successfully. Check your mail.", "success");
        } else {
            setNotification("Failed to send the password reset email.", "error");
        }
    } else {
        setNotification("Failed to update the reset token in the database.", "error");
    }
    
    // Redirect to reset.php
    header("Location: reset.php");
    exit;
} else {
    setNotification("Invalid request.", "error");
    header("Location: reset.php");
    exit;
}
?>
