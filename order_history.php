<?php
// Start session and include database connection
session_start();
include 'connect.php';

$customerEmail = $_SESSION['user_logged_in'];

// Fetch current (pending) orders
$sqlCurrent = "SELECT * FROM orders WHERE customer_email = '$customerEmail' AND status = 'pending'";
$resultCurrent = $conn->query($sqlCurrent);

// Fetch past (completed) orders
$sqlHistory = "SELECT * FROM orders WHERE customer_email = '$customerEmail' AND status = 'completed'";
$resultHistory = $conn->query($sqlHistory);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order History</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: auto; }
        h2 { color: #333; 
        margin-top:40px;}
        .order-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .order-table th, .order-table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        .order-table th { background-color: #f5f5f5; }
        .status { font-weight: bold; color: green; }
    </style>

<link rel="stylesheet" href="style.css">
</head>
<header class="header" >
    <a href="#home" class="logo">
       <img src="_images\logo2.jpg" alt="logo">
    </a>
   
    <NAV class="navbar" id="navbar">

        <ul id="navbar"> 
        <li>
                <a  href="index.php" onclick="setActive(this)" >home</a>                 
            </li>
            <li>
                <a href = "index.php"  onclick="setActive(this)">about</a>
            </li>
            <li>
                <a href = "index.php" onclick="setActive(this)">products</a>
            </li>
            <li>
                <a href="index.php" onclick="setActive(this)">Contact</a>  
            </li>
            <li>
                <a href="bot.php" onclick="setActive(this)">Chat</a>  
            </li>
        </ul>
        
    </NAV>
	
	
   <br>
   <br>
    </div>
    <div class="user-wrapper">
                <?php if (isset($profile_picture)) { ?>
                    <div class="profile-picture">
                        <p> "<?php $user ?>" </p>
                    </div>
                <?php } ?>
   
	</header>

<body>
    <div class="container">
        <h2>Current Orders</h2>
        <?php if ($resultCurrent->num_rows > 0): ?>
            <table class="order-table">
                <tr>
                    <th>Order ID</th>
                    <th>Total Amount (R)</th>
                    <th>Shipping Address</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
                <?php while ($order = $resultCurrent->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $order['order_id']; ?></td>
                        <td><?php echo $order['total_amount']; ?></td>
                        <td><?php echo $order['shipping_address']; ?></td>
                        <td class="status"><?php echo ucfirst($order['shipping_status']); ?></td>
                        <td><a href="order_details.php?order_id=<?php echo $order['order_id']; ?>">View Details</a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>You have no current orders.</p>
        <?php endif; ?>

        <h2>Order History</h2>
        <?php if ($resultHistory->num_rows > 0): ?>
            <table class="order-table">
                <tr>
                    <th>Order ID</th>
                    <th>Total Amount (R)</th>
                    <th>Shipping Address</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
                <?php while ($order = $resultHistory->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $order['order_id']; ?></td>
                        <td><?php echo $order['total_amount']; ?></td>
                        <td><?php echo $order['shipping_address']; ?></td>
                        <td class="status"><?php echo ucfirst($order['shipping_status']); ?></td>
                        <td><a href="order_details.php?order_id=<?php echo $order['order_id']; ?>">View Details</a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>You have no order history.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
