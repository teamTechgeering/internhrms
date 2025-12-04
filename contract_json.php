<?php
header('Content-Type: application/json');

$data = [
    [
        "id" => 20,
        "contract_no" => "CONTRACT #20",
        "title" => "Training and Workshop Services Contract",
        "client" => "Demo Client",
        "client_id" => 1,
        "contract_date" => "31-10-2025",
        "valid_until" => "31-12-2025",
        "amount" => 160.00,
        "status" => "Accepted",
        "status_color" => "primary"
    ],
    [
        "id" => 18,
        "contract_no" => "CONTRACT #18",
        "title" => "Creative Services Contract",
        "client" => "Thompson-McLaughlin",
        "client_id" => 2,
        "contract_date" => "13-10-2025",
        "valid_until" => "13-12-2025",
        "amount" => 20.00,
        "status" => "Sent",
        "status_color" => "info"
    ],
    [
        "id" => 8,
        "contract_no" => "CONTRACT #8",
        "title" => "Content Writing and Copywriting Contract",
        "client" => "Birdie Erdman",
        "client_id" => 3,
        "contract_date" => "07-10-2025",
        "valid_until" => "07-12-2025",
        "amount" => 400.00,
        "status" => "Accepted",
        "status_color" => "primary"
    ],
    [
        "id" => 7,
        "contract_no" => "CONTRACT #7",
        "title" => "Marketing Services Agreement",
        "client" => "Kevin Johnston",
        "client_id" => 4,
        "contract_date" => "12-11-2025",
        "valid_until" => "06-09-2023",
        "amount" => 120.00,
        "status" => "Draft",
        "status_color" => "secondary"
    ],
    [
        "id" => 5,
        "contract_no" => "CONTRACT #5",
        "title" => "Consulting Services Agreement",
        "client" => "Fritsch, Dooley and Barton",
        "client_id" => 5,
        "contract_date" => "04-12-2025",
        "valid_until" => "07-12-2025",
        "amount" => 80.00,
        "status" => "Accepted",
        "status_color" => "primary"
    ],
    [
        "id" => 4,
        "contract_no" => "CONTRACT #4",
        "title" => "Video Production Contract",
        "client" => "OReilly, Schuppe and Bartell",
        "client_id" => 6,
        "contract_date" => "29-11-2025",
        "valid_until" => "23-09-2023",
        "amount" => 3000.00,
        "status" => "Sent",
        "status_color" => "info"
    ]
];

echo json_encode($data);
