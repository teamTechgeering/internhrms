<?php
header("Content-Type: application/json");

$data = [
    // ------------------------------
    // NORMAL INVOICES
    // ------------------------------
    [
        "id" => "INV #28",
        "type" => "invoice",
        "client" => "Demo Client",
        "project" => "Product Photography and Cataloging",
        "bill_date" => "2025-11-27",
        "due_date" => null,
        "total" => -500,
        "received" => 0,
        "due" => 0,
        "status" => "-"
    ],
    [
        "id" => "INV #26",
        "type" => "invoice",
        "client" => "Adrain Ondricka",
        "project" => "Social Media Content Calendar",
        "bill_date" => "2025-10-18",
        "due_date" => "2025-11-01",
        "total" => 2000,
        "received" => 0,
        "due" => 2000,
        "status" => "Overdue"
    ],
    [
        "id" => "INV #16",
        "type" => "invoice",
        "client" => "Demo Client",
        "project" => "Product Photography and Cataloging",
        "bill_date" => "2025-10-20",
        "due_date" => "2025-11-03",
        "total" => 9000,
        "received" => 9000,
        "due" => 0,
        "status" => "Fully paid"
    ],
    [
        "id" => "INV #10",
        "type" => "invoice",
        "client" => "Demo Client",
        "project" => "Product Photography and Cataloging",
        "bill_date" => "2025-11-21",
        "due_date" => "2025-11-19",
        "total" => 66,
        "received" => 0,
        "due" => 66,
        "status" => "Overdue"
    ],
    [
        "id" => "INV #9",
        "type" => "invoice",
        "client" => "Demo Client",
        "project" => "Product Photography and Cataloging",
        "bill_date" => "2025-11-13",
        "due_date" => "2025-11-27",
        "total" => 100,
        "received" => 0,
        "due" => 100,
        "status" => "Not paid"
    ],
    [
        "id" => "INV #30",
        "type" => "invoice",
        "client" => "Demo Client",
        "project" => "Product Photography and Cataloging",
        "bill_date" => "2025-11-27",
        "due_date" => null,
        "total" => -500,
        "received" => 0,
        "due" => 0,
        "status" => "-"
    ],
    [
        "id" => "INV #1",
        "type" => "invoice",
        "client" => "Adrain Ondricka",
        "project" => "Social Media Content Calendar",
        "bill_date" => "2025-10-18",
        "due_date" => "2025-11-01",
        "total" => 2000,
        "received" => 0,
        "due" => 2000,
        "status" => "Overdue"
    ],
    [
        "id" => "INV #8",
        "type" => "invoice",
        "client" => "Adrain Ondricka",
        "project" => "Social Media Content Calendar",
        "bill_date" => "2025-10-20",
        "due_date" => "2025-11-03",
        "total" => 1000,
        "received" => 1000,
        "due" => 0,
        "status" => "Fully paid"
    ],

    // ------------------------------
    // CREDIT NOTE
    // ------------------------------
    [
        "id" => "CR #1",
        "type" => "credit",
        "client" => "Demo Client",
        "project" => "Adjustment",
        "bill_date" => "2025-11-01",
        "due_date" => null,
        "total" => -50,
        "received" => 0,
        "due" => 0,
        "status" => "-"
    ],

    // ------------------------------
    // RECURRING INVOICES (NEW)
    // ------------------------------
    [
        "id" => "INV #19",
        "type" => "recurring",
        "client" => "Janice Quigley",
        "project" => "E-commerce Website Design",
        "next_recurring" => "28-12-2025",
        "repeat_every" => "1 Month(s)",
        "cycles" => "0/∞",
        "status" => "Active",
        "total_invoiced" => 90.00
    ],
    [
        "id" => "INV #10",
        "type" => "recurring",
        "client" => "Demo Client",
        "project" => "Product Photography and Cataloging",
        "next_recurring" => "28-12-2025",
        "repeat_every" => "1 Month(s)",
        "cycles" => "0/∞",
        "status" => "Active",
        "total_invoiced" => 66.00
    ]
];

echo json_encode($data);
?>
