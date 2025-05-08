const cartIcon = document.querySelector("#cart-icon");
const cart = document.querySelector(".cart");
const cartClose = document.querySelector("#cart-close");
const cartContent = document.querySelector(".cart-content");
const buyNowButton = document.querySelector(".btn-buy");
const cartItemCountBadge = document.querySelector(".cart-item-count");

// Show or hide the cart
cartIcon.addEventListener("click", () => cart.classList.add("active"));
cartClose.addEventListener("click", () => cart.classList.remove("active"));

// Add product to cart
document.querySelectorAll(".add-cart").forEach(button => {
    button.addEventListener("click", event => {
        const productBox = event.target.closest(".product-box");
        addToCart(productBox);
        
        // Show popup for adding items
        const popup = document.getElementById('product-added-popup');
        popup.style.display = 'block';
        setTimeout(() => popup.style.display = 'none', 2000);
    });
});

// Add item to the cart
const addToCart = (productBox) => {
    const productImgsrc = productBox.querySelector("img").src;
    const productTitle = productBox.querySelector(".product-title").textContent;
    const productPrice = productBox.querySelector(".price").textContent;

    // Check if product is already in the cart
    const cartItems = cartContent.querySelectorAll(".cart-product-title");
    for (let item of cartItems) {
        if (item.textContent.trim() === productTitle.trim()) {
            alert("This item is already in the cart.");
            return;
        }
    }

    // Create new cart box
    const cartBox = document.createElement("div");
    cartBox.classList.add("cart-box");
    cartBox.innerHTML = `
        <img src="${productImgsrc}" class="cart-img">
        <div class="cart-detail">
            <h2 class="cart-product-title">${productTitle}</h2>
            <span class="cart-price">${productPrice}</span>
            <div class="cart-quantity">
                <button id="decrement">-</button>
                <span class="number">1</span>
                <button id="increment">+</button>
            </div>
        </div>
        <i class="ri-delete-bin-line cart-remove"></i>
    `;
    cartContent.appendChild(cartBox);

    // Setup remove item from cart
    cartBox.querySelector(".cart-remove").addEventListener("click", () => {
        cartBox.remove();
        updateCartCount();
        updateTotalPrice();
        saveCartToLocalStorage();
    });

    // Update quantity in cart
    cartBox.querySelector(".cart-quantity").addEventListener("click", event => {
        const numberElement = cartBox.querySelector(".number");
        const decrementButton = cartBox.querySelector("#decrement");
        let quantity = parseInt(numberElement.textContent);

        if (event.target.id === "decrement" && quantity > 1) {
            quantity--;
            if (quantity === 1) decrementButton.style.color = "#999";
        } else if (event.target.id === "increment") {
            quantity++;
            decrementButton.style.color = "#333";
        }

        numberElement.textContent = quantity;
        updateTotalPrice();
        saveCartToLocalStorage();
    });

    // Update UI after adding to cart
    updateCartCount();
    updateTotalPrice();
    saveCartToLocalStorage();
};

// Update the total price
const updateTotalPrice = () => {
    const updateTotalPriceElement = document.querySelector(".total-price");
    const cartBoxes = cartContent.querySelectorAll(".cart-box");
    let total = 0;

    cartBoxes.forEach(cartBox => {
        const priceElement = cartBox.querySelector(".cart-price");
        const quantityElement = cartBox.querySelector(".number");
        const price = priceElement.textContent.replace("₹", "");
        const quantity = quantityElement.textContent;
        total += parseFloat(price) * parseInt(quantity);
    });

    updateTotalPriceElement.textContent = `₹${total}`;
};

// Update cart item count
const updateCartCount = () => {
    const cartItemCount = cartContent.querySelectorAll(".cart-box").length;

    if (cartItemCount > 0) {
        cartItemCountBadge.style.visibility = "visible";
        cartItemCountBadge.textContent = cartItemCount;
    } else {
        cartItemCountBadge.style.visibility = "hidden";
        cartItemCountBadge.textContent = "";
    }
};

// Checkout functionality
buyNowButton.addEventListener("click", () => {
    const cartBoxes = cartContent.querySelectorAll(".cart-box");

    if (cartBoxes.length === 0) {
        alert("Your cart is empty. Please add items to your cart before buying.");
        return;
    }

    const cartData = [];
    cartBoxes.forEach(cartBox => {
        const title = cartBox.querySelector(".cart-product-title").textContent;
        const price = cartBox.querySelector(".cart-price").textContent;
        const quantity = cartBox.querySelector(".number").textContent;
        const img = cartBox.querySelector(".cart-img").src;
        cartData.push({ title, price, quantity, img });
    });

    localStorage.setItem("checkoutCart", JSON.stringify(cartData));

    // Clear cart and reset cart item count
    cartBoxes.forEach(cartBox => cartBox.remove());
    updateCartCount();
    const updateTotalPriceElement = document.querySelector(".total-price");
    updateTotalPriceElement.textContent = "₹0";

    // Redirect to address page
    window.location.href = "address.html";
});

// Sync cart to localStorage
function saveCartToLocalStorage() {
    const cartBoxes = document.querySelectorAll(".cart-box");
    const cartItems = [];

    cartBoxes.forEach(cartBox => {
        const title = cartBox.querySelector(".cart-product-title").textContent.trim();
        const price = cartBox.querySelector(".cart-price").textContent.trim();
        const quantity = cartBox.querySelector(".number").textContent.trim();
        const img = cartBox.querySelector(".cart-img").src;

        cartItems.push({ title, price, quantity, img });
    });

    if (cartItems.length > 0) {
        localStorage.setItem("checkoutCart", JSON.stringify(cartItems));
    } else {
        localStorage.removeItem("checkoutCart");
    }
}

// On page load: Restore cart data from localStorage
window.addEventListener('DOMContentLoaded', () => {
    const savedCart = JSON.parse(localStorage.getItem('checkoutCart')) || [];
    if (savedCart.length > 0 && cartContent.children.length === 0) {
        savedCart.forEach(item => {
            const cartBox = document.createElement("div");
            cartBox.classList.add("cart-box");
            cartBox.innerHTML = `
                <img src="${item.img}" class="cart-img">
                <div class="cart-detail">
                    <h2 class="cart-product-title">${item.title}</h2>
                    <span class="cart-price">${item.price}</span>
                    <div class="cart-quantity">
                        <button id="decrement">-</button>
                        <span class="number">${item.quantity}</span>
                        <button id="increment">+</button>
                    </div>
                </div>
                <i class="ri-delete-bin-line cart-remove"></i>
            `;
            cartContent.appendChild(cartBox);

            // Setup listeners for restored items
            cartBox.querySelector(".cart-remove").addEventListener("click", () => {
                cartBox.remove();
                updateCartCount();
                updateTotalPrice();
                saveCartToLocalStorage();
            });

            cartBox.querySelector(".cart-quantity").addEventListener("click", event => {
                const numberElement = cartBox.querySelector(".number");
                const decrementButton = cartBox.querySelector("#decrement");
                let quantity = parseInt(numberElement.textContent);

                if (event.target.id === "decrement" && quantity > 1) {
                    quantity--;
                    if (quantity === 1) decrementButton.style.color = "#999";
                } else if (event.target.id === "increment") {
                    quantity++;
                    decrementButton.style.color = "#333";
                }

                numberElement.textContent = quantity;
                updateTotalPrice();
                saveCartToLocalStorage();
            });
        });

        updateCartCount();
        updateTotalPrice();
    }
});
