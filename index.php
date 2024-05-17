<?php

function generate_order_id() {
    // Generate a random word
    $random_word = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', 5)), 0, 5);

    // Generate a timestamp
    $timestamp = time();

    // Combine them to create the order ID
    $order_id = $timestamp . '_' . $random_word;

    return $order_id;
}



$url = 'https://dev-api.rafinita.com/post';
$data = [
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
];

$boundary = '--------------------------563061781423558090622249';
$content = '';

foreach ($data as $key => $value) {
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
        "Cookie: PHPSESSID=nnkb917rv0kr8rneop0imvm1"
    ],
    CURLOPT_POSTFIELDS => $content
];

$curl = curl_init();
curl_setopt_array($curl, $options);
$response = curl_exec($curl);

if ($response === false) {
    echo 'Curl error: ' . curl_error($curl);
} else {
    echo $response;
}

curl_close($curl);
?>