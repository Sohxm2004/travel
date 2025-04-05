<?php
session_start();


$connection = mysqli_connect('localhost','root','','book_db');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .bookings-container {
            padding: 2rem;
            overflow-x: auto;
        }
        
        .bookings-table {
            width: 100%;
            min-width: 600px;
            border-collapse: collapse;
            background: var(--white);
            box-shadow: var(--box-shadow);
            font-size: 1.4rem;
        }
        
        .bookings-table th, 
        .bookings-table td {
            padding: 1.2rem;
            text-align: left;
            border-bottom: 1px solid var(--light-bg);
        }
        
        .bookings-table th {
            background-color: var(--main-color);
            color: var(--white);
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        
        .bookings-table tr:nth-child(even) {
            background-color: var(--light-bg);
        }
        
        .bookings-table tr:hover {
            background-color: rgba(142, 68, 173, 0.1);
        }
        
        .status {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 2rem;
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .status-confirmed {
            background-color: #e6f7e6;
            color: #2e7d32;
        }
        
        .status-pending {
            background-color: #fff8e1;
            color: #ff8f00;
        }
        
        .status-cancelled {
            background-color: #ffebee;
            color: #c62828;
        }
        
        .date-cell {
            white-space: nowrap;
        }
        
        /* Mobile-specific styles */
        @media (max-width: 768px) {
            .bookings-container {
                padding: 1rem;
            }
            
            .bookings-table {
                font-size: 1.2rem;
            }
            
            .bookings-table th, 
            .bookings-table td {
                padding: 0.8rem;
            }
            
            .status {
                padding: 0.2rem 0.6rem;
                font-size: 1rem;
            }
        }
        
        /* Very small devices */
        @media (max-width: 480px) {
            .bookings-table {
                font-size: 1rem;
            }
            
            .bookings-table th, 
            .bookings-table td {
                padding: 0.6rem;
            }
        }

        .action-btn {
            padding: 0.5rem 1rem;
            background: var(--main-color);
            color: white;
            border-radius: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.2rem;
        }
        
        .action-btn:hover {
            background: var(--black);
        }
        
        @media (max-width: 768px) {
            .action-btn {
                padding: 0.4rem 0.8rem;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
  
<section class="header">
    <a href="admin_panel.php" class="logo">Bookings</a>
    <nav class="navbar">
        <a href="login_register/admin_page.php"><i class="fas fa-arrow-left"></i> Back</a>
    </nav>
    <div id="menu-btn" class="fas fa-bars"></div>
</section>

<div class="bookings-container">
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="success-message" style="margin-bottom: 1rem; padding: 1rem; background: #e6f7e6; color: #2e7d32; border-radius: 0.5rem;">
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    
    <?php
    $query = "SELECT * FROM book_form ORDER BY arrivals DESC";
    $result = mysqli_query($connection, $query);
    ?>
    
    <table class="bookings-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Destination</th>
                <th class="date-cell">Dates</th>
                <th>Guests</th>
                <th>Status</th>

                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($booking = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $booking['id']; ?></td>
                        <td>
                            <div style="font-weight: 600;"><?php echo htmlspecialchars($booking['name']); ?></div>
                            <div style="font-size: 0.9em; color: var(--light-black);"><?php echo htmlspecialchars($booking['email']); ?></div>
                        </td>
                        <td><?php echo htmlspecialchars($booking['location']); ?></td>
                        <td class="date-cell">
                            <div><?php echo date('M d', strtotime($booking['arrivals'])); ?></div>
                            <div>to</div>
                            <div><?php echo date('M d, Y', strtotime($booking['leavings'])); ?></div>
                        </td>
                        <td><?php echo $booking['guests']; ?></td>
                        <td>
                            <span class="status status-<?php echo $booking['status'] ?? 'confirmed'; ?>">
                                <?php echo ucfirst($booking['status'] ?? 'confirmed'); ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit_booking.php?id=<?php echo $booking['id']; ?>" class="action-btn">
                                <i class="fas fa-edit"></i>
                                <span class="action-text">Edit</span>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem;">No bookings found</td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>
</div>

<script>
    // Mobile menu toggle (from your existing script.js)
    document.getElementById('menu-btn').onclick = () => {
        document.querySelector('.header .navbar').classList.toggle('active');
    }
</script>

</body>
</html>