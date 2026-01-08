<?php

header("Content-Type: application/json");

echo json_encode([
    "clientName" => "Hauck Ltd",
    "organization" => "Corporate",
    "meta" => "Gold Client",

    "invoiceOverview" => [
        "overdue" => 2,
        "notPaid" => 1,
        "partiallyPaid" => 3,
        "fullyPaid" => 5,
        "draft" => 1,
        "totalInvoiced" => 9200,
        "payments" => 8000,
        "due" => 1200
    ],

    "contacts" => [
        "name" => "Ransom Kuwalis",
        "phone" => "+19514271099",
        "email" => "ransom.kuwalis@demo.com",
        "address" => "South Jacksonville, Maryland, USA"
    ],

    "recentInvoices" => [
        ["id" => "INV-101", "amount" => 500],
        ["id" => "INV-102", "amount" => 1200],
        ["id" => "INV-103", "amount" => 800]
    ],

    "clientInfo" => [
        "organization" => "Corporate",
        "joinedDate" => "12 Jan 2024",
        "status" => "Active",
        "website" => "https://hauck.com"
    ],

    "tasks" => [
        "Project Document Review",
        "Send Contract",
        "Follow-up Meeting"
    ],

    "notes" => "Client prefers email communication, responds quickly.",

    "reminders" => [
        "Follow up on invoice INV-101",
        "Prepare project proposal draft"
    ]
]);

?>

