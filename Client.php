<?php
header("Content-Type: application/json");

echo json_encode([
    "first_name" => "Abe",
    "last_name" => "Bogisich",
    "email" => "abe.bogisich@demo.com",
    "phone" => "+1.534.905.5732",
    "job_title" => "Deburring Machine Operator",
    "address" => "35877 Golden Islands",
    "city" => "Lake Violet",
    "state" => "Michigan",
    "country" => "Western Sahara",
    "gender" => "Male",
    "owner" => "John Doe",
    "groups" => ["VIP"],
    "labels" => ["Inactive"],

    "social_links" => [
        "facebook" => "https://facebook.com/abe.bogisich",
        "twitter" => "https://twitter.com/abe_bogisich",
        "linkedin" => "https://linkedin.com/in/abe-bogisich",
        "website" => "https://abebogisich.com"
    ],

    "account_settings" => [
        "account_status" => "Active",
        "language" => "English",
        "timezone" => "UTC+01",
        "created_on" => "2023-05-12",
        "last_login" => "2024-11-24 14:35"
    ],

    "permissions" => [
        "role" => "Manager",
        "access" => [
            ["module" => "Projects", "view" => true, "edit" => true, "delete" => false],
            ["module" => "Tasks", "view" => true, "edit" => true, "delete" => true],
            ["module" => "Clients", "view" => true, "edit" => false, "delete" => false],
            ["module" => "Sales", "view" => true, "edit" => false, "delete" => false]
        ]
    ]
]);
