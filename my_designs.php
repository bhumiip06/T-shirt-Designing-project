<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Include your DB connection file
include 'php/connection.php'; // adjust this path as needed

$user_id = $_SESSION['user_id'];
$sql = "SELECT design_id, design_name, design_data, created_at FROM designs WHERE user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Designs</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fontfaceobserver/2.1.0/fontfaceobserver.standalone.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />


    <!-- font awesome for icons  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/design.css">
    <link rel="stylesheet" href="css/cart.css">

</head>

<body>
    <!--navigation bar with logo and menu links-->
    <nav class="navbar">
        <div class="left">
            <a href="index.html" id="logo">
                <img src="images/Logo.png" alt="Logo">
            </a>
        </div>

        <!-- hamburger menu for mobile -->
        <div class="right">
            <input type="checkbox" id="check">
            <label for="check" class="checkBtn">
                <i class="fa-solid fa-bars"></i>
            </label>
            <ul class="list">
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="welcome-message">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                <?php else: ?>
                    <li><a href="login.html">Login</a></li>
                <?php endif; ?>
                <li><a href="index.html">Home</a></li>
                <li><a href="design-canvas.php">Design Lab</a></li>
                <li><a href="php/logout.php">Logout</a></li>
                <!-- <li><a href="cart.html" id="cart"><i class="fa-solid fa-cart-shopping" style="color: #FFFFFF;"></i></a></li> -->
                <div id="cart-icon">
                    <i class="fa-solid fa-cart-shopping" style="color: #FFFFFF;"></i>
                    <span class="cart-item-count"></span>
                </div>
            </ul>
        </div>
    </nav>
    <div class="cart">
        <h2 class="cart-title">Your Cart</h2>
        <div class="cart-content">
        </div>
        <div class="total">
            <div class="total-title">Total</div>
            <div class="total-price">₹0</div>
        </div>
        <button class="btn-buy">Buy Now</button>
        <i class="fa-solid fa-xmark" id="cart-close"></i>
    </div>
    <div id="product-added-popup" class="popup">Product added to cart!</div>


    <h1 style="text-align:center;">My Saved T-shirt Designs</h1>

    <div class="design-gallery">
        <?php if ($result->num_rows === 0): ?>
            <p style="text-align:center; font-size:larger;">You haven't saved any designs yet.</p>
        <?php endif; ?>

        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-box" data-design-id="<?php echo $row['design_id'];?>">
                <div class="img-box">
                    <img src="<?php echo htmlspecialchars($row['design_data'] ?? 'default_image.jpg'); ?>" alt="T-shirt Design">
                </div>
                <h2 class="product-title"><?php echo htmlspecialchars($row['design_name'] ?? 'unnamed_design'); ?></h2>

                <label for="size">Size:</label>
                <select class="product-size">
                    <option value="S">S</option>
                    <option value="M" selected>M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>

                <div class="price-and-cart">
                    <span class="price">400</span>
                    <i class="fa-solid fa-cart-shopping add-cart" style="color: #FFFFFF;"></i>
                </div>

                <!-- Corrected Delete Button with null check -->
                <form method="POST" action="delete_design.php">
                    <?php if (isset($row['design_id'])): ?>
                        <input type="hidden" name="design_id" value="<?php echo htmlspecialchars($row['design_id']); ?>">
                        <button type="submit" class="delete-btn">Delete</button>
                    <?php else: ?>
                        <!-- Optionally display a message or skip the button if design_id is not available -->
                        <span class="no-id-message">Design ID not available</span>
                    <?php endif; ?>
                </form>
            </div>
        <?php endwhile; ?>
    </div>

    <script src="js/cart.js"></script>
    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const designId = this.closest('form').querySelector('input[name="design_id"]').value;

                fetch('delete_design.php', {
                        method: 'POST',
                        body: new URLSearchParams({
                            design_id: designId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // If successful, remove the design element from the page
                            this.closest('.product-box').remove();
                            alert('Design deleted successfully!');
                        } else {
                            alert('Error deleting design: ' + data.error);
                        }
                    });
            });
        });
    </script>
</body>

</html>