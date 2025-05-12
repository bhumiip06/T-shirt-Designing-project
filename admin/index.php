<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include '../php/connection.php';

// Query to get the count of orders
$orderCountQuery = $con->query("SELECT COUNT(*) AS total_orders FROM shopping");
$orderCount = $orderCountQuery->fetch_assoc()['total_orders'];

// Query to get the count of users
$userCountQuery = $con->query("SELECT COUNT(*) AS total_users FROM users");
$userCount = $userCountQuery->fetch_assoc()['total_users'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="index.php" class="active">Dashboard</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="feedback.php">Feedback/Queries</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main">
        <h1>Dashboard</h1>
        <div class="cards">
            <div class="card">
                <div class="card-title">Total Orders</div>
                <div class="card-value"><?= $orderCount ?></div>
            </div>
            <div class="card">
                <div class="card-title">Total Users</div>
                <div class="card-value"><?= $userCount ?></div>
            </div>
        </div>
    </div>
</body>
</html>
