<?php
// Include database connection file
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get message and user type from AJAX request
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);

    // Insert message into messages table
    $stmt = $conn->prepare("INSERT INTO messages (user_type, username, message, created_at) VALUES (?, ?, ?, NOW())");
    if ($stmt) {
        $username = ($user_type === 'admin') ? 'Admin' : 'User';
        $stmt->bind_param("sss", $user_type, $username, $message);
        $stmt->execute();
        $stmt->close();
        echo "Message saved successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
