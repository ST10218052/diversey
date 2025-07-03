<?php
// Start session
session_start();

// Destroy session to log out user
session_destroy();

// Redirect to login page
header("Location: index.php");
exit;
?>
