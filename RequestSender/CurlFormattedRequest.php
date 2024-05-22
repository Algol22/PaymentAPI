<?php

class CurlFormattedRequest
{
    private $requestStatus;
    private $requestStatusCode;
    private $declineReason;
    private $responseBody;


    public function sendPayment($payerData)
    {
        // Construct and send the request using cURL
        $url = 'https://dev-api.rafinita.com/post';

        $boundary = '--------------------------' . microtime(true);
        $content = $this->buildMultipartFormData($payerData, $boundary);

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: multipart/form-data; boundary=$boundary",
                "Cookie: PHPSESSID=e6fe2o6tj78obt6odbt7ageikk"
            ],
            CURLOPT_POSTFIELDS => $content
        ];

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (substr($httpCode, 0, 1) != '2') {
            // Status code does not start with '2'
            $this->setRequestStatus(false);
            $this->setDeclineReason($response);
        } else {
            // Status code starts with '2'
            $this->setRequestStatus(true);
            $this->setResponseBody($response);
        }

        $this->setRequestStatusCode($httpCode);
        curl_close($curl);

        return $response !== false ? $response : false;
    }

    private function buildMultipartFormData($data, $boundary)
    {
        $content = '';
        foreach ($data as $key => $value) {
            $content .= "--$boundary\r\n";
            $content .= "Content-Disposition: form-data; name=\"$key\"\r\n\r\n";
            $content .= "$value\r\n";
        }
        $content .= "--$boundary--\r\n";
        return $content;
    }

    public function getRequestStatus()
    {
        return $this->requestStatus;
    }

    public function setRequestStatus($requestStatus)
    {
        $this->requestStatus = $requestStatus;
    }

    public function getDeclineReason()
    {
        return $this->declineReason;
    }

    public function setDeclineReason($declineReason)
    {
        $this->declineReason = $declineReason;
    }

    public function getRequestStatusCode()
    {
        return $this->requestStatusCode;
    }

    public function setRequestStatusCode($requestStatusCode)
    {
        $this->requestStatusCode = $requestStatusCode;
    }

    public function getResponseBody()
    {
        return $this->responseBody;
    }

    public function setResponseBody($responseBody)
    {
        $this->responseBody = $responseBody;
    }
}
?>
