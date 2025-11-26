<?php
header("Content-Type: application/json");

$leads = [
    [
        "id" => 1,
        "name" => "Cassin & Sons",
        "contact" => "Webster Nicolas",
        "phone" => "205-360-2071",
        "owner" => "Sara Ann",
        "label" => "50%",
        "created" => "2025-11-20",
        "status" => "Discussion"
    ],
    [
        "id" => 2,
        "name" => "Louie Ziemann",
        "contact" => "Louie Ziemann",
        "phone" => "320-525-3188",
        "owner" => "Richard Gray",
        "label" => "90%",
        "created" => "2025-11-18",
        "status" => "Qualified"
    ]
];

echo json_encode($leads, JSON_PRETTY_PRINT);
