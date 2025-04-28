<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

include 'connection.php'; // ✅ use your existing connection

$data = json_decode(file_get_contents("php://input"), true);

$image = $data['image'];
$product_id = intval($data['product_id']);
$user_id = intval($_SESSION['user_id']); // make sure user is logged in

if (!$image || !$user_id || !$product_id) {
    echo json_encode(['success' => false, 'error' => 'Missing data']);
    exit;
}

// Decode base64 and save image
$image = str_replace('data:image/png;base64,', '', $image);
$image = str_replace(' ', '+', $image);
$imageData = base64_decode($image);

$filename = 'design_' . time() . '.png';
$filepath = 'uploads/' . $filename;
file_put_contents($filepath, $imageData);

// Insert into DB using your table structure
$stmt = $conn->prepare("INSERT INTO designs (user_id, product_id, design_data) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $user_id, $product_id, $filepath);
$stmt->execute();

echo json_encode(['success' => true, 'design_id' => $stmt->insert_id]);
?>
