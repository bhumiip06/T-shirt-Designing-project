<?php
 session_start(); // Start the session to access session variables
 // TEMP DEBUG
 file_put_contents('debug_session.txt', print_r($_SESSION, true));
 if (!isset($_SESSION['user_id'])) {
     http_response_code(401);  // Unauthorized
     echo "Unauthorized: User not logged in.";
     exit;
 }
 include 'connection.php';
 
 // Get user ID from session
 if (!isset($_SESSION['user_id'])) {
     http_response_code(401);
     echo "Unauthorized: User not logged in.";
     exit;
 }
 
 $user_id = $_SESSION['user_id'];
 
 // Get the image data from the frontend
 $data = json_decode(file_get_contents("php://input"), true);
 $imageData = $data['image'];
 
 // Clean and decode the base64 image data
 $imageData = str_replace('data:image/png;base64,', '', $imageData);
 $imageData = str_replace(' ', '+', $imageData);
 $image = base64_decode($imageData);
 
 // Save image to server
 $filename = '../uploads/design_' . time() . '.png';
 file_put_contents($filename, $image);
 
 // Generate the full image URL
 $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
 $host = $_SERVER['HTTP_HOST'];
 $imageUrl = "$protocol://$host/$filename";
 
 // Save the image URL and user_id to the database
 if ($con->connect_error) {
     die("Connection failed: " . $con->connect_error);
 }
 
 $stmt = $con->prepare("INSERT INTO designs (design_data, user_id) VALUES (?, ?)");
 $stmt->bind_param("si", $imageUrl, $user_id);
 $stmt->execute();
 $stmt->close();
 $con->close();
 
 // Return the image URL to the frontend
 echo $imageUrl;
 ?>