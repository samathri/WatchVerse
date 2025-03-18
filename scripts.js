document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("signup-form");
  if (form) {
      form.addEventListener("submit", function (e) {
          const password = form.querySelector('input[name="userPassword"]').value;
          const confirmPassword = form.querySelector('input[name="confirm_password"]').value;
          
          if (password !== confirmPassword) {
              e.preventDefault();
              alert("Passwords do not match!");
              return false;
          }
      });
  }
});

// Hamburger Menu
document.getElementById('menuToggle').addEventListener('click', function() {
  document.getElementById('mobileMenu').classList.add('active');
});

document.getElementById('closeMenu').addEventListener('click', function() {
  document.getElementById('mobileMenu').classList.remove('active');
});


// Page link underline

document.addEventListener("DOMContentLoaded", function () {
  let currentPage = window.location.pathname.split("/").pop(); // Get current page file name

  document.querySelectorAll(".nav-link").forEach(link => {
      if (link.getAttribute("href") === currentPage) {
          link.classList.add("active");
      }
  });
});