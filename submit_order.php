<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

$user_id = $_SESSION['user_id'];
include 'php/connection.php';

$orderData = [];
$cart_items = [];
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['cart_data'])) {
        $error = "Cart data is missing.";
    } else {
        $cart_items = json_decode($_POST['cart_data'], true);

        if (!is_array($cart_items) || empty($cart_items)) {
            $error = "Cart data is invalid or empty.";
        } else {
            $required_fields = ['name', 'phone', 'address', 'city', 'state', 'zip', 'country'];
            foreach ($required_fields as $field) {
                if (empty($_POST[$field])) {
                    $error = "Missing user data: $field";
                    break;
                }
            }

            if (!$error) {
                // Sanitize and escape input
                $name = $con->real_escape_string(trim($_POST['name']));
                $phone = $con->real_escape_string(trim($_POST['phone']));
                $email = $con->real_escape_string(trim($_POST['email'] ?? ''));
                $address = $con->real_escape_string(trim($_POST['address']));
                $city = $con->real_escape_string(trim($_POST['city']));
                $state = $con->real_escape_string(trim($_POST['state']));
                $zip = $con->real_escape_string(trim($_POST['zip']));
                $country = $con->real_escape_string(trim($_POST['country']));
                $notes = $con->real_escape_string(trim($_POST['notes'] ?? ''));

                $total_price = 0;
                $order_date = date('Y-m-d');

                foreach ($cart_items as $item) {
                    if (isset($item['price'], $item['quantity'], $item['design_id'], $item['size'])) {
                        $design_id = intval($item['design_id']);
                        $quantity = intval($item['quantity']);
                        $size = $con->real_escape_string(trim($item['size']));
                        $item_total_price = floatval($item['price']) * $quantity;
                        $total_price += $item_total_price;

                        $stmt = $con->prepare("INSERT INTO shopping (
                            user_id, design_id, name, phone, email, address, city, state, zip, country, notes, quantity, size, total_price, order_date
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                        if ($stmt) {
                            $stmt->bind_param(
                                "iisssssssssisds",
                                $user_id,
                                $design_id,
                                $name,
                                $phone,
                                $email,
                                $address,
                                $city,
                                $state,
                                $zip,
                                $country,
                                $notes,
                                $quantity,
                                $size,
                                $item_total_price,
                                $order_date
                            );

                            if (!$stmt->execute()) {
                                $error = "Database insert error: " . $stmt->error;
                                break;
                            }
                            $stmt->close();
                        } else {
                            $error = "Database prepare failed: " . $con->error;
                            break;
                        }
                    } else {
                        $error = "Each cart item must include price, quantity, design ID, and size.";
                        break;
                    }
                }

                if (!$error) {
                    $orderData = [
                        "name" => $name,
                        "phone" => $phone,
                        "address" => $address,
                        "city" => $city,
                        "total_price" => $total_price
                    ];
                }
            }
        }
    }
    $con->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Order Summary</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background: #f4f4f4;
    }

    .order-summary {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      margin: 20px auto;
      max-width: 700px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .order-summary h3 {
      margin-top: 0;
    }

    .tshirt-item {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 20px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 15px;
    }

    .tshirt-img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    .item-details {
      flex: 1;
    }

    .item-details p {
      margin: 4px 0;
    }

    .total-price {
      font-weight: bold;
      font-size: 18px;
      margin-top: 10px;
    }

    .error {
      color: red;
      text-align: center;
      margin-bottom: 20px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<?php if (!empty($error)): ?>
  <div class="error"><?= htmlspecialchars($error) ?></div>
<?php elseif (!empty($orderData)): ?>
  <div class="order-summary">
    <h3>Customer Details</h3>
    <p><strong>Name:</strong> <?= htmlspecialchars($orderData['name']) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($orderData['address']) ?></p>
    <p><strong>City:</strong> <?= htmlspecialchars($orderData['city']) ?></p>
    <p><strong>Contact:</strong> <?= htmlspecialchars($orderData['phone']) ?></p>
  </div>

  <div class="order-summary">
    <h3>Ordered Items</h3>
    <?php foreach ($cart_items as $item): ?>
      <div class="tshirt-item">
        <img src="<?= htmlspecialchars($item['img']) ?>" alt="T-Shirt" class="tshirt-img"/>
        <div class="item-details">
          <p><strong>Name:</strong> <?= htmlspecialchars($item['title'] ?? 'N/A') ?></p>
          <p><strong>Size:</strong> <?= htmlspecialchars($item['size'] ?? 'N/A') ?></p>
          <p><strong>Quantity:</strong> <?= htmlspecialchars($item['quantity']) ?></p>
          <p><strong>Price:</strong> ₹<?= number_format($item['price'], 2) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
    <p class="total-price">Total Price: ₹<?= number_format($orderData['total_price'], 2) ?></p>
  </div>
<?php endif; ?>

</body>
</html>
