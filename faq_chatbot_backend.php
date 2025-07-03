<?php
header('Content-Type: application/json');

$faq = [
    "1" => "Our business hours are from 9 AM to 6 PM, Monday to Friday.",
    "2" => "You can contact our customer service by emailing diverseysa@gmail.com or calling (012) 456-7890.",
    "3" => "We accept returns within 30 days of purchase. Please make sure the items are in their original condition.",
    "4" => "Once your order is shipped, you will receive a tracking number via email.",
    "5" => "Yes, we offer international shipping. Please contact the admin for our shipping policy for more details.",
    "6" => "To reset your password, leave a message for the admin by utilising the contact form and follow the instructions."
];

// Get user message from the request
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);
$userMessage = $data['message'];

// Simple FAQ matching logic (case-insensitive)
$response = "Sorry, I don't have an answer for that question. Please try asking something else or contact support.";
foreach ($faq as $question => $answer) {
    if (stripos($userMessage, $question) !== false) {
        $response = $answer;
        break;
    }
}

// Return the response as JSON
echo json_encode(['response' => $response]);
?>
