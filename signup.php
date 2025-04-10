<?php
session_start();
include 'php/db.php';

error_reporting(error_level: 0);
function validatePassword($password)
{
    return strlen($password) >= 8
        && preg_match('@[A-Z]@', $password)
        && preg_match('@[a-z]@', $password)
        && preg_match('@[0-9]@', $password);
}

function validatePhone($phone)
{
    return preg_match('/^[0-9]{10,15}$/', $phone);
}

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    $firstName = mysqli_real_escape_string($conn, $_POST['userFname']);
    $lastName = mysqli_real_escape_string($conn, $_POST['userLname']);
    $phone = mysqli_real_escape_string($conn, $_POST['userPhone']);
    $email = mysqli_real_escape_string($conn, $_POST['userEmail']);
    $password = $_POST['userPassword'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($firstName) || !preg_match("/^[a-zA-Z\s]{2,50}$/", $firstName)) {
        $errors[] = "Invalid first name";
    }

    if (empty($lastName) || !preg_match("/^[a-zA-Z\s]{2,50}$/", $lastName)) {
        $errors[] = "Invalid last name";
    }

    if (!validatePhone($phone)) {
        $errors[] = "Invalid phone number";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address";
    }

    if (!validatePassword($password)) {
        $errors[] = "Password must be at least 8 characters with uppercase, lowercase and numbers";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match!";
    }

    if (!empty($errors)) {
        echo "<script>alert('" . implode("\\n", $errors) . "'); window.history.back();</script>";
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $checkEmail = $conn->prepare("SELECT userEmail FROM user_registration WHERE userEmail = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already registered!'); window.history.back();</script>";
        exit();
    }
    $checkEmail->close();

    $stmt = $conn->prepare("INSERT INTO user_registration (userFname, userLname, userPhone, userEmail, userPassword, confirm_password) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $firstName, $lastName, $phone, $email, $hashedPassword, $hashedPassword);

    if ($stmt->execute()) {

        while (ob_get_level()) {
            ob_end_clean();
        }
        header("Location: login.php");
        echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
        exit();
    } else {
        echo "<script>alert('Registration failed. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>

    <main class="container text-center mt-5">
        <h2 class="mb-3">Sign Up</h2>
        <hr class="mx-auto mb-4" style="width: 50px; border-top: 2px solid orange;">

        <form id="signup-form" action="signup.php" method="POST" class="mx-auto" style="max-width: 400px;">
            <div class="input-group mb-3">
                <span class="input-group-text bg-orange text-white"><i class="bi bi-person"></i></span>
                <input type="text" name="userFname" class="form-control" placeholder="First Name"
                    pattern="[A-Za-z\s]{2,50}" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text bg-orange text-white"><i class="bi bi-person"></i></span>
                <input type="text" name="userLname" class="form-control" placeholder="Last Name"
                    pattern="[A-Za-z\s]{2,50}" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text bg-orange text-white"><i class="bi bi-telephone"></i></span>
                <input type="tel" name="userPhone" class="form-control" placeholder="Contact No" pattern="[0-9]{10,15}"
                    required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text bg-orange text-white"><i class="bi bi-person-circle"></i></span>
                <input type="email" name="userEmail" class="form-control" placeholder="Email" required>
            </div>
            <div class="input-group mb-3 position-relative">
                <span class="input-group-text bg-orange text-white"><i class="bi bi-lock"></i></span>
                <input type="password" name="userPassword" id="passwordField1" class="form-control"
                    placeholder="Password" required>
                <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y"
                    style="z-index: 10; right: 10px;" onclick="togglePassword('passwordField1', this)">
                    <i class="bi bi-eye-slash-fill"></i>
                </button>
            </div>
            <div class="input-group mb-3 position-relative">
                <span class="input-group-text bg-orange text-white"><i class="bi bi-lock"></i></span>
                <input type="password" name="confirm_password" id="passwordField2" class="form-control"
                    placeholder="Confirm Password" required>
                <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y"
                    style="z-index: 10; right: 10px;" onclick="togglePassword('passwordField2', this)">
                    <i class="bi bi-eye-slash-fill"></i>
                </button>
            </div>
            <button type="submit" class="btn btn-dark w-100">Sign Up</button>

            <p class="mt-3">Already a Member? <a href="login.php" class="text-decoration-none">Sign In Now</a></p>
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
        document.getElementById('signup-form').addEventListener('submit', function (e) {
            const password = document.querySelector('input[name="userPassword"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;

            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                e.preventDefault();
                return false;
            }

            if (password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password)) {
                alert('Password must be at least 8 characters with uppercase, lowercase and numbers');
                e.preventDefault();
                return false;
            }
        });
    </script>

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