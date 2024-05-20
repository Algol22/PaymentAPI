<?php
class CurlFormattedRequest
{
    private $requestStatus;

    private $requestStatusCode;
    private $declineReason;
    public function sendPayment($payerData)
    {
        // Construct and send the request using cURL
        $url = 'https://dev-api.rafinita.com/post';

        $boundary = '--------------------------' . microtime(true);
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
                "Cookie: PHPSESSID=e6fe2o6tj78obt6odbt7ageikk"
            ],
            CURLOPT_POSTFIELDS => $content
        ];

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $requestStatus = "failed";

        // Check if the HTTP status code does not start with '2'
        if (substr($httpCode, 0, 1) != '2') {
            // Status code does not start with '2'

            $this->setRequestStatus(false);
            $this->setDeclineReason($response);

        } else {
            // Status code starts with '2'
            $this->setRequestStatus(true);
        }

        $this->setRequestStatusCode($httpCode);
        curl_close($curl);

        return $response !== false ? $requestStatus.$response : $requestStatus;
    }

    /**
     * @return mixed
     */
    public function getRequestStatus()
    {
        return $this->requestStatus;
    }

    /**
     * @param mixed $requestStatus
     */
    public function setRequestStatus($requestStatus)
    {
        $this->requestStatus = $requestStatus;
    }

    /**
     * @return mixed
     */
    public function getDeclineReason()
    {
        return $this->declineReason;
    }

    /**
     * @param mixed $declineReason
     */
    public function setDeclineReason($declineReason)
    {
        $this->declineReason = $declineReason;
    }

    /**
     * @return mixed
     */
    public function getRequestStatusCode()
    {
        return $this->requestStatusCode;
    }

    /**
     * @param mixed $requestStatusCode
     */
    public function setRequestStatusCode($requestStatusCode)
    {
        $this->requestStatusCode = $requestStatusCode;
    }
}
?>
