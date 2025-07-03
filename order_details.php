<?php
// Start session and include database connection
session_start();
include 'connect.php';

$customerEmail = $_SESSION['user_logged_in'];

// Validate the order_id parameter
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    echo "Invalid order ID.";
    exit();
}

$orderID = intval($_GET['order_id']);

// Fetch order details
$sqlOrder = "SELECT * FROM orders WHERE order_id = $orderID AND customer_email = '$customerEmail'";
$resultOrder = $conn->query($sqlOrder);

if ($resultOrder->num_rows == 0) {
    echo "Order not found or you do not have permission to view this order.";
    exit();
}

$order = $resultOrder->fetch_assoc();

// Fetch order items
$sqlItems = "SELECT * FROM order_items WHERE order_id = $orderID";
$resultItems = $conn->query($sqlItems);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details</title>

    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: auto; }
        h2, h3 { color: #333; margin-top:40px}
        .order-summary, .order-items { margin-bottom: 20px; }
        .order-summary table, .order-items table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background-color: #f5f5f5; }
        .total { font-weight: bold; }
    </style>
    <link rel="stylesheet" href="style.css">
    <header class="header" >
    <a href="#home" class="logo">
       <img src="_images\logo2.jpg" alt="logo">
    </a>
   
    <NAV class="navbar" id="navbar">

        <ul id="navbar"> 
        <li>
                <a  href="index.php" onclick="setActive(this)" >home</a>                 
            </li>
            
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
</head>
<body>
    <div class="container">
        <h2>Order Details</h2>

        <!-- Order Summary -->
        <div class="order-summary">
            <h3>Order Summary</h3>
            <table>
                <tr>
                    <th>Order ID</th>
                    <td><?php echo $order['order_id']; ?></td>
                </tr>
                <tr>
                    <th>Total Amount</th>
                    <td>R<?php echo number_format($order['total_amount'], 2); ?></td>
                </tr>
                <tr>
                    <th>Shipping Address</th>
                    <td><?php echo $order['shipping_address']; ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?php echo ucfirst($order['status']); ?></td>
                </tr>
                <tr>
                    <th>Shipping Status</th>
                    <td><?php echo ucfirst($order['shipping_status']); ?></td>
                </tr>
            </table>
        </div>

        <!-- Order Items -->
        <div class="order-items">
            <h3>Order Items</h3>
            <?php if ($resultItems->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit Price (R)</th>
                        <th>Subtotal (R)</th>
                    </tr>
                    <?php
                    while ($item = $resultItems->fetch_assoc()):
                        $subtotal = $item['product_price'] * $item['quantity'];
                    ?>
                        <tr>
                            <td><?php echo $item['product_name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($item['product_price'], 2); ?></td>
                            <td><?php echo number_format($subtotal, 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="3" class="total">Grand Total</td>
                        <td class="total">R<?php echo number_format($order['total_amount'], 2); ?></td>
                    </tr>
                </table>
            <?php else: ?>
                <p>No items found for this order.</p>
            <?php endif; ?>
        </div>

        <a href="order_history.php">Back to Orders</a>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
