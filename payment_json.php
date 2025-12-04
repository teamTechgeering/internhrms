<?php
header('Content-Type: application/json');


// --------------------------
//  1) EXISTING PAYMENT LIST
// --------------------------

$list = [
    [
        "invoice_id" => "INV #14",
        "payment_date" => "17-12-2025",
        "method" => "PayPal Payments Standard",
        "note" => "Facere magni tempore rem.",
        "amount" => "100.00"
    ],
    [
        "invoice_id" => "INV #15",
        "payment_date" => "09-12-2025",
        "method" => "PayPal Payments Standard",
        "note" => "Eveniet sit rerum qui.",
        "amount" => "90.00"
    ],
    [
        "invoice_id" => "INV #19",
        "payment_date" => "04-12-2025",
        "method" => "Cash",
        "note" => "",
        "amount" => "20.00"
    ],
    [
        "invoice_id" => "INV #19",
        "payment_date" => "04-12-2025",
        "method" => "Cash",
        "note" => "",
        "amount" => "70.00"
    ],
    [
        "invoice_id" => "INV #22",
        "payment_date" => "09-12-2025",
        "method" => "Paytm",
        "note" => "Ratione dolores id qui nostrum quia vero.",
        "amount" => "360.00"
    ],
    [
        "invoice_id" => "INV #23",
        "payment_date" => "12-12-2025",
        "method" => "PayPal Payments Standard",
        "note" => "Nostrum voluptate rem aut.",
        "amount" => "90.00"
    ],
    [
        "invoice_id" => "INV #24",
        "payment_date" => "04-12-2025",
        "method" => "Cash",
        "note" => "",
        "amount" => "67.50"
    ],
    [
        "invoice_id" => "INV #27",
        "payment_date" => "04-12-2025",
        "method" => "Cash",
        "note" => "",
        "amount" => "220.00"
    ],
    [
        "invoice_id" => "INV #27",
        "payment_date" => "04-12-2025",
        "method" => "Cash",
        "note" => "",
        "amount" => "10.00"
    ]
];


// ------------------------------------------------------
// 2) INVOICE DETAILS FOR payment_view.php?id=XX
// ------------------------------------------------------
$invoices = [

    14 => [
        "invoice_number" => "INV #14",
        "bill_date" => "17-12-2025",
        "due_date" => "31-12-2025",
        "status" => "Paid",
        "company" => [
            "name" => "Awesome IT Company",
            "address1" => "86935 Greenholt Forges",
            "address2" => "Bhubaneswar, 751012",
            "phone" => "+91 8480889880",
            "email" => "info@techgeering.com",
            "website" => "https://www.techgeering.in/"
        ],
        "client" => [
            "name" => "John Doe",
            "addr1" => "12 Some Street",
            "addr2" => "Downtown",
            "city" => "Somecity",
            "country" => "India"
        ],
        "items" => [
            ["title" => "Website development", "desc" => "Frontend + backend", "qty" => 1, "rate" => 1500]
        ],
        "payments" => [
            ["method" => "PayPal", "date" => "18-12-2025", "amount" => 1500, "note" => "Full payment", "file" => "receipt14.pdf"]
        ],
        "tasks" => ["Design review", "Deploy"],
        "reminders" => [
            ["title" => "Follow up", "date" => "2025-12-20", "time" => "10:00", "repeat" => "No"]
        ]
    ],

    15 => [
        "invoice_number" => "INV #15",
        "bill_date" => "09-12-2025",
        "due_date" => "20-12-2025",
        "status" => "Paid",
        "company" => [
            "name" => "Awesome IT Company",
            "address1" => "86935 Greenholt Forges",
            "address2" => "Bhubaneswar, 751012",
            "phone" => "+91 8480889880",
            "email" => "info@techgeering.com",
            "website" => "https://www.techgeering.in/"
        ],
        "client" => [
            "name" => "Client XYZ",
            "addr1" => "123 Avenue",
            "addr2" => "Block B",
            "city" => "Bhubaneswar",
            "country" => "India"
        ],
        "items" => [
            ["title" => "Digital Marketing", "desc" => "Full package", "qty" => 1, "rate" => 360]
        ],
        "payments" => [
            ["method" => "Paytm", "date" => "09-12-2025", "amount" => 360, "note" => "Paid", "file" => ""]
        ],
        "tasks" => [],
        "reminders" => []
    ],

     19 => [
        "invoice_number" => "INV #19",
        "bill_date" => "17-12-2025",
        "due_date" => "31-12-2025",
        "status" => "Paid",
        "company" => [
            "name" => "Awesome IT Company",
            "address1" => "86935 Greenholt Forges",
            "address2" => "Bhubaneswar, 751012",
            "phone" => "+91 8480889880",
            "email" => "info@techgeering.com",
            "website" => "https://www.techgeering.in/"
        ],
        "client" => [
            "name" => "John Doe",
            "addr1" => "12 Some Street",
            "addr2" => "Downtown",
            "city" => "Somecity",
            "country" => "India"
        ],
        "items" => [
            ["title" => "Website development", "desc" => "Frontend + backend", "qty" => 1, "rate" => 1500]
        ],
        "payments" => [
            ["method" => "PayPal", "date" => "18-12-2025", "amount" => 1500, "note" => "Full payment", "file" => "receipt14.pdf"]
        ],
        "tasks" => ["Design review", "Deploy"],
        "reminders" => [
            ["title" => "Follow up", "date" => "2025-12-20", "time" => "10:00", "repeat" => "No"]
        ]
    ],

    22 => [
        "invoice_number" => "INV #22",
        "bill_date" => "09-12-2025",
        "due_date" => "20-12-2025",
        "status" => "Paid",
        "company" => [
            "name" => "Awesome IT Company",
            "address1" => "86935 Greenholt Forges",
            "address2" => "Bhubaneswar, 751012",
            "phone" => "+91 8480889880",
            "email" => "info@techgeering.com",
            "website" => "https://www.techgeering.in/"
        ],
        "client" => [
            "name" => "Client XYZ",
            "addr1" => "123 Avenue",
            "addr2" => "Block B",
            "city" => "Bhubaneswar",
            "country" => "India"
        ],
        "items" => [
            ["title" => "Digital Marketing", "desc" => "Full package", "qty" => 1, "rate" => 360]
        ],
        "payments" => [
            ["method" => "Paytm", "date" => "09-12-2025", "amount" => 360, "note" => "Paid", "file" => ""]
        ],
        "tasks" => [],
        "reminders" => []
    ],

    23 => [
        "invoice_number" => "INV #23",
        "bill_date" => "04-12-2025",
        "due_date" => "10-12-2025",
        "status" => "Overdue",
        "company" => [
            "name" => "Awesome IT Company",
            "address1" => "86935 Greenholt Forges",
            "address2" => "Bhubaneswar, 751012",
            "phone" => "+91 8480889880",
            "email" => "info@techgeering.com",
            "website" => "https://www.techgeering.in/"
        ],
        "client" => [
            "name" => "Mark Twin",
            "addr1" => "Street 44",
            "addr2" => "Near Mall",
            "city" => "Cuttack",
            "country" => "India"
        ],
        "items" => [
            ["title" => "Consulting", "desc" => "3 sessions", "qty" => 3, "rate" => 100]
        ],
        "payments" => [
            ["method" => "Cash", "date" => "04-12-2025", "amount" => 220, "note" => "", "file" => ""],
            ["method" => "Cash", "date" => "04-12-2025", "amount" => 10, "note" => "", "file" => ""]
        ],
        "tasks" => [],
        "reminders" => []
    ],

    24 => [
        "invoice_number" => "INV #24",
        "bill_date" => "17-12-2025",
        "due_date" => "31-12-2025",
        "status" => "Paid",
        "company" => [
            "name" => "Awesome IT Company",
            "address1" => "86935 Greenholt Forges",
            "address2" => "Bhubaneswar, 751012",
            "phone" => "+91 8480889880",
            "email" => "info@techgeering.com",
            "website" => "https://www.techgeering.in/"
        ],
        "client" => [
            "name" => "John Doe",
            "addr1" => "12 Some Street",
            "addr2" => "Downtown",
            "city" => "Somecity",
            "country" => "India"
        ],
        "items" => [
            ["title" => "Website development", "desc" => "Frontend + backend", "qty" => 1, "rate" => 1500]
        ],
        "payments" => [
            ["method" => "PayPal", "date" => "18-12-2025", "amount" => 1500, "note" => "Full payment", "file" => "receipt14.pdf"]
        ],
        "tasks" => ["Design review", "Deploy"],
        "reminders" => [
            ["title" => "Follow up", "date" => "2025-12-20", "time" => "10:00", "repeat" => "No"]
        ]
    ],

    27 => [
        "invoice_number" => "INV #27",
        "bill_date" => "04-12-2025",
        "due_date" => "10-12-2025",
        "status" => "Overdue",
        "company" => [
            "name" => "Awesome IT Company",
            "address1" => "86935 Greenholt Forges",
            "address2" => "Bhubaneswar, 751012",
            "phone" => "+91 8480889880",
            "email" => "info@techgeering.com",
            "website" => "https://www.techgeering.in/"
        ],
        "client" => [
            "name" => "Mark Twin",
            "addr1" => "Street 44",
            "addr2" => "Near Mall",
            "city" => "Cuttack",
            "country" => "India"
        ],
        "items" => [
            ["title" => "Consulting", "desc" => "3 sessions", "qty" => 3, "rate" => 100]
        ],
        "payments" => [
            ["method" => "Cash", "date" => "04-12-2025", "amount" => 220, "note" => "", "file" => ""],
            ["method" => "Cash", "date" => "04-12-2025", "amount" => 10, "note" => "", "file" => ""]
        ],
        "tasks" => [],
        "reminders" => []
    ]
];


// ----------------------------------------
// FINAL OUTPUT
// ----------------------------------------
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    echo json_encode($invoices[$id] ?? new stdClass());
    exit;
}

// return the PAYMENT LIST when no ?id provided
echo json_encode(["list" => $list]);
exit;
?>
