<?php
header('Content-Type: application/json');

// Get proposal ID from query
$id = isset($_GET['id']) ? $_GET['id'] : 9;

// Example data – replace with your database query later
$proposals = [
    9 => [
        "id" => 9,
        "proposal_no" => "PROPOSAL #9",
        "status" => "Accepted",
        "proposal_date" => "20-10-2025",
        "valid_until" => "20-12-2025",
        "client_name" => "Jane Hand",
        "note" => "Voluptatibus re non aliquid.",
        "signer_name" => "Jane Hand",
        "signer_email" => "jane.hand@demo.com",

        // Items
        "items" => [
            [
                "item" => "SEO",
                "description" => "SEO for your websites",
                "quantity" => 10,
                "rate" => 10,
                "total" => 100
            ]
        ],

        // Content inside editor
        "content_html" => "<h2>Web Design Proposal</h2><p>In response...</p>"
    ]
];

echo json_encode($proposals[$id]);
exit;
?>
