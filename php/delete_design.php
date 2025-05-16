<?php
// Include database connection
include 'connection.php';

// Check if the design_id is set and not empty
if (isset($_POST['design_id']) && !empty($_POST['design_id'])) {
    $design_id = $_POST['design_id'];

    // Prepare the delete query
    $sql = "DELETE FROM designs WHERE design_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $design_id);

    if ($stmt->execute()) {
        // If delete is successful
        echo json_encode(['success' => true]);
    } else {
        // If delete fails
        echo json_encode(['success' => false, 'error' => 'Design deletion failed']);
    }
} else {
    // If design_id is not set or is empty
    echo json_encode(['success' => false, 'error' => 'Design ID not provided']);
}
?>
