<?php
// Start session
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//use TCPDF;

require 'vendor/autoload.php'; // Load Composer's autoloader
include 'connect.php'; // Database file

// Mock order data (replace with actual data)
$customerEmail = $_SESSION['user_logged_in']; // Replace with actual user email
$shippingAddress = "144 Peter Rd, Ruimsig, Roodepoort"; // Replace with actual shipping address
//$shippingAddress=$_SESSION['address_details'];
$grandTotal = 0;
$grandQ = 0;

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $grandTotal += $item['price'] * $item['quantity'];
        $grandQ += $item['quantity'];
    }
} else {
    echo "<h2>Your cart is empty!</h2>";
}

// Insert the order into the `orders` table
$sql = "INSERT INTO orders (customer_email, total_amount, shipping_address, status, shipping_status)
        VALUES ('$customerEmail', $grandTotal, '$shippingAddress', 'pending', 'not shipped')";

if ($conn->query($sql) === TRUE) {
    $orderID = $conn->insert_id; // Get the last inserted order ID

    foreach ($_SESSION['cart'] as $item) {
        $productID = intval($item['id']);
        $productName = $conn->real_escape_string($item['name']);
        $productPrice = number_format($item['price'], 2);
        $productQuantity = intval($item['quantity']);
        
        $sql = "INSERT INTO order_items (order_id, product_id, product_name, product_price, quantity)
                VALUES ($orderID, $productID, '$productName', $productPrice, $productQuantity)";
        $conn->query($sql);
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Generate PDF with bank details
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$pdf->Write(0, "Bank Name: ABSA\n");
$pdf->Write(0, "Account Number: 123456789\n");
$pdf->Write(0, "Branch Code: 12345\n");
$pdf->Write(0, "Account Type: Current\n");
$pdf->Write(0, "Reference: Order ID $orderID\n");
$pdf->Write(0, "Amount to Pay: R$grandTotal\n");

// Save the PDF to a temporary file
$pdfFile = tempnam(sys_get_temp_dir(), 'bank_details_') . '.pdf';
$pdf->Output($pdfFile, 'F');

// Generate slip (HTML slip for display and email)
$slip = "
<html>
<head>
    <title>Order Slip</title>
</head>
<body>
    <h2>Order Confirmation</h2>
    <p>Thank you for your purchase! Here are your order details:</p>
    <ul>
        <li>Order ID: $orderID</li>
        <li>Total Amount: R$grandTotal</li>
        <li>Shipping Address: $shippingAddress</li>
    </ul>
    <h3>Order Items</h3>
    <ul>";

foreach ($_SESSION['cart'] as $product) {
    $slip .= "<li>{$product['name']} ({$product['quantity']} x \R{$product['price']})</li>";
}

$slip .= "</ul>
    <p>Please find the attached PDF with our banking details for EFT payment.</p>
</body>
</html>";

// Function to send slip and PDF via email
function sendSlipViaEmail($slip, $customerEmail, $pdfFile) {
    $mail = new PHPMailer(true);

    try {
         // Server settings
         $mail->SMTPDebug = 0;
         $mail->isSMTP();
         $mail->Host       = 'smtp.gmail.com';
         $mail->SMTPAuth   = true;
         $mail->Username   = 'lethabodiversey@gmail.com';
         $mail->Password   = 'nyfciuooyjicanht';
         $mail->SMTPSecure = 'tls';
         $mail->Port       = 587;
     
         // Recipients
         $mail->setFrom('diverseySa@gmail.com', 'admin');
        // $mail->addAddress($customerEmail);
         $mail->addAddress('lethabodiversey@gmail.com', 'Itani Mulaudzi');
         
         // Content
         $mail->isHTML(true);
         $mail->Subject = 'Your Order Slip';
         $mail->Body    = $slip;
         $mail->addAttachment($pdfFile, 'Bank_Details.pdf'); // Attach the PDF

         // Send email
         $mail->send();
         echo 'Slip has been sent to ' . $customerEmail;
    } catch (Exception $e) {
         echo "Slip could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

// Call the function to send the slip and PDF via email
sendSlipViaEmail($slip, $customerEmail, $pdfFile);

// Display the slip on the screen
echo $slip;

// Close the database connection
$conn->close();

// Delete the temporary PDF file after sending
unlink($pdfFile);

echo "<script>
                alert('Order was successfully sent');
                window.location.href = 'index.php';
            </script>";
exit;
?>
