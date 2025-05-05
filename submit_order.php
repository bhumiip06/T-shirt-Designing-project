<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  // Handle the case where the user is not logged in (e.g., redirect to login)
  header('Location: login.html');
  exit();
}

// Now, you can safely use $_SESSION['user_id'] for the user_id in your query
$user_id = $_SESSION['user_id'];  // Get the user ID from the session
include 'php/connection.php';

$design_id = 1; // Replace with actual selected design ID
$total_price = 399.99; // Replace with actual calculated price
$order_date = date('2025-05-04'); // Today’s date

// Get and sanitize POST data
$name = $con->real_escape_string($_POST['name']);
$phone = $con->real_escape_string($_POST['phone']);
$email = $con->real_escape_string($_POST['email']);
$address = $con->real_escape_string($_POST['address']);
$city = $con->real_escape_string($_POST['city']);
$state = $con->real_escape_string($_POST['state']);
$zip = $con->real_escape_string($_POST['zip']);
$country = $con->real_escape_string($_POST['country']);
$notes = $con->real_escape_string($_POST['notes']);

// Insert into database
$sql = "INSERT INTO shopping (
  user_id, design_id, name, phone, email, address, city, state, zip, country, notes, total_price, order_date
) VALUES (
  $user_id, $design_id, '$name', '$phone', '$email', '$address', '$city', '$state', '$zip', '$country', '$notes', $total_price, '$order_date'
)";
if ($con->query($sql) === TRUE) {
  echo "<script>
    alert('Order submitted successfully!');
    window.location.href = 'confirm.html';
  </script>";
} else {
  echo "Error: " . $sql . "<br>" . $con->error;
}

$con->close();
?>
