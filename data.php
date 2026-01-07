<?php
header('Content-Type: application/json');

$type = $_GET['type'] ?? 'yearly';

$data = [

    "yearly" => [
        [
            "client" => "Abshire-Swaniawski",
            "count" => 3,
            "invoice_total" => 8540.00,
            "paid" => 4450.00,
            "due" => 4090.00
        ],
        [
            "client" => "Adrain Ondricka",
            "count" => 7,
            "invoice_total" => 4913.00,
            "paid" => 2913.00,
            "due" => 2000.00
        ],
        [
            "client" => "Alta Cassin",
            "count" => 2,
            "invoice_total" => 277.00,
            "paid" => 177.00,
            "due" => 100.00
        ],
        [
            "client" => "Demo Client",
            "count" => 3,
            "invoice_total" => 9166.00,
            "paid" => 9000.00,
            "due" => 166.00
        ],
        [
            "client" => "Edd Leffler",
            "count" => 4,
            "invoice_total" => 330.00,
            "paid" => 225.00,
            "due" => 105.00
        ],
        [
            "client" => "Fritsch, Okuneva and Armstrong",
            "count" => 1,
            "invoice_total" => 1000.00,
            "paid" => 0.00,
            "due" => 1000.00
        ],
        [
            "client" => "Janice Quigley",
            "count" => 2,
            "invoice_total" => 330.00,
            "paid" => 120.00,
            "due" => 210.00
        ],
        [
            "client" => "Melvina Kling",
            "count" => 3,
            "invoice_total" => 1890.00,
            "paid" => 945.00,
            "due" => 945.00
        ]
    ],

    "monthly" => [
        [
            "client" => "Demo Client",
            "count" => 1,
            "invoice_total" => 3000.00,
            "paid" => 2500.00,
            "due" => 500.00
        ]
    ],

    "custom" => [
        [
            "client" => "Custom Client",
            "count" => 2,
            "invoice_total" => 2000.00,
            "paid" => 1000.00,
            "due" => 1000.00
        ]
    ]
];

// Fallback safety
echo json_encode($data[$type] ?? []);
