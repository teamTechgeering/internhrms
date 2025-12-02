<?php
header('Content-Type: application/json');

$data = [
    [
        "id" => 9,
        "proposal_no" => "PROPOSAL #9",
        "client" => "Jane Hand",
        "proposal_date" => "20-10-2025",
        "valid_until" => "20-12-2025",
        "amount" => "$100.00",
        "status" => "Accepted"
    ]
];

echo json_encode($data);
?>
