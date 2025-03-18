<?php
if (isset($_SESSION['notification']) && $_SESSION['notification']['type'] === 'error') {
    $message = $_SESSION['notification']['message'];
    echo "
    <div id='notification-overlay' class='position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center' style='z-index: 1050; background: rgba(0, 0, 0, 0.3); backdrop-filter: blur(8px);'>
        <div class='shadow-lg p-4 text-center' style='background: white; width: 350px; border-radius: 12px; position: relative;'>
            <button onclick='closeNotification()' style='position: absolute; top: 10px; right: 10px; background: none; border: none; font-size: 18px; cursor: pointer; color: black; opacity: 0.7;'>
              <i class='bi bi-x-lg'></i>
            </button>

            
            <div class='mb-3'>
                <i class='bi bi-exclamation-circle-fill' style='font-size: 50px; color: #F44336;'></i>
            </div>
            <h5 class='fw-bold' style='color: black;'>Error</h5>
            <p class='text-muted' style='font-size: 14px;'>$message</p>
            <button class='btn w-100' style='background: #F44336; color: white; border-radius: 8px;' onclick='closeNotification()'>OK</button>
        </div>
    </div>
    <script>
        function closeNotification() {
            document.getElementById('notification-overlay').remove();
        }
    </script>";
    unset($_SESSION['notification']); 
}
?>
