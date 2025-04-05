<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packages</title>


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

<div class="heading" style="background:url(images/header-bg-3.png) no-repeat">
    <h1>book</h1>
</div>

<!-- booking section starts  -->

<section class="booking">
    <h1 class="heading-title">book your trip!</h1>

    <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
      <div class="success-message" style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['success_message']; ?></div>
      <?php
      unset($_SESSION['success_message']);
   }
   ?>

    <form action="book_form.php" method="post" class="book-form">

    <div class="flex">
        <div class="inputBox">
            <span>name :</span>
            <input type="text" placeholder="enter your name" name="name">
             </div>

             <div class="inputBox">
            <span>email :</span>
            <input type="email" placeholder="enter your email" name="email">
             </div>

             <div class="inputBox">
            <span>phone :</span>
            <input type="number" placeholder="enter your number" name="phone">
             </div>

             <div class="inputBox">
            <span>address :</span>
            <input type="text" placeholder="enter your address" name="address">
             </div>

             <div class="inputBox">
            <span>where to :</span>
            <input type="text" placeholder="place you want to visit" name="location">
             </div>

             <div class="inputBox">
            <span>how many :</span>
            <input type="number" placeholder="number of guests" name="guests">
             </div>

             <div class="inputBox">
            <span>arrivals :</span>
            <input type="date" name="arrivals">
             </div>

             <div class="inputBox">
            <span>leavings :</span>
            <input type="date" name="leavings">
             </div>

             
        </div>

        <input type="submit" value="submit" class="btn" name="send">

    </form>

</section>

<!-- booking sections ends  -->


































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

<script src="js/script.js"></script>

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



</body>
</html>