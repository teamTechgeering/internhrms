<?php
header("Content-Type: application/json");

// Your array data
$data = [
    [
        "id" => 20,
        "client" => "Cary Lesch",
        "client_id" => 3,
        "date" => "11-11-2025",
        "created_by" => "-",
        "amount" => "30.00",
        "status" => "Accepted"
    ]
];

// Convert to JSON and print
echo json_encode($data, JSON_PRETTY_PRINT);
