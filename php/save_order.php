<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

include 'connection.php';

$data = json_decode(file_get_contents("php://input"), true);

// Collecting data
$design_id = intval($data['design_id']);
$total_price = floatval($data['total_price']);
$user_id = intval($_SESSION['user_id']); // Ensure user is logged in

if (!$design_id || !$total_price || !$user_id) {
    echo json_encode(['success' => false, 'error' => 'Missing order data']);
    exit;
}
// Set default status
$order_status = 'Pending';

// Insert into orders table
$stmt = $con->prepare("INSERT INTO orders (user_id, design_id, total_price, order_status) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iids", $user_id, $design_id, $total_price, $order_status);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode([
        'success' => true,
        'order_id' => $stmt->insert_id
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Failed to create order'
    ]);
}
?>