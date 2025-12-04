<?php
header('Content-Type: application/json');

$data = [
    "id" => 9,
    "proposal_no" => "PROPOSAL #9",

    // BASIC INFO
    "proposal_date" => "20-10-2025",
    "valid_until" => "20-12-2025",
    "status" => "Accepted",
    "amount" => 100.00,

    // CLIENT INFO
    "client_name" => "Jane Hand",
    "client_company" => "Awesome Demo Company",
    "client_email" => "jane.hand@demo.com",
    "client_phone" => "+12345678888",
    "client_address" => "86935 Greenholt Forges, Florida, 5626",
    "client_country" => "USA",

    // PROPOSAL ITEMS (TABLE)
    "items" => [
        [
            "item" => "SEO",
            "description" => "SEO for your websites",
            "quantity" => "10 Hour",
            "rate" => 10.00,
            "total" => 100.00
        ]
    ],

    // NOTE SECTION
    "note" => "Voluptatibus re non aliquid.",

    // SIGNER INFO
    "signer_name" => "Jane Hand",
    "signer_email" => "jane.hand@demo.com",

    // MAIN EDITOR CONTENT
    "content_html" => "
        <h2>Web Design Proposal</h2>
        <p>In response to the growing demands...</p>
        <h3>Our Best Offer</h3>
        <p>We propose to deliver value...</p>
        <h3>Our Objective</h3>
        <p>Our objective is to align seamlessly...</p>
        <h3>Our Portfolio</h3>
    "
];

echo json_encode($data);
?>
