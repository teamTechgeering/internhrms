<?php
header('Content-Type: application/json');

$data = [
    [
        "name" => "Richard Gray",
        "job"  => "Web Developer",
        "email" => "richard@demo.com",
        "phone" => "+12345678974",
        "avatar" => "https://i.pravatar.cc/40?img=1",
        "status" => "active"
    ],
    [
        "name" => "Mark Thomas",
        "job"  => "Web Developer",
        "email" => "mark@demo.com",
        "phone" => "+12345678975",
        "avatar" => "https://i.pravatar.cc/40?img=2",
        "status" => "inactive"
    ],
    [
        "name" => "Sara Ann",
        "job"  => "Web Designer",
        "email" => "sara@demo.com",
        "phone" => "+12345678973",
        "avatar" => "https://i.pravatar.cc/40?img=3",
        "status" => "active"
    ],
    [
        "name" => "Michael Wood",
        "job"  => "Project Manager",
        "email" => "michael@demo.com",
        "phone" => "+12345678972",
        "avatar" => "https://i.pravatar.cc/40?img=4",
        "status" => "inactive"
    ],
    [
        "name" => "John Doe",
        "job"  => "Admin",
        "email" => "admin@demo.com",
        "phone" => "+12345678971",
        "avatar" => "https://i.pravatar.cc/40?img=5",
        "status" => "active"
    ]
];

echo json_encode($data);
?>
