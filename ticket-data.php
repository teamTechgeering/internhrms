<?php
$data = [
    [
        "id" => "Ticket #5",
        "title" => "How to upgrade the software?",
        "client" => "Randy Daniel",
        "type" => "General Support",
        "labels" => "",
        "assigned" => "John Doe",
        "activity" => "Today at 07:34 pm",
        "status" => "Open"
    ],

    [
        "id" => "Ticket #6",
        "title" => "Can not open the design file.",
        "client" => "Demo Client",
        "type" => "Bug Reports",
        "labels" => "",
        "assigned" => "John Doe",
        "activity" => "Yesterday at 03:03 pm",
        "status" => "Open"
    ],

    [
        "id" => "Ticket #8",
        "title" => "I can not add a new task.",
        "client" => "DuBuque Ltd",
        "type" => "Bug Reports",
        "labels" => "",
        "assigned" => "Richard Gray",
        "activity" => "Yesterday at 01:19 pm",
        "status" => "New"
    ],

    [
        "id" => "Ticket #7",
        "title" => "Where can I find the user manual?",
        "client" => "Hermiston–Wilkinson",
        "type" => "General Support",
        "labels" => "",
        "assigned" => "Michael Wood",
        "activity" => "Yesterday at 05:18 am",
        "status" => "Open"
    ],

    [
        "id" => "Ticket #11",
        "title" => "Are there any ongoing sales or offers?",
        "client" => "Sammy Steuber",
        "type" => "Sales Inquiry",
        "labels" => "",
        "assigned" => "Michael Wood",
        "activity" => "06-12-2025 03:38 pm",
        "status" => "Open"
    ],

    [
        "id" => "Ticket #10",
        "title" => "Do you offer any special promotions?",
        "client" => "DuBuque Ltd",
        "type" => "Sales Inquiry",
        "labels" => "",
        "assigned" => "John Doe",
        "activity" => "06-12-2025 11:39 am",
        "status" => "Open"
    ],

    [
        "id" => "Ticket #9",
        "title" => "How do I reset my password?",
        "client" => "Cary Lesch",
        "type" => "General Support",
        "labels" => "",
        "assigned" => "Mark Thomas",
        "activity" => "06-12-2025 08:31 am",
        "status" => "New"
    ]
];

header('Content-Type: application/json');
echo json_encode($data);
