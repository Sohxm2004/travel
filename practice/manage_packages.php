<?php
include 'admin_config.php'; // Database connection

// Create the table if it doesn't exist (including price column)
$query = "CREATE TABLE IF NOT EXISTS packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00
)";
mysqli_query($conn, $query);

// Handle form submission (Adding New Package)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0.00;

    // Handle Image Upload
    $imagePath = 'images/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

    // Insert into database
    $insertQuery = "INSERT INTO packages (image, title, description, price) VALUES ('$imagePath', '$title', '$description', '$price')";
    mysqli_query($conn, $insertQuery);
}

// Handle Delete Request
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM packages WHERE id='$delete_id'");
    header("Location: manage_packages.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Packages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Header styles to match your booking page */
        .header {
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background-color: var(--white);
            display: flex;
            padding-top: 2rem;
            padding-bottom: 2rem;
            box-shadow: var(--box-shadow);
            align-items: center;
            justify-content: space-between;
        }
        
        .header .logo {
            font-size: 2.5rem;
            color: var(--black);
        }
        
        .header .navbar a {
            font-size: 2rem;
            margin-left: 2rem;
            color: var(--black);
        }
        
        .header .navbar a:hover {
            color: var(--main-color);
        }
        
        #menu-btn {
            font-size: 2.5rem;
            cursor: pointer;
            color: var(--black);
            display: none;
        }
        
        /* Rest of your existing styles */
        .page-title {
            text-align: center;
            font-size: 3rem;  
            font-weight: bold;
            color: #333;
            margin: 2rem auto 1rem auto;
            padding: 0.5rem;
            display: block;
        }
        
        .packages-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
        }
        
        .box {
            border: 1px solid #ddd;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
        }
        
        .box:hover {
            transform: scale(1.05);
        }
        
        .box .image img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .content {
            padding: 1rem;
            text-align: center;
        }
        
        .content h3 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        
        .content p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        
        .content .price {
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
            margin: 1rem 0;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin: 8px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.2rem;
            transition: 0.3s;
        }
        
        .btn:hover {
            background: #218838;
        }
        
        .delete-btn {
            background: #dc3545;
        }
        
        .delete-btn:hover {
            background: #c82333;
        }
        
        form {
            max-width: 500px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            font-size: 1.2rem;
        }
        
        button:hover {
            background-color: #218838;
        }
        
        /* Mobile responsive styles */
        @media (max-width: 768px) {
            #menu-btn {
                display: inline-block;
            }
            
            .header .navbar {
                position: absolute;
                top: 99%;
                left: 0;
                right: 0;
                background-color: var(--white);
                border-top: var(--border);
                padding: 2rem;
                clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
                transition: .2s linear;
            }
            
            .header .navbar.active {
                clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
            }
            
            .header .navbar a {
                display: block;
                margin: 1.5rem;
                text-align: center;
            }
            
            .packages-container {
                grid-template-columns: 1fr;
                padding: 1rem;
            }
            
            .content h3 {
                font-size: 1.5rem;
            }
            
            .content p {
                font-size: 1rem;
            }
            
            .content .price {
                font-size: 1.5rem;
            }
            
            .btn {
                font-size: 1rem;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>

<!-- New header section matching your booking page -->
<section class="header">
    <a href="login_register/admin_page.php" class="logo">Packages</a>
    <nav class="navbar">
        <a href="login_register/admin_page.php"><i class="fas fa-arrow-left"></i> Back </a>
    </nav>
    <div id="menu-btn" class="fas fa-bars"></div>
</section>

<h2 class="page-title">Add New Package</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="image" required>
    <input type="text" name="title" placeholder="Package Title" required>
    <textarea name="description" placeholder="Package Description" required></textarea>
    <input type="number" name="price" placeholder="Package Price (INR)" step="0.01" required>
    <button type="submit">Add Package</button>
</form>

<h2 class="page-title">Existing Packages</h2>
<div class="packages-container">
    <?php
    $result = mysqli_query($conn, "SELECT * FROM packages");
    while ($row = mysqli_fetch_assoc($result)) {
        $price = isset($row['price']) ? floatval($row['price']) : 0.00;
        echo "<div class='box'>
                <div class='image'>
                    <img src='" . htmlspecialchars($row['image']) . "' alt='Package Image'>
                </div>
                <div class='content'>
                    <h3>" . htmlspecialchars($row['title']) . "</h3>
                    <p>" . htmlspecialchars($row['description']) . "</p>
                    <div class='price'>₹" . number_format($price, 2) . "</div>
                    <a href='edit_package.php?id=" . $row['id'] . "' class='btn'>Edit</a>
                    <a href='manage_packages.php?delete=" . $row['id'] . "' class='btn delete-btn' onclick='return confirm(\"Are you sure you want to delete this package?\")'>Delete</a>
                </div>
              </div>";
    }
    ?>
</div>

<script>
    // Mobile menu toggle
    document.getElementById('menu-btn').onclick = () => {
        document.querySelector('.header .navbar').classList.toggle('active');
    }
</script>

</body>
</html>