<?php
// Start session at the very beginning
session_start();

// Include database connection
include 'admin_config.php';

// Add cache control headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packages</title>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        /* Add custom style for price */
        .packages .box .price {
            color: #007bff !important;  
            font-weight: bold !important;
            font-size: 2rem !important;
            margin: 1rem 0 !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .packages .box .price {
                font-size: 1.5rem !important;
            }
        }
    </style>
</head>
<body>

<!-- Header Section -->
<section class="header">
    <a href="home.php" class="logo">Travel.</a>
    <nav class="navbar">
    <a href="home.php">Home</a>
    <a href="about.php">About</a>
    <a href="package.php">packages</a>
    <a href="book.php">Book</a>
    <?php
    if (isset($_SESSION['email'])) {
        $role = ucfirst($_SESSION['role']);
        $name = htmlspecialchars($_SESSION['name']);
        $dashboard_link = ($_SESSION['role'] === 'admin') ? 'login_register/admin_page.php' : 'login_register/user_page.php';
        echo '<a href="'.$dashboard_link.'?t='.time().'" class="user-display"><span class="role-label">'.$role.':</span> '.$name.'</a>';
        echo '<a href="login_register/logout.php?t='.time().'" class="logout-btn">Logout</a>';
    } else {
        echo '<a href="login_register/index.php?t='.time().'" class="signup-btn">Sign up</a>';
    }
    ?>
</nav>
    <div id="menu-btn" class="fas fa-bars"></div>
</section>




<!-- Hero Section -->
<div class="heading" style="background:url(images/header-bg-2.png) no-repeat">
    <h1>Packages</h1>
</div>


<!-- Search Section -->
<section class="search-packages">
    <div class="search-container">
        <input type="text" id="package-search" placeholder="Search destinations..." autocomplete="off">
        <button type="submit"><i class="fas fa-search"></i></button>
    </div>
</section>

<!-- Packages Section -->
<section class="packages">
    <h1 class="heading-title">Top Destinations</h1>
    <div class="box-container">

    <?php
    $result = mysqli_query($conn, "SELECT * FROM packages");
    while ($row = mysqli_fetch_assoc($result)) {
        $price = is_numeric($row['price']) ? number_format((float)$row['price'], 2) : 'N/A';
        echo "<div class='box'>
                <div class='image'>
                    <img src='" . htmlspecialchars($row['image']) . "' alt='Package Image'>
                </div>
                <div class='content'>
                    <h3>" . htmlspecialchars($row['title']) . "</h3>
                    <p>" . htmlspecialchars($row['description']) . "</p>
                    <div class='price'>₹" . $price . "</div>
                    <a href='book.php' class='btn'>Book Now</a>
                </div>
              </div>";
    }
    ?>

    </div>
    <!-- <div class="load-more"><span class="btn">Load More</span></div> -->
</section>

<!-- Footer Section -->
<section class="footer">
    <div class="box-container">
        <div class="box">
            <h3>Quick Links</h3>
            <a href="home.php"><i class="fas fa-angle-right"></i> Home</a>
            <a href="about.php"><i class="fas fa-angle-right"></i> About</a>
            <a href="package.php"><i class="fas fa-angle-right"></i> Packages</a>
            <a href="book.php"><i class="fas fa-angle-right"></i> Book</a>
        </div>

        <div class="box">
            <h3>Extra Links</h3>
            <a href="#"><i class="fas fa-angle-right"></i> Ask Questions</a>
            <a href="#"><i class="fas fa-angle-right"></i> About Us</a>
            <a href="#"><i class="fas fa-angle-right"></i> Privacy Policy</a>
            <a href="#"><i class="fas fa-angle-right"></i> Terms of Use</a>
        </div>

        <div class="box">
            <h3>Contact Info</h3>
            <a href="#"><i class="fas fa-phone"></i> 9321678287</a>
            <a href="#"><i class="fas fa-phone"></i> 9869811007</a>
            <a href="#"><i class="fas fa-envelope"></i> sohamshetge@gmail.com</a>
            <a href="#"><i class="fas fa-map"></i> Mumbai, India - 400051</a>
        </div>

        <div class="box">
            <h3>Follow Us</h3>
            <a href="#"><i class="fab fa-facebook-f"></i> Facebook</a>
            <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
            <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
            <a href="#"><i class="fab fa-linkedin"></i> LinkedIn</a>
        </div>
    </div>
    <div class="credit">Created by <span>Soham Shetge</span> | All rights reserved!</div>
</section>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Custom JS -->
<script src="js/script.js" defer></script>

<!-- Chatbot HTML -->
<div id="chatbot-icon">💬</div>
<div id="chatbot-container" class="hidden">
  <div id="chatbot-header">
    <span>Travel Assistant</span>
    <button id="close-btn">&times;</button>
  </div>
  <div id="chatbot-body">
    <div id="chatbot-messages"></div>
  </div>
  <div id="chatbot-input-container">
    <input type="text" id="chatbot-input" placeholder="Ask about travel...">
    <button id="send-btn">Send</button>
  </div>
</div>




<!-- Modal HTML -->
<div id="package-modal" class="modal">
  <div class="modal-content">
    <span class="close-modal">&times;</span>
    <div class="modal-body">
      <div class="modal-image-container">
        <img id="modal-package-image" src="" alt="Package Image">
      </div>
      <h2 id="modal-package-title"></h2>
      <p id="modal-package-description"></p>
      <div id="modal-package-price" class="price"></div>
      <div class="modal-actions">
        <a href="book.php" class="btn modal-book-btn">Book Now</a>
      </div>
    </div>
  </div>
</div>


<script>


document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('package-search');
    const searchButton = document.querySelector('.search-packages button');
    const boxContainer = document.querySelector('.packages .box-container');
    let allPackages = Array.from(document.querySelectorAll('.packages .box-container .box'));
    let noResultsMessage = null;

    // Initialize display
    function initializeDisplay() {
        allPackages.forEach(box => {
            box.style.display = 'inline-block';
        });
        removeNoResultsMessage();
    }

    // Remove no results message
    function removeNoResultsMessage() {
        if (noResultsMessage && boxContainer.contains(noResultsMessage)) {
            boxContainer.removeChild(noResultsMessage);
            noResultsMessage = null;
        }
    }

    // Show no results message
    function showNoResultsMessage() {
        noResultsMessage = document.createElement('p');
        noResultsMessage.textContent = 'No packages found matching your search.';
        noResultsMessage.className = 'no-results-message';
        boxContainer.appendChild(noResultsMessage);
    }

    // Search functionality
    function performSearch() {
        const searchTerm = searchInput.value.trim().toLowerCase();
        removeNoResultsMessage();

        if (searchTerm === '') {
            initializeDisplay();
            return;
        }

        let foundMatches = false;
        allPackages.forEach(box => {
            const title = box.querySelector('h3').textContent.toLowerCase();
            const description = box.querySelector('p').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                box.style.display = 'inline-block';
                foundMatches = true;
            } else {
                box.style.display = 'none';
            }
        });

        if (!foundMatches) {
            showNoResultsMessage();
        }
    }

    // Modal functionality
    const modal = document.getElementById('package-modal');
    const modalImage = document.getElementById('modal-package-image');
    const modalTitle = document.getElementById('modal-package-title');
    const modalDescription = document.getElementById('modal-package-description');
    const modalPrice = document.getElementById('modal-package-price');
    const closeBtn = document.querySelector('.close-modal');

    // Make all package boxes clickable
    allPackages.forEach(box => {
        box.style.cursor = 'pointer';
        box.addEventListener('click', function() {
            // Get package details
            const image = this.querySelector('.image img').src;
            const title = this.querySelector('h3').textContent;
            const description = this.querySelector('p').textContent;
            const price = this.querySelector('.price').textContent;
            
            // Populate modal
            modalImage.src = image;
            modalImage.alt = title;
            modalTitle.textContent = title;
            modalDescription.textContent = description;
            modalPrice.textContent = price;
            
            // Show modal
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
    });

    // Close modal
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    });

    // Close when clicking outside modal
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });

    // Search event listeners
    searchInput.addEventListener('input', performSearch);
    searchButton.addEventListener('click', function() {
        performSearch();
        searchInput.focus();
    });
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });

    // Initialize on page load
    initializeDisplay();
});



</script>

</body>
</html>