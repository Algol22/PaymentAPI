<?php

class PayerData
{
    public $action;
    public $client_key;
    public $order_id;
    public $order_amount;
    public $order_currency;
    public $order_description;
    public $card_number;
    public $card_exp_month;
    public $card_exp_year;
    public $card_cvv2;
    public $payer_first_name;
    public $payer_last_name;
    public $payer_middle_name;
    public $payer_birth_date;
    public $payer_address;
    public $payer_address2;
    public $payer_country;
    public $payer_state;
    public $payer_city;
    public $payer_zip;
    public $payer_email;
    public $payer_phone;
    public $payer_ip;
    public $term_url_3ds;
    public $hash;

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}
