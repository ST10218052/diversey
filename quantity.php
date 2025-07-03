<?php

session_start();
// Example: Initialize cart session for demonstration purposes

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $action = $_POST['action'];

    // Loop through the cart items
    foreach ($_SESSION['cart'] as $key =>  &$item) {
        if ($item['id'] == $product_id) {
            if($action == 'increase') {
                $item['quantity'] += 1; // Increase quantity by 1
            } elseif ($action == 'decrease') {
                
                $item['quantity'] -= 1; // Decrease quantity by 1
                
                // If quantity is 0 or less, remove the item from the cart
                if ($item['quantity'] <= 0) {
                    unset($_SESSION['cart'][$key]); // Remove item from session
                }
            }
            break;
        }
    }
}

header("Location: index.php");
exit;
?>
