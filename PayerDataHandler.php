<?php

// Include the PayerData class
require_once 'PayerData.php';

// Define the endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    // Assuming the endpoint is '/handle-payer-data'
    if ($_SERVER['REQUEST_URI'] === 'pay/handle-payer-data') {
        // Get the raw POST data from the request body
        $post_data = file_get_contents('php://input');

        // Decode the JSON data into an associative array
        $data_array = json_decode($post_data, true);

        // Create a PayerData object from the received data
        $payer_data = new PayerData($data_array);

        // Generate a response body containing the received data
        $response_body = json_encode($data_array);

        // Set the response headers
        header('Content-Type: application/json');

        // Send the response body
        echo $response_body;

        // Exit to prevent further execution
        exit();
    }
}

// If the request doesn't match the endpoint or method, return an error
http_response_code(404);
echo json_encode(['error' => 'Endpoint not found']);

?>
