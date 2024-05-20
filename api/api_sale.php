<?php
require_once '../RequestSender/RequestSender.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve raw JSON data from the request body
    $json = file_get_contents('php://input');
    $postData = json_decode($json, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        $paymentService = new RequestSender();
        $paymentService->sendPaymentRequest($postData);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON']);

    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
    http_response_code(405);
}
?>
