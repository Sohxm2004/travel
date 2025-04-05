<?php
session_start();

// Database connection
$connection = mysqli_connect('localhost','root','','book_db');
if(!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Initialize variables
$error = '';
$success = '';
$booking = [];

// Get booking ID from URL
$booking_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch booking details
if($booking_id > 0) {
    $query = "SELECT * FROM book_form WHERE id = $booking_id";
    $result = mysqli_query($connection, $query);
    
    if(!$result) {
        die("Query failed: " . mysqli_error($connection));
    }
    
    if(mysqli_num_rows($result) > 0) {
        $booking = mysqli_fetch_assoc($result);
    } else {
        $error = "Booking not found!";
    }
} else {
    $error = "Invalid booking ID!";
}

// Handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    // Sanitize input data
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $location = mysqli_real_escape_string($connection, $_POST['location']);
    $guests = intval($_POST['guests']);
    $arrivals = mysqli_real_escape_string($connection, $_POST['arrivals']);
    $leavings = mysqli_real_escape_string($connection, $_POST['leavings']);
    $status = mysqli_real_escape_string($connection, $_POST['status']);

    // Validate dates
    if(strtotime($leavings) < strtotime($arrivals)) {
        $error = "Departure date cannot be before arrival date!";
    } else {
        // Update query
        $query = "UPDATE book_form SET 
                  name = '$name',
                  email = '$email',
                  phone = '$phone',
                  address = '$address',
                  location = '$location',
                  guests = '$guests',
                  arrivals = '$arrivals',
                  leavings = '$leavings',
                  status = '$status'
                  WHERE id = $id";

        if(mysqli_query($connection, $query)) {
            $_SESSION['success_message'] = "Booking #$id updated successfully!";
            header("Location: manage_bookings.php");
            exit;
        } else {
            $error = "Error updating booking: " . mysqli_error($connection);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .edit-booking-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--light-bg);
            border-radius: 0.5rem;
            box-shadow: var(--box-shadow);
        }
        
        .error-message {
            color: #d32f2f;
            background: #ffebee;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #d32f2f;
        }
        
        .edit-form .input-group {
            margin-bottom: 1.5rem;
        }
        
        .edit-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--black);
        }
        
        .edit-form input,
        .edit-form select {
            width: 100%;
            padding: 1rem;
            border: var(--border);
            border-radius: 0.5rem;
            font-size: 1.4rem;
        }
        
        .edit-form .flex-row {
            display: flex;
            gap: 1.5rem;
        }
        
        .edit-form .flex-row .input-group {
            flex: 1;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .btn {
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 1.4rem;
            transition: all 0.3s ease;
        }
        
        .btn-save {
            background: var(--main-color);
            color: white;
            border: none;
        }
        
        .btn-save:hover {
            background: #7b1fa2;
        }
        
        .btn-cancel {
            background: #757575;
            color: white;
            border: none;
        }
        
        .btn-cancel:hover {
            background: #616161;
        }
        
        @media (max-width: 768px) {
            .edit-booking-container {
                padding: 1rem;
                margin: 1rem;
            }
            
            .edit-form .flex-row {
                flex-direction: column;
                gap: 0;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
  
<section class="header">
    <a href="manage_bookings.php" class="logo">Edit Booking</a>
    <nav class="navbar">
        <a href="manage_bookings.php"><i class="fas fa-arrow-left"></i> Back</a>
    </nav>
    <div id="menu-btn" class="fas fa-bars"></div>
</section>

<div class="edit-booking-container">
    <h2 style="margin-bottom: 2rem; color: var(--black);">Edit Booking #<?php echo $booking_id; ?></h2>
    
    <?php if(!empty($error)): ?>
        <div class="error-message">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <?php if(empty($booking) && empty($error)): ?>
        <div class="error-message">
            <i class="fas fa-exclamation-circle"></i> No booking data found.
        </div>
    <?php else: ?>
        <form class="edit-form" method="POST">
            <input type="hidden" name="id" value="<?php echo $booking_id; ?>">
            
            <div class="flex-row">
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required 
                           value="<?php echo htmlspecialchars($booking['name'] ?? ''); ?>">
                </div>
                
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required
                           value="<?php echo htmlspecialchars($booking['email'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="flex-row">
                <div class="input-group">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" required
                           value="<?php echo htmlspecialchars($booking['phone'] ?? ''); ?>">
                </div>
                
                <div class="input-group">
                    <label for="guests">Guests</label>
                    <input type="number" id="guests" name="guests" min="1" required
                           value="<?php echo htmlspecialchars($booking['guests'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="input-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required
                       value="<?php echo htmlspecialchars($booking['address'] ?? ''); ?>">
            </div>
            
            <div class="input-group">
                <label for="location">Destination</label>
                <input type="text" id="location" name="location" required
                       value="<?php echo htmlspecialchars($booking['location'] ?? ''); ?>">
            </div>
            
            <div class="flex-row">
                <div class="input-group">
                    <label for="arrivals">Arrival Date</label>
                    <input type="date" id="arrivals" name="arrivals" required
                           value="<?php echo htmlspecialchars($booking['arrivals'] ?? ''); ?>">
                </div>
                
                <div class="input-group">
                    <label for="leavings">Departure Date</label>
                    <input type="date" id="leavings" name="leavings" required
                           value="<?php echo htmlspecialchars($booking['leavings'] ?? ''); ?>">
                </div>
                
                <div class="input-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="confirmed" <?php echo ($booking['status'] ?? '') == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                        <option value="pending" <?php echo ($booking['status'] ?? '') == 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="cancelled" <?php echo ($booking['status'] ?? '') == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>
            </div>
            
            <div class="form-actions">
                <a href="manage_bookings.php" class="btn btn-cancel">Cancel</a>
                <button type="submit" class="btn btn-save">Save Changes</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<script>
    // Mobile menu toggle
    document.getElementById('menu-btn').onclick = () => {
        document.querySelector('.header .navbar').classList.toggle('active');
    }
    
    // Date validation
    const arrivalsInput = document.getElementById('arrivals');
    const leavingsInput = document.getElementById('leavings');
    
    if(arrivalsInput && leavingsInput) {
        arrivalsInput.addEventListener('change', validateDates);
        leavingsInput.addEventListener('change', validateDates);
        
        function validateDates() {
            const arrivalDate = new Date(arrivalsInput.value);
            const leavingDate = new Date(leavingsInput.value);
            
            if(leavingDate < arrivalDate) {
                alert('Departure date cannot be before arrival date');
                leavingsInput.value = arrivalsInput.value;
            }
        }
    }
</script>

</body>
</html>