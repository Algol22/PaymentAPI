<?php
require_once '../DataModel/PayerData.php';
require_once 'OrderGenerator.php';
require_once 'HashGenerator.php';
require_once 'CurlFormattedRequest.php';
require_once '../api/PaymentResponse.php';
require_once '../Config/config.php';

class RequestSender
{
    public function sendPaymentRequest($postData)
    {


            // Convert order_amount to float if it's not already
            $orderAmount = $postData['order_amount'];
            if (strpos($orderAmount, '.') === false) {
                // Add dot and two zeros at the end
                $orderAmount .= '.00';
            }

            $order_id = generate_order_id();

            // Create an instance of PayerData with the received data
            $payerData = new PayerData([
                'action' => $postData['action'],
                'client_key' => $postData['client_key'],
                'order_id' => $order_id,
                'order_amount' => $orderAmount,
                'order_currency' => $postData['order_currency'],
                'order_description' => $postData['order_description'],
                'card_number' => $postData['card_number'],
                'card_exp_month' => $postData['card_exp_month'],
                'card_exp_year' => $postData['card_exp_year'],
                'card_cvv2' => $postData['card_cvv2'],
                'payer_first_name' => $postData['payer_first_name'],
                'payer_last_name' => $postData['payer_last_name'],
                'payer_middle_name' => isset($postData['payer_middle_name']) ? $postData['payer_middle_name'] : '',
                'payer_birth_date' => isset($postData['payer_birth_date']) ? $postData['payer_birth_date'] : '',
                'payer_address' => $postData['payer_address'],
                'payer_address2' => isset($postData['payer_address2']) ? $postData['payer_address2'] : '',
                'payer_country' => $postData['payer_country'],
                'payer_state' => $postData['payer_state'],
                'payer_city' => $postData['payer_city'],
                'payer_zip' => $postData['payer_zip'],
                'payer_email' => $postData['payer_email'],
                'payer_phone' => $postData['payer_phone'],
                'payer_ip' => $postData['payer_ip'],
                'term_url_3ds' => $postData['term_url_3ds'],
                'hash' => generateHash($postData['payer_email'], API_KEY, $postData['card_number'])
            ]);


            // Send the payment request
            $response = (new CurlFormattedRequest());
            $response->sendPayment($payerData);


            if (!$response->getRequestStatus()) {

                header('Content-Type: application/json');



                $responseJson = $response->getDeclineReason(); // Assuming getDeclineReason() returns JSON string


                $responseArray = json_decode($responseJson, true);


                $responseProcessed = [];

                if ($responseArray !== null && isset($responseArray['error_code']) && isset($responseArray['error_message'])) {
                    // Check if "errors" array is present and not empty
                    if (isset($responseArray['errors']) && !empty($responseArray['errors'])) {
                        // Extract error details from the first error in the "errors" array
                        $errorCode = $responseArray['errors'][0]['error_code'];
                        $errorMessage = $responseArray['errors'][0]['error_message'];
                    } else {
                        // Extract error details from the main response
                        $errorCode = $responseArray['error_code'];
                        $errorMessage = $responseArray['error_message'];
                    }
                    // Add the error details to the response array
                    $responseProcessed['error_code'] = $errorCode;
                    $responseProcessed['error_message'] = $errorMessage;
                }


                $jsonResponseProcessed = json_encode($responseProcessed);


                echo $jsonResponseProcessed;

            } else {

                // Parse the response JSON and return an instance of PaymentResponseDTO
                $responseData = json_decode($response->getResponseBody(), true);
                header('Content-Type: application/json');

                echo new PaymentResponse(
                    $responseData['action'],
                    $responseData['status'],
                    $responseData['trans_id'],
                    $responseData['trans_date'],
                    $responseData['amount'],
                    $responseData['currency']
                );
            }


    }

}
?>
