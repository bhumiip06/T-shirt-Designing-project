<?php
include '../php/connection.php';

$sql = "SELECT message_id, sender_name, sender_email, message_content, status, message_type, created_at FROM contact_messages ORDER BY created_at DESC";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Contact Messages</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="feedback.php" class="active">Feedback/Queries</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main">

        <div class="container">
            <h1>Contact Messages</h1>

            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Message Type</th>
                            <th>Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['message_id']; ?></td>
                                <td><?php echo htmlspecialchars($row['sender_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['sender_email']); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($row['message_content'])); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                <td><?php echo htmlspecialchars($row['message_type']); ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No messages found.</p>
            <?php endif; ?>

        </div>
    </div>

</body>

</html>

<?php
$con->close();
?>