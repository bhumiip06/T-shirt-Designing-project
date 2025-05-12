<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include '../php/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order_id"], $_POST['status'])) {
    $id = $_POST['order_id'];
    $status = $_POST['status'];
    $delivery_date = $_POST['delivery_date'];
    $stmt = $con->prepare("UPDATE shopping SET status=?, delivery_date=? Where id=?");
    $stmt->bind_param("ssi", $status, $delivery_date, $id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_GET['user_id'])) {
    $userId = intval($_GET['user_id']);
    $stmt = $con->prepare("SELECT s.*, d.design_data 
                           FROM shopping s
                           JOIN designs d ON s.design_id = d.design_id 
                           WHERE s.user_id = ?
                           ORDER BY s.order_date DESC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    $result = $con->query("SELECT s.*, d.design_data 
                           FROM shopping s
                           JOIN designs d ON s.design_id = d.design_id 
                           ORDER BY s.order_date DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="orders.php" class="active">Orders</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="feedback.php">Feedback/Queries</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main">
        <?php if (isset($_GET['user_id'])): ?>
            <p>
                Viewing orders for user ID: <?= htmlspecialchars($_GET['user_id']) ?>
                | <a href="orders.php">View All Orders</a>
            </p>
        <?php endif; ?>
        <h1>Orders</h1>
        <table border="1" cellpadding="10" cellspacing="0" style="background: white; width:100%; border-collapse: collapse;">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Design</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Delivery Date</th>
                <th>Update</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td style="text-align: center;">
                        <a href="<?= htmlspecialchars($row['design_data']) ?>" target="_blank">
                            <img src="<?= htmlspecialchars($row['design_data']) ?>" alt="Design" style="height: 100px; border-radius: 4px;">
                        </a>
                    </td>
                    <td><?= htmlspecialchars($row['size']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td>₹<?= number_format($row['total_price'], 2) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td><?= $row['order_date'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td><?= $row['delivery_date'] ?: 'N/A' ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                            <select name="status">
                                <option value="Pending" <?= $row['status'] == "Pending" ? "selected" : "" ?>>Pending</option>
                                <option value="Processing" <?= $row['status'] == "Processing" ? "selected" : "" ?>>Processing</option>
                                <option value="Shipped" <?= $row['status'] == "Shipped" ? "selected" : "" ?>>Shipped</option>
                                <option value="Delivered" <?= $row['status'] == "Delivered" ? "selected" : "" ?>>Delivered</option>
                                <option value="Cancelled" <?= $row['status'] == "Cancelled" ? "selected" : "" ?>>Cancelled</option>
                            </select>
                            <input type="date" name="delivery_date" value="<?= $row['delivery_date'] ?: '' ?>" />
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
