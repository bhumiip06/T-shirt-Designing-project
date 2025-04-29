<?php
session_start();  // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, return a JSON response indicating the user is not logged in
    echo json_encode(['loggedIn' => false]);
    exit();
}

// If the user is logged in, return a JSON response indicating the user is logged in
// echo json_encode(['loggedIn' => true, 'username' => $_SESSION['username']]);
header('Location: ../design-canvas.php');
?>
