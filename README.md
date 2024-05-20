##### Docker php + Apache images <br/>

#### unix:
` docker run -d -p 8080:80 --name my-apache-php-app -v "$PWD":/var/www/html php:apache `

#### windows:
` docker run -d -p 8080:80 --name my-apache-php-app -v ${PWD}:/var/www/html php:apache `

# Sale Transaction API

## Endpoint

**URL**: `http://localhost:8080/api/api_sale.php`

**Method**: `POST`

## Request Body

The request body should be sent as raw JSON. Below is the structure of the JSON payload required for initiating a sale transaction.

```json
{
    "action": "SALE",
    "client_key": "5b6492f0-f8f5-11ea-976a-0242c0a85007",
    "order_amount": "11",
    "order_currency": "USD",
    "order_description": "wine",
    "card_number": "4601541833776519",
    "card_exp_month": "01",
    "card_exp_year": "2025",
    "card_cvv2": "123",
    "payer_first_name": "John",
    "payer_last_name": "Rickher",
    "payer_middle_name": "Patronimic",
    "payer_birth_date": "1970-10-10",
    "payer_address": "Shevchenko 1",
    "payer_address2": "address",
    "payer_country": "UA",
    "payer_state": "Kyiv",
    "payer_city": "Kyiv",
    "payer_zip": "1234",
    "payer_email": "test@gmail.com",
    "payer_phone": "+38981234567",
    "payer_ip": "23.129.64.182",
    "term_url_3ds": "https://asdf.com"
}

