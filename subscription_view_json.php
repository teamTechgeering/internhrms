<?php
header("Content-Type: application/json");

$data = [
    "subscription_id" => "SUBSCRIPTION #1",
    "title" => "Yearly subscription of example.com domain",
    "client" => "Demo Client",
    "first_billing_date" => "27-11-2025",
    "next_billing_date" => "26-12-2025",
    "repeat_every" => "1 Year(s)",

    "items" => [
        [
            "name" => "Domain .com",
            "description" => "example.com domain @ $11",
            "quantity" => "1 PC",
            "rate" => "11.00",
            "total" => "11.00"
        ]
    ],

    "sub_total" => "11.00",
    "total" => "11.00",
    "domain" => "example.com",

    "invoices" => []
];

echo json_encode($data, JSON_PRETTY_PRINT);
