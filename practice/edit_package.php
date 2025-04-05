<?php
include 'admin_config.php'; // Database connection

// Check if ID is set
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid package ID.");
}

$id = $_GET['id'];

// Fetch the package details
$result = mysqli_query($conn, "SELECT * FROM packages WHERE id='$id'");
if (mysqli_num_rows($result) == 0) {
    die("Package not found.");
}
$package = mysqli_fetch_assoc($result);

// Handle the update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Ensure price is numeric
    if (!is_numeric($price) || $price < 0) {
        die("Invalid price. Please enter a valid number.");
    }

    // Check if a new image is uploaded
    if ($_FILES['image']['name']) {
        $imagePath = 'images/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        $updateQuery = "UPDATE packages SET image='$imagePath', title='$title', description='$description', price='$price' WHERE id='$id'";
    } else {
        $updateQuery = "UPDATE packages SET title='$title', description='$description', price='$price' WHERE id='$id'";
    }

    mysqli_query($conn, $updateQuery);
    header("Location: manage_packages.php"); // Redirect after update
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Your existing CSS -->
    <style>
        .container {
            max-width: 500px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--box-shadow);
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: var(--main-color);
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: var(--black);
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Package</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Current Image:</label><br>
        <img src="<?= $package['image'] ?>" width="100%" height="200px"><br><br>
        <input type="file" name="image">
        
        <label>Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($package['title']) ?>" required>
        
        <label>Description:</label>
        <textarea name="description" required><?= htmlspecialchars($package['description']) ?></textarea>

        <label>Price (₹):</label>
        <input type="number" name="price" value="<?= htmlspecialchars($package['price']) ?>" step="0.01" required>

        <button type="submit">Update Package</button>
    </form>
</div>

</body>
</html>
