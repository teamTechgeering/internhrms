<?php
header('Content-Type: application/json');

echo json_encode([
    [
        "title" => "How to use help desk?",
        "category" => "Help desk",
        "created_at" => "18-03-2023 07:33 am",
        "status" => "Active",
        "views" => 4,
        "sort" => 0,
        "content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
    ],
    [
        "title" => "How to submit your work to product manager?",
        "category" => "Guidelines",
        "created_at" => "18-03-2023 07:32 am",
        "status" => "Active",
        "views" => 0,
        "sort" => 0,
        "content" => "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium."
    ],
    [
        "title" => "How to share your knowledge with team?",
        "category" => "Help desk",
        "created_at" => "18-03-2023 07:33 am",
        "status" => "Active",
        "views" => 0,
        "sort" => 0,
        "content" => "Sharing knowledge helps teams grow and collaborate better across projects."
    ],
    [
        "title" => "How to develop a best product?",
        "category" => "Guidelines",
        "created_at" => "18-03-2023 07:32 am",
        "status" => "Active",
        "views" => 1,
        "sort" => 0,
        "content" => "Product development requires planning, testing, and continuous improvement."
    ],
    [
        "title" => "How to submit your work to product manager?",
        "category" => "Guidelines",
        "created_at" => "18-03-2023 07:32 am",
        "status" => "Active",
        "views" => 0,
        "sort" => 0,
        "content" => "Sed ut perspiciatis unde omnis iste natus error sit voluptatem..."
    ],
    [
        "title" => "How much paid leave I can get in a year?",
        "category" => "Leave policy",
        "created_at" => "18-03-2023 07:34 am",
        "status" => "Active",
        "views" => 0,
        "sort" => 0,
        "content" => "Employees are entitled to a fixed number of paid leaves per year as per company policy."
    ],
    [
        "title" => "How much leave I can enjoy in a year?",
        "category" => "Leave policy",
        "created_at" => "18-03-2023 07:34 am",
        "status" => "Active",
        "views" => 0,
        "sort" => 0,
        "content" => "Annual leave depends on role, tenure, and company regulations."
    ]
]);
