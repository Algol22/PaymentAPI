<?php

require_once '../RequestSender/RequestSender.php';
require_once 'PaymentRequestException.php';

class ApiSale {

    // Required fields to validate in the incoming request.
    private $requiredFields = [
        'action', 'client_key', 'order_amount', 'order_currency', 'order_description',
        'card_number', 'card_exp_month', 'card_exp_year', 'card_cvv2', 'payer_first_name',
        'payer_last_name', 'payer_address', 'payer_country', 'payer_state', 'payer_city',
        'payer_zip', 'payer_email', 'payer_phone', 'payer_ip', 'term_url_3ds'
    ];

    private $exceptionClass;

    // Include the exception class.
    public function __construct($exceptionClass)
    {
        $this->exceptionClass = $exceptionClass;
    }

    // Check for the presence of required fields.
    private function validateFields($postData) {
        foreach ($this->requiredFields as $field) {
            if (!isset($postData[$field])) {
                throw new $this->exceptionClass('Missing required field: ' . $field, 400);
            }
        }
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $json = file_get_contents('php://input');
            $postData = json_decode($json, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                try {
                    $this->validateFields($postData);
                    $requestSender = new RequestSender(new CurlFormattedRequest($this->exceptionClass));
                    $requestSender->sendPaymentRequest($postData);
                } catch (PaymentRequestException $e) {
                    $this->sendJsonError($e->getMessage(), $e->getHttpCode());
                } catch (Exception $e) {
                    $this->sendJsonError($e->getMessage(), 500);
                }
            } else {
                $this->sendJsonError('Invalid JSON', 400);
            }
        } else {
            $this->sendJsonError('Invalid request method', 405);
        }
    }

    private function sendJsonError($message, $httpCode = 200) {
        http_response_code($httpCode);
        header('Content-Type: application/json');
        echo json_encode(['error_message' => $message]);
    }
}

// Instantiate ApiSale with the exception class.
$paymentHandler = new ApiSale(PaymentRequestException::class);
$paymentHandler->handleRequest();

?>
