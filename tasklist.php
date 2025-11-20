<?php

header("Content-Type: application/json");

echo json_encode([
    "tasks" => [
        [
            "id" => "3486",
            "title" => "Provide plugin customer support",
            "badge" => "Enhancement",
            "badgeColor" => "primary",
            "start_date" => "-",
            "deadline" => "23-09-2025",
            "deadline_color" => "text-danger",
            "milestone" => "Beta Release",
            "assigned_to" => "Michael Wood",
            "collaborators" => "-",
            "status" => "To do"
        ],
        [
            "id" => "3485",
            "title" => "Submit plugin to WordPress repository",
            "start_date" => "-",
            "deadline" => "23-09-2025",
            "deadline_color" => "text-danger",
            "milestone" => "Beta Release",
            "assigned_to" => "Mark Thomas",
            "collaborators" => "-",
            "status" => "In progress"
        ],
    ]
], JSON_PRETTY_PRINT);

?>
