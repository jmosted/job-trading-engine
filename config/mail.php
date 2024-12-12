<?php
return [
    "driver" => env("MAIL_MAILER","smtp"),
    "host" => env("MAIL_HOST","smtp.hostinger.com"),
    "port" => env("MAIL_PORT",default: 465),
    "from" => array(
        "address" => env("MAIL_USERNAME","no-reply@job-trading.top"),
        "name" => env("MAIL_FROM_NAME","Job Trading")
    ),
    "username" => env("MAIL_USERNAME","no-reply@job-trading.top"),
    "password" => env("MAIL_PASSWORD","JobTrading12!"),
    "encryption" => env("MAIL_ENCRYPTION","tls")
];