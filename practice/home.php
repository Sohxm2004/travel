<?php
// Add these at the very top of home.php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <!-- swiper css link  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

     <!-- font awsome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- custom css file  -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Price styling only for packages section */
        .home-packages .box .price {
            color: #007bff;
            font-weight: bold;
            font-size: 2rem;
            margin: 1rem 0;
            display: block;
        }

        /* Responsive adjustment for price */
        @media (max-width: 768px) {
            .home-packages .box .price {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
  
<!-- header section starts  -->
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
<!-- header section ends  -->

<!-- home section starts  -->
<section class="home">
    <div class="swiper home-slider">
        <div class="swiper-wrapper">
            <div class="swiper-slide slide" style="background: url(images/balloon.jpg) no-repeat">
                <div class="content">
                    <span>explore, discover, travel</span>
                    <h3>travel around the world</h3>
                    <a href="package.php" class="btn">discover more</a>
                </div>
            </div>

            <div class="swiper-slide slide" style="background: url(images/hotel.jpg) no-repeat">
                <div class="content">
                    <span>explore, discover, travel</span>
                    <h3>discover new places</h3>
                    <a href="package.php" class="btn">discover more</a>
                </div>
            </div>

            <div class="swiper-slide slide" style="background: url(images/friends.jpg) no-repeat">
                <div class="content">
                    <span>explore, discover, travel</span>
                    <h3>make your tour worthwhile</h3>
                    <a href="package.php" class="btn">discover more</a>
                </div>
            </div>
        </div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>
<!-- home section ends  -->

<!-- services section starts  -->
<section class="services">
    <h1 class="heading-title"> Our Services </h1>
    <div class="box-container">
        <div class="box">
            <img src="images/icon-1.png" alt="">
            <h3>adventure</h3>
        </div>
        <div class="box">
            <img src="images/icon-2.png" alt="">
            <h3>tour guide</h3>
        </div>
        <div class="box">
            <img src="images/icon-3.png" alt="">
            <h3>trekking</h3>
        </div>
        <div class="box">
            <img src="images/icon-4.png" alt="">
            <h3>camp fire</h3>
        </div>
        <div class="box">
            <img src="images/icon-4.png" alt="">
            <h3>off road</h3>
        </div>
        <div class="box">
            <img src="images/icon-4.png" alt="">
            <h3>camping</h3>
        </div>
    </div>
</section>
<!-- services section ends  -->

<!-- home about section starts  -->
<section class="home-about">
    <div class="image">
        <img src="images/about-img.jpg" alt="">
    </div>
    <div class="content">
        <h3>about us</h3>
        <p>Explore The World With Ease! Discover Breathtaking Destinations, Plan Unforgettable Adventures, And Find The Best Travel Tips. Let Us Guide You To Your Next Journey With Expert Insights And Top Recommendations.</p>
        <a href="about.php" class="btn">read more</a>
    </div>
</section>
<!-- home about section ends  -->

<!-- home section package starts  -->
<section class="home-packages">
    <h1 class="heading-title">Our Packages</h1>
    <div class="box-container">
        <?php
        include 'admin_config.php';
        $result = mysqli_query($conn, "SELECT * FROM packages ORDER BY id ASC LIMIT 3");
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
    <div class="load-more">
        <a href="package.php" class="btn">Load More</a>
    </div>
</section>
<!-- home packages section ends  -->

<!-- home offer section starts  -->
<section class="home-offer">
    <div class="content">
        <h3>upto 50% off</h3>
        <p>Get up to 50% off on unforgettable trips! Discover breathtaking destinations, enjoy exclusive deals, and make your dream vacation a reality today!</p>
        <a href="book.php" class="btn">book now</a>
    </div>
</section>
<!-- home offer section ends  -->

<!-- footer section starts  -->
<section class="footer">
    <div class="box-container">
        <div class="box">
            <h3>quick links</h3>
            <a href="home.php"> <i class="fas fa-angle-right"></i> Home</a>
            <a href="about.php"> <i class="fas fa-angle-right"></i> About</a>
            <a href="package.php"> <i class="fas fa-angle-right"></i> packages</a>
            <a href="book.php"> <i class="fas fa-angle-right"></i> Book</a>
        </div>
        <div class="box">
            <h3>extra links</h3>
            <a href="#"> <i class="fas fa-angle-right"></i> ask questions</a>
            <a href="#"> <i class="fas fa-angle-right"></i> about us</a>
            <a href="#"> <i class="fas fa-angle-right"></i> privacy policy</a>
            <a href="#"> <i class="fas fa-angle-right"></i> terms of use</a>
        </div>
        <div class="box">
            <h3>contact info</h3>
            <a href="#"> <i class="fas fa-phone"></i> 9321678287</a>
            <a href="#"> <i class="fas fa-phone"></i> 9869811007</a>
            <a href="#"> <i class="fas fa-envelope"></i> sohamshetge@gmail.com</a>
            <a href="#"> <i class="fas fa-map"></i> mumbai, india - 400051</a>  
        </div>
        <div class="box">
            <h3>follow us</h3>
            <a href="#"> <i class="fab fa-facebook-f"></i> facebook </a>
            <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
            <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
            <a href="#"> <i class="fab fa-linkedin"></i> linkedin </a>
        </div>
    </div>
    <div class="credit"> created by <span>Soham Shetge</span> | all right resered! </div>
</section>
<!-- footer section ends  -->

<!-- swiper js link  -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- custom js file  -->
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

<script>
// Prevent page from being cached
window.onpageshow = function(event) {
    if (event.persisted) {
        window.location.reload();
    }
};
</script>

</body>
</html>