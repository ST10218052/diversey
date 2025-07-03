<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $username = $full_name;
    $user_type = 'contact_form';

    // Insert into messages table
    $stmt = $conn->prepare("INSERT INTO messages (user_type, username, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $user_type, $username, $message_content);
    $message_content = "Email: $email\nPhone: $phone\nSubject: $subject\nMessage: $message";
    $stmt->execute();
    $stmt->close();

    // Redirect to a thank you page or show a success message
    /*echo "Thank you for your message!";
    echo '<script>alert("Email not verified")</script>';*/
    echo '<script>alert("Thank you for your message!");
    window.history.back();
    </script>';
exit;
}
?>
