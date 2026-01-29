<?php
header("Content-Type: application/json");

$uploadDir = __DIR__ . "/uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!isset($_FILES['file'])) {
    echo json_encode(["success" => false, "message" => "No file"]);
    exit;
}

$file = $_FILES['file'];

$allowed = ['jpg','jpeg','png','gif','webp'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($ext, $allowed)) {
    echo json_encode(["success" => false, "message" => "Invalid file type"]);
    exit;
}

$filename = time() . "_" . basename($file['name']);
$target = $uploadDir . $filename;

if (move_uploaded_file($file['tmp_name'], $target)) {
    echo json_encode([
        "success" => true,
        "name" => $filename,
        "size" => round($file['size'] / 1024) . " KB"
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Upload failed"]);
}
