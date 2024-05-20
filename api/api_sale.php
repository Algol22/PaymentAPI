<?php
require_once '../RequestSender/RequestSender.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve raw JSON data from the request body
    $json = file_get_contents('php://input');
    $postData = json_decode($json, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        try {
            // Validate required fields
            $requiredFields = [
                'action', 'client_key', 'order_amount', 'order_currency', 'order_description',
                'card_number', 'card_exp_month', 'card_exp_year', 'card_cvv2', 'payer_first_name',
                'payer_last_name', 'payer_address', 'payer_country', 'payer_state', 'payer_city',
                'payer_zip', 'payer_email', 'payer_phone', 'payer_ip', 'term_url_3ds'
            ];

            foreach ($requiredFields as $field) {
                if (!isset($postData[$field])) {
                    header('Content-Type: application/json');

                    throw new InvalidArgumentException('Missing required field: ' . $field);
                }
            }


        $paymentService = new RequestSender();
        $paymentService->sendPaymentRequest($postData);


        } catch (Exception $e) {
            // Handle other errors
            $errorResponse = [
                'result' => 'ERROR',
                'error_code' => 200,
                'error_message' => $e->getMessage()
            ];
            http_response_code(200);
            echo json_encode($errorResponse);
        }
    } else {
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid JSON, Andrii API']);

    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request method, Andrii API']);
    http_response_code(405);
}
?>
