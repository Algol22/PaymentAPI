<?php
//require_once 'PaymentRequestHandler.php';
require_once 'PayerData.php';
require_once 'OrderHelper.php';

class PaymentController
{
    public function sendPaymentRequest()
    {
        // Create an instance of PayerData with the required data
        $payerData = new PayerData([
            'action' => 'SALE',
            'client_key' => '5b6492f0-f8f5-11ea-976a-0242c0a85007',
            'order_id' => generate_order_id(),
            'order_amount' => '1.15',
            'order_currency' => 'USD',
            'order_description' => 'wine',
            'card_number' => '4601541833776519',
            'card_exp_month' => '01',
            'card_exp_year' => '2025',
            'card_cvv2' => '123',
            'payer_first_name' => 'John',
            'payer_last_name' => 'Rickher',
            'payer_middle_name' => 'Patronimic',
            'payer_birth_date' => '1970-10-10',
            'payer_address' => 'Shevchenko 1',
            'payer_address2' => 'address',
            'payer_country' => 'UA',
            'payer_state' => 'Kyiv',
            'payer_city' => 'Kyiv',
            'payer_zip' => '1234',
            'payer_email' => 'test@gmail.com',
            'payer_phone' => '+38981234567',
            'payer_ip' => '23.129.64.182',
            'term_url_3ds' => 'https://asdf.com',
            'hash' => '8a987a351a739c78462da9818b6ac5c4'
        ]);

        // Now you can use the $payerData object to send the payment request
        // Example:
        $response = $this->sendPayment($payerData);

        // Handle response
        if ($response === false) {
            echo 'Failed to send payment request';
        } else {
            echo $response;
        }
    }

    private function sendPayment($payerData)
    {
        // You can use the $payerData object to construct the request
        // and send it using curl or any other method

        // Example:
        $url = 'https://dev-api.rafinita.com/post';

        $boundary = '--------------------------563061781423558090622249';
        $content = '';

        foreach ($payerData as $key => $value) {
            $content .= "--$boundary\r\n";
            $content .= "Content-Disposition: form-data; name=\"$key\"\r\n\r\n";
            $content .= "$value\r\n";
        }

        $content .= "--$boundary--\r\n";

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: multipart/form-data; boundary=$boundary",
                "Cookie: PHPSESSID=nnkb917rv0kr8rneop0imvm29l"
            ],
            CURLOPT_POSTFIELDS => $content
        ];

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);

        if ($response === false) {
            return false;
        } else {
            return $response;
        }

        curl_close($curl);
    }
}

// Usage
$controller = new PaymentController();
$controller->sendPaymentRequest();
?>
