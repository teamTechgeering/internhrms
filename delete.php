<?php
$data = json_decode(file_get_contents("php://input"), true);
$file = $data['file'] ?? "";

$path = __DIR__ . "/uploads/" . basename($file);

if ($file && file_exists($path)) {
    unlink($path);
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
