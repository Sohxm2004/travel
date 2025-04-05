<?php
// Start session at the very beginning of the file
session_start();

// Add cache control headers to prevent caching issues
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
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

<div class="heading" style="background:url(images/header-bg-1.png) no-repeat">
    <h1>about us</h1>
</div>

<!-- about section starts  -->

    <section class="about">
        <div class="image">
            <img src="images/about-img.jpg" alt="">
        </div>

        <div class="content">
            <h3>why choose us?</h3>
            <p>Explore the world with ease! Discover breathtaking destinations, plan unforgettable adventures, and find the best travel tips. Let us guide you to your next journey with expert insights and top recommendations.</p>
            
            <p>Discover Stunning Destinations, Plan Your Trips, Explore Cultures, Enjoy Unique Experiences, Find Best Deals, Travel Smarter, Create Unforgettable Memories.</p>
            
            <div class="icons-container">
                <div class="icons">
                    <i class="fas fa-map"></i>
                    <span>top destinations</span>
                </div>
                <div class="icons">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>affordable prices</span>
                </div>
                <div class="icons">
                    <i class="fas fa-headset"></i>
                    <span>24/7 guide service</span>
                </div>

            </div>

        </div>

    </section>

<!-- about section ends  -->

<!-- reviews section starts  -->

<section class="reviews">

    <h1 class="heading-title"> client reviews </h1>

    <div class="swiper reviews-slider">

    <div class="swiper-wrapper">

    <div class="swiper-slide slide">
        <div class="stars">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
    </div>
    <p>Amazing travel website with helpful guides, stunning destinations, and great deals! Easy booking, excellent recommendations, and top-notch service make every trip unforgettable. Highly recommended for travelers!</p>
    <h3>Soham Shetge</h3>
    <span>traveler</span>
    <img src="images/pic-1.png" alt="">
    </div>

    <div class="swiper-slide slide">
        <div class="stars">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
    </div>
    <p>An incredible travel website offering breathtaking destinations, expert tips, and unbeatable deals. Seamless booking, personalized recommendations, and top-notch service ensure unforgettable adventures. Highly recommended for all travelers seeking hassle-free and memorable trips!</p>

    <h3>May</h3>
    <span>traveler</span>
    <img src="images/pic-2.png" alt="">
    </div>

    <div class="swiper-slide slide">
        <div class="stars">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        
    </div>
    <p>Amazing travel site with great deals, expert tips, and stunning destinations. Easy booking, excellent service, and unforgettable experiences make every trip special!</p>
    <h3>Ash Ketchum</h3>
    <span>traveler</span>
    <img src="images/pic-3.png" alt="">
    </div>

    <div class="swiper-slide slide">
        <div class="stars">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
    </div>
    <p>Incredible travel deals, stunning places, and expert tips for perfect trips!</p>

    <h3>Sarena</h3>
    <span>traveler</span>
    <img src="images/pic-4.png" alt="">
    </div>

    <div class="swiper-slide slide">
        <div class="stars">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
    </div>
    <p>This travel website is fantastic! It offers amazing destinations, expert tips, and great deals. The booking process is smooth, and the service is excellent. Highly recommended!</p>

    <h3>Adyame Williams</h3>
    <span>traveler</span>
    <img src="images/pic-5.png" alt="">
    </div>

    <div class="swiper-slide slide">
        <div class="stars">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
    </div>
    <p>Amazing travel site with great tips, stunning destinations, and easy booking!</p>
    
    <h3>Alisa Kujou</h3>
    <span>traveler</span>
    <img src="images/pic-6.png" alt="">
    </div>

    </div>
    

    </div>
    
</section>

<!-- reviews sections ends  -->


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
      // Reviews slider
  if (document.querySelector('.reviews-slider')) {
      var reviewsSwiper = new Swiper(".reviews-slider", {
          grabCursor: true,
          loop: true,
          autoHeight: true,
          spaceBetween: 20,
          breakpoints: {
              0: {
                  slidesPerView: 1,
              },
              700: {
                  slidesPerView: 2,
              },
              1000: {
                  slidesPerView: 3,
              },
          },
      });
  }
</script>

</body>
</html>