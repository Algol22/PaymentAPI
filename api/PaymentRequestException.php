<?php

class PaymentRequestException extends Exception
{
    private $httpCode;


    public function __construct($message, $httpCode = 0)
    {
        $this->httpCode = $httpCode;


        parent::__construct($message, $httpCode);
    }

    public function getHttpCode()
    {
        return $this->httpCode;
    }

    public function getType()
    {
        return $this->type;
    }
}

?>
