<?php
include 'connection.php';

$design_id = intval($_GET['design_id']);
$result = $conn->query("SELECT * FROM designs WHERE design_id = $design_id");
$design = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Cart</title>
</head>
<body>
    <h2>Your T-shirt Design</h2>
    <img src="<?php echo $design['design_data']; ?>" style="max-width: 400px;" />
    <form action="checkout.php" method="post">
        <input type="hidden" name="design_id" value="<?php echo $design_id; ?>">
        <button type="submit">Buy Now</button>
    </form>
</body>
</html>
