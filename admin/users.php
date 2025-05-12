<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include '../php/connection.php';

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $userId = $_POST['delete_user_id'];
    $stmt = $con->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}

// Fetch users and their orders grouped by user_id and order_date
$result = $con->query("
    SELECT 
        u.user_id,
        u.user_name,
        u.user_email,
        s.phone,
        s.address,
        s.order_date,
        COUNT(*) AS order_count,
        GROUP_CONCAT(d.design_name SEPARATOR ', ') AS products_ordered
    FROM users u
    INNER JOIN shopping s ON u.user_id = s.user_id
    INNER JOIN designs d ON s.design_id = d.design_id
    GROUP BY u.user_id, s.order_date
    ORDER BY s.order_date DESC;
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="users.php" class="active">Users</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main">
        <h1>Manage Users</h1>
        <table border="1" cellpadding="10" cellspacing="0" style="background: white; width:100%;">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Order Date</th>
                <th>Order Count</th>
                <th>Products Ordered</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['user_id'] ?></td>
                    <td>
                        <a href="orders.php?user_id=<?= $row['user_id'] ?>">
                            <?= htmlspecialchars($row['user_name']) ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars($row['user_email']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td><?= htmlspecialchars($row['order_date']) ?></td>
                    <td><?= $row['order_count'] ?></td>
                    <td><?= htmlspecialchars($row['products_ordered']) ?></td>

                    <td>
                        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            <input type="hidden" name="delete_user_id" value="<?= $row['user_id'] ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>
