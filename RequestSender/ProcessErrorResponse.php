<?php

function processErrorResponse($responseJson)
{
    $responseArray = json_decode($responseJson, true);
    $responseProcessed = ["error"=>"External API's Exception"];

    if ($responseArray !== null && isset($responseArray['error_code']) && isset($responseArray['error_message'])) {
        if (isset($responseArray['errors']) && !empty($responseArray['errors'])) {
            $errorCode = $responseArray['errors'][0]['error_code'];
            $errorMessage = $responseArray['errors'][0]['error_message'];
        } else {
            $errorCode = $responseArray['error_code'];
            $errorMessage = $responseArray['error_message'];
        }
        $responseProcessed['error_code'] = $errorCode;
        $responseProcessed['error_message'] = $errorMessage;
    }

    return json_encode( $responseProcessed);
}

?>
