<?php
include "connection.php";
// Function to save design
function save_design($user_id, $design_data) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO designs (user_id, design_data) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $design_data);
    $stmt->execute();
    $stmt->close();
}

// Function to get design
function get_design($design_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT design_data FROM designs WHERE id = ?");
    $stmt->bind_param("i", $design_id);
    $stmt->execute();
    $stmt->bind_result($design_data);
    $stmt->fetch();
    $stmt->close();
    return $design_data;
}

// Example for saving a design
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['design_data'])) {
    $user_id = 1;  // Get user ID from session or authentication
    $design_data = $_POST['design_data'];  // Get the design data (JSON, for example)
    save_design($user_id, $design_data);
    echo "Design saved successfully!";
}

// Example for retrieving a design
if (isset($_GET['design_id'])) {
    $design_id = $_GET['design_id'];
    $design_data = get_design($design_id);
    echo $design_data;
}
?>
