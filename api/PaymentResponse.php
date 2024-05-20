<?php
// PaymentResponse.php
require_once 'PaymentResponseDTO.php';

class PaymentResponse implements PaymentResponseDTO
{
    private $provider;
    private $action;
    private $status;
    private $transId;
    private $transDate;
    private $amount;
    private $currency;

    public function __construct($action, $status, $transId, $transDate, $amount, $currency)
    {
        $this->provider = "Andrii's payment solutions";
        $this->action = $action;
        $this->status = $status;
        $this->transId = $transId;
        $this->transDate = $transDate;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getTransactionId(): string
    {
        return $this->transId;
    }

    public function getTransactionDate(): string
    {
        return $this->transDate;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function __toString(): string
    {
        $data = [
            'provider'=>$this->provider,
            'action' => $this->action,
            'status' => $this->status,
            'trans_id' => $this->transId,
            'trans_date' => $this->transDate,
            'amount' => $this->amount,
            'currency' => $this->currency
        ];

        // Format the JSON string
        $formattedJson = '{';
        foreach ($data as $key => $value) {
            $formattedJson .= '"' . $key . '":"' . $value . '",';
        }
        // Remove trailing comma for the last element
        $formattedJson = rtrim($formattedJson, ",");
        $formattedJson .= '}';

        return $formattedJson;
    }
}
?>
