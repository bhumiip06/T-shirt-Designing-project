<?php
session_start();
// var_dump($_SESSION);  // Check if the session data is present
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom T-shirt Design | T-shirt Design Lab </title>

    <!-- import Fabric.js library for canvas editing -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js" integrity="sha512-CeIsOAsgJnmevfCi2C7Zsyy6bQKi43utIjdA87Q0ZY84oDqnI0uwfM9+bKiIkI75lUeI00WG/+uJzOmuHlesMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fontfaceobserver/2.1.0/fontfaceobserver.standalone.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>


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

    <!-- Design Area -->
    <div class="design-container">
        <!-- Clipart Section  displays selectable clipart-->
        <div class="clipart-section">
            <h3>Clipart Gallery</h3>
            <div class="clipart-gallery">
                <!-- cliparts filled in section using javascript -->
            </div>
        </div>

        <!-- Design workspace -->
        <div class="tshirt">
            <canvas id="tshirt-canvas" width="500" height="600"></canvas>
        </div>

        <!-- controls: text, font, image upload, actions -->
        <div class="controls-container">

            <!-- text insertion -->
            <img src="images/file.png" id="addText" style="width: 40px;">

            <!-- color picker for text -->
            <div class="class-picker-group">
                <label for="textColor">
                    <i class="fas fa-palette"></i> Color
                </label>
                <input type="color" id="textColor" value="#000000">
            </div>

            <!-- upload image input -->
            <input type="file" name="imageupload" id="imageupload" accept="image/*">

            <!-- font selection  -->
            <label for="fontSelect">Choose Font: </label>
            <select name="font" id="fontSelect">
                <!-- <option value="Arial">Arial</option> -->
                <!-- <option value="Bebas Neue">Bebas Neue</option> -->
                <option value="Lobster">Lobster</option>
                <!-- <option value="Montserrat">Montserrat</option> -->
                <option value="Pacifico">Pacifico</option>
                <!-- <option value="Playfair">Playfair</option> -->
                <option value="Righteous">Righteous</option>
                <!-- <option value="Roboto Slab">Roboto Slab</option> -->
                <option value="Anton">Anton</option>
                <!-- <option value="Times New Roman">Times New Roman</option> -->
            </select>

            <!-- font size selection  -->
            <label for="fontSize">Choose Font Size: </label>
            <select name="" id="fontSize">
                <option value="15">15px</option>
                <option value="18">18px</option>
                <option value="20">20px</option>
                <option value="25">25px</option>
                <option value="28">28px</option>
                <option value="30">30px</option>
                <option value="32">32px</option>
                <option value="38">38px</option>
                <option value="40">40px</option>
                <option value="50">50px</option>
                <option value="54">54px</option>
                <option value="58">58px</option>
            </select>

            <!-- font style selection  -->
            <label for="fontStyle"> Font Style: </label>
            <select name="" id="fontStyle">
                <option value="Bold">Bold</option>
                <option value="italic">Italic</option>
            </select>

            <!-- delete button (appears when an object is selected) -->
            <div id="delete-icon"><i class="fa-solid fa-trash"></i></div>

            <!-- Clear all canvas content -->
            <button id="clearDesign">Clear</button>

            <!-- button for downloading design as png -->
            <button id="downloadDesign">Download</button>
            <!-- <button id="buy-btn">Buy Now</button> -->
            <button id="buy-btn" onclick="saveDesign(true)">Buy Now</button>

            <button onclick="saveDesign()">Save</button>
        </div>
    </div>
    <script src="js/design.js"></script>
    <script src="js/cart.js"></script>
</body>

</html>