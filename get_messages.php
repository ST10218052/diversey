<?php
// Include database connection file
include 'connect.php';

$query = "SELECT * FROM messages ORDER BY created_at ASC";
$result = $conn->query($query);
$messages = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = [
            'user_type' => $row['user_type'],
            'message' => $row['message'],
            'created_at' => $row['created_at']
        ];
    }
}

echo json_encode($messages);
?>
