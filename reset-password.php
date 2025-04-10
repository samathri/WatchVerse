<?php
session_start();
require_once 'php/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["token"])) {
    $token = $_GET["token"];
    $token_hash = hash("sha256", $token);

    $stmt = $conn->prepare("
        SELECT * FROM user_registration 
        WHERE reset_token_hash = ? 
        AND reset_token_expires_at > NOW()
    ");
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        setNotification("Invalid or expired reset link.", "error");
        header("Location: reset.php");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_password"])) {
    $new_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
    $token_hash = hash("sha256", $_POST["token"]);

    $stmt = $conn->prepare("
        UPDATE user_registration 
        SET userPassword = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL 
        WHERE reset_token_hash = ? 
        AND reset_token_expires_at > NOW()
    ");
    $stmt->bind_param("ss", $new_password, $token_hash);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        setNotification("Password successfully reset. You can now login with your new password.", "success");
        header("Location: login.php");
    } else {
        setNotification("Failed to reset password. Please try again.", "error");
        header("Location: reset.php");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>
    <main class="container text-center mt-5">
        <h2 class="mb-3">Reset Password</h2>
        <hr class="mx-auto mb-4" style="width: 50px; border-top: 2px solid orange;">
        <form id="login-form" class="mx-auto" style="max-width: 400px;">

            <div class="input-group mb-3 position-relative">
                <span class="input-group-text bg-orange text-white"><i class="bi bi-lock"></i></span>
                <input type="password" id="passwordField1" class="form-control" placeholder="Password" required>
                <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y"
                    style="z-index: 10; right: 10px;" onclick="togglePassword('passwordField1', this)">
                    <i class="bi bi-eye-slash-fill"></i>
                </button>
            </div>
            <div class="input-group mb-3 position-relative">
                <span class="input-group-text bg-orange text-white"><i class="bi bi-lock"></i></span>
                <input type="password" id="passwordField2" class="form-control" placeholder="Confirm Password" required>
                <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y"
                    style="z-index: 10; right: 10px;" onclick="togglePassword('passwordField2', this)">
                    <i class="bi bi-eye-slash-fill"></i>
                </button>
            </div>
            <button type="submit" class="btn btn-dark w-100">Reset Password</button>
        </form>
    </main>


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
                <p class="footer-contact-us" style="padding-right: 100px;">All Copyrights Reserved ©HourMarkers
                </p>
                <p>
                    <a href="#" style="font-weight: 100;">Privacy Policy</a>
                    <a href="#" style="font-weight: 100;">Terms of Use</a>
                </p>
            </div>

        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts.js"></script>

    <script>
        function togglePassword(inputId, button) {
            const passwordInput = document.getElementById(inputId);
            const icon = button.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            }
        }
    </script>
</body>

</html>