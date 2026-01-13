<?php
header('Content-Type: application/json');

echo json_encode([
  [
    "id" => 1,
    "title" => "ewf",
    "created_by" => "John Doe",
    "start_date" => "18-12-2025",
    "end_date" => "19-12-2025"
  ],
  [
    "id" => 2,
    "title" => "Tomorrow is holiday!",
    "created_by" => "John Doe",
    "start_date" => "24-11-2025",
    "end_date" => "24-11-2025"
  ],
  [
    "id" => 3,
    "title" => "Welcome to RISE Demo!",
    "created_by" => "John Doe",
    "start_date" => "01-03-2023",
    "end_date" => "23-10-2025"
  ]
]);
