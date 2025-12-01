<?php
header('Content-Type: application/json');

$data = [
    [
        "order" => "ORDER #19",
        "client" => "Hauck Ltd",
        "invoice" => "-",
        "date" => "29-11-2025",
        "amount" => "$180.00",
        "status" => "Processing"
    ],
    [
        "order" => "ORDER #18",
        "client" => "Roel Grimes",
        "invoice" => "-",
        "date" => "21-11-2025",
        "amount" => "$80.00",
        "status" => "Confirmed"
    ],
    [
        "order" => "ORDER #17",
        "client" => "Phoebe Strosin",
        "invoice" => "-",
        "date" => "14-10-2025",
        "amount" => "$55.00",
        "status" => "New"
    ],
    [
        "order" => "ORDER #16",
        "client" => "OReilly, Schuppe and Bartell",
        "invoice" => "-",
        "date" => "28-11-2025",
        "amount" => "$400.00",
        "status" => "Processing"
    ],
    [
        "order" => "ORDER #15",
        "client" => "Leif Hoeger",
        "invoice" => "-",
        "date" => "02-10-2025",
        "amount" => "$60.00",
        "status" => "New"
    ]
];

echo json_encode($data);
?>
