
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


// My cart quantity increaser

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".cart-quantity-container").forEach((container) => {
        let quantityInput = container.querySelector(".cart-quantity");
        let increaseButton = container.querySelector(".increase");
        let decreaseButton = container.querySelector(".decrease");

        increaseButton.addEventListener("click", function () {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        });

        decreaseButton.addEventListener("click", function () {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
    });
});



// My cart dot color

document.addEventListener("DOMContentLoaded", function () {
    const dots = document.querySelectorAll(".dot-link");

    dots.forEach(dot => {
        dot.addEventListener("click", function () {
            dots.forEach(d => d.classList.remove("active")); // Remove active from all
            this.classList.add("active"); // Add active to clicked dot
        });
    });
});


// Filter Button
document.addEventListener("DOMContentLoaded", function () {
    console.log("Watches Collection filter modal is ready to be used!");
});



// Color Shades
document.addEventListener("DOMContentLoaded", function () {
    const colors = ["#000000", "#FFFFFF", "#0000FF", "#FFFF00", "#FF00FF", "#00FFFF", "#800000", "#808000", "#008000", "#800080",
                    "#808080", "#C0C0C0", "#FFA500", "#A52A2A", "#8A2BE2", "#5F9EA0", "#7FFF00", "#D2691E", "#DC143C", "#008B8B",
                    "#B8860B", "#A9A9A9", "#006400", "#BDB76B", "#556B2F", "#FF8C00", "#9932CC", "#8B0000", "#E9967A", "#8FBC8F",
                    "#483D8B", "#2F4F4F", "#00CED1", "#9400D3", "#FF1493", "#696969", "#1E90FF", "#B22222", "#FF69B4", "#CD5C5C",
                    "#4B0082", "#F08080", "#90EE90", "#20B2AA", "#778899", "#FFA07A", "#B0C4DE", "#ADD8E6", "#F0E68C", "#E6E6FA"];
    const colorContainer = document.getElementById("colorContainer");
    colors.forEach(color => {
        const colorDiv = document.createElement("div");
        colorDiv.classList.add("color-option");
        colorDiv.style.backgroundColor = color;
        colorContainer.appendChild(colorDiv);
    });
});


// price filter
document.addEventListener("DOMContentLoaded", function () {
    const priceRange = document.getElementById("priceRange");
    const startPrice = document.getElementById("startPrice");
    const endPrice = document.getElementById("endPrice");

    priceRange.addEventListener("input", function () {
        endPrice.textContent = `$${priceRange.value}`;
    });
});



document.addEventListener("DOMContentLoaded", function() {
    // Select all custom select elements
    const customSelects = document.querySelectorAll('.custom-select');
  
    customSelects.forEach(customSelect => {
      const selectBox = customSelect.querySelector('.select-box');
      const optionsContainer = customSelect.querySelector('.options-container');
      const selectedOption = customSelect.querySelector('.selected-option');
      const options = customSelect.querySelectorAll('.option');
  
      // Toggle dropdown visibility when clicking the select box
      selectBox.addEventListener('click', function() {
        optionsContainer.style.display = optionsContainer.style.display === 'block' ? 'none' : 'block';
      });
  
      // Handle option selection
      options.forEach(option => {
        option.addEventListener('click', function() {
          selectedOption.textContent = option.textContent;
          
          // Remove the 'selected' class from all options
          options.forEach(opt => opt.classList.remove('selected'));
  
          // Add the 'selected' class to the clicked option
          option.classList.add('selected');
  
          // Close the dropdown after selection
          optionsContainer.style.display = 'none';
        });
      });
  
      // Close dropdown if clicked outside
      document.addEventListener('click', function(e) {
        if (!selectBox.contains(e.target)) {
          optionsContainer.style.display = 'none';
        }
      });
    });
  });
  

  /*sale page */

  document.querySelectorAll(".wishlist-btn").forEach((heart) => {
    heart.addEventListener("click", function () {
        this.classList.toggle("bi-heart");
        this.classList.toggle("bi-heart-fill");
        this.style.color = this.classList.contains("bi-heart-fill") ? "black" : "black";
    });
});



/* profile*/

document.addEventListener("DOMContentLoaded", function () {
    const review = document.getElementById("review");
    const fullText = review.getAttribute("data-fulltext").trim();
    const maxLength = window.innerWidth < 768 ? 40 : 50; // Adjusted for mobile
    let isExpanded = false;

    function updateText() {
        if (!isExpanded) {
            review.innerHTML = fullText.substring(0, maxLength) + 
                '<span class="dots">... <i class="bi bi-three-dots"></i></span>';
            review.style.maxHeight = "50px";
            review.style.overflow = "hidden";
        } else {
            review.innerHTML = fullText + 
                '<span class="dots"> <i class="bi bi-chevron-up"></i></span>';
            review.style.maxHeight = "150px";
            review.style.overflowY = "auto";
        }
    }

    // Initialize text
    updateText();

    // Add click event to toggle review
    review.addEventListener("click", function () {
        isExpanded = !isExpanded;
        updateText();
    });

    // Adjust max length on window resize
    window.addEventListener("resize", function () {
        isExpanded = false;
        updateText();
    });
});


/*  FAQ */

function toggleFaq(faqBox) {
    let answer = faqBox.nextElementSibling;
    let icon = faqBox.querySelector(".faq-icon");

    // Close all other FAQs
    document.querySelectorAll(".faq-answer").forEach(ans => {
      if (ans !== answer) {
        ans.classList.remove("active");
        ans.previousElementSibling.querySelector(".faq-icon").classList.remove("bi-dash");
        ans.previousElementSibling.querySelector(".faq-icon").classList.add("bi-plus");
      }
    });

    // Toggle current FAQ
    if (answer.classList.contains("active")) {
      answer.classList.remove("active");
      icon.classList.remove("bi-dash");
      icon.classList.add("bi-plus");
    } else {
      answer.classList.add("active");
      icon.classList.remove("bi-plus");
      icon.classList.add("bi-dash");
    }
  }



// mobile search bar

document.getElementById("mobileSearchIcon").addEventListener("click", function () {
    document.getElementById("mobileSearchBar").classList.toggle("active");
});

document.getElementById("closeMenu").addEventListener("click", function () {
    document.getElementById("mobileMenu").classList.remove("active");
    document.getElementById("mobileSearchBar").classList.remove("active");
});






// Function to open the search bar
function openSearch(searchId) {
    document.getElementById(searchId).style.display = "block";
}

// Function to close the search bar
function closeSearch(searchId) {
    document.getElementById(searchId).style.display = "none";
}

// Close search bar when clicking outside it
document.addEventListener("click", function (event) {
    let searchPopups = document.querySelectorAll(".search-popup");
    searchPopups.forEach(popup => {
        if (!popup.contains(event.target) && !event.target.closest(".bi-search")) {
            popup.style.display = "none";
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector(".search-input");
    const searchBox = document.querySelector(".search-box");

    searchInput.addEventListener("input", function () {
        if (this.value.length > 0) {
            searchBox.style.setProperty("--search-icon-opacity", "0");
        } else {
            searchBox.style.setProperty("--search-icon-opacity", "1");
        }
    });
});


// Signup Form
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


  /* about page */

  document.addEventListener("DOMContentLoaded", function() {
    console.log("Page loaded successfully");

    const buttons = document.querySelectorAll(".btn");
    buttons.forEach(button => {
        button.addEventListener("click", function() {
            alert("Button clicked: " + this.textContent);
        });
    });
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


        
        document.addEventListener("DOMContentLoaded", function () {
            const wishlistButtons = document.querySelectorAll(".wishlist-btn");
            
            wishlistButtons.forEach(button => {
                button.addEventListener("click", function () {
                    this.classList.toggle("active");
                    
                    // Toggle heart icon between outlined and filled
                    if (this.classList.contains("active")) {
                        this.classList.replace("bi-heart", "bi-heart-fill");
                    } else {
                        this.classList.replace("bi-heart-fill", "bi-heart");
                    }
                });
            });
        });
 

        
// About us popular slider
        
document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector(".brand-track");
    const clone = slider.innerHTML; // Clone all items
    slider.innerHTML += clone; // Duplicate the items to create an endless loop
});


// wishlist heart fill
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".wishlist-btn-m").forEach((button) => {
        button.addEventListener("click", function () {
            this.classList.toggle("active");

            if (this.classList.contains("active")) {
                this.classList.replace("bi-heart", "bi-heart-fill");
            } else {
                this.classList.replace("bi-heart-fill", "bi-heart");
            }
        });
    });
});

