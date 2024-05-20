<?php

function generateHash($email, $clientPass, $cardNumber) {
    // Reverse the email
    $reversedEmail = strrev($email);

    // Get the first 6 and last 4 digits of the card number
    $cardFirstSix = strrev(substr($cardNumber, 0, 6));
    $cardLastFour = strrev(substr($cardNumber, -4));

    // Concatenate the components
    $toMd5 = $reversedEmail . $clientPass .$cardLastFour. $cardFirstSix;


    // Generate MD5 hash
    $hash = md5(strtoupper($toMd5));

    return $hash;
}