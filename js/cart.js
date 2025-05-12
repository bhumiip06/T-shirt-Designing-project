// Select cart elements
const cartIcon = document.querySelector("#cart-icon");
const cart = document.querySelector(".cart");
const cartClose = document.querySelector("#cart-close");
const cartContent = document.querySelector(".cart-content");
const buyNowButton = document.querySelector(".btn-buy");
const cartItemCountBadge = document.querySelector(".cart-item-count");

// Toggle cart visibility
cartIcon.addEventListener("click", () => cart.classList.add("active"));
cartClose.addEventListener("click", () => cart.classList.remove("active"));

// Add product to cart
document.querySelectorAll(".add-cart").forEach(button => {
    button.addEventListener("click", event => {
        const productBox = event.target.closest(".product-box");
        addToCart(productBox);

        // Show confirmation popup
        const popup = document.getElementById('product-added-popup');
        popup.style.display = 'block';
        setTimeout(() => popup.style.display = 'none', 2000);
    });
});

// Add item to cart
const addToCart = (productBox) => {
    const productImgsrc = productBox.querySelector("img").src;
    const productTitle = productBox.querySelector(".product-title").textContent;
    const productPrice = productBox.querySelector(".price").textContent;
    const designId = productBox.dataset.designId || "123";
    const sizeEl = productBox.querySelector(".product-size");
    const size = sizeEl ? sizeEl.value : "N/A";

    // Avoid duplicates
    const cartItems = cartContent.querySelectorAll(".cart-product-title");
    for (let item of cartItems) {
        if (item.textContent.trim() === productTitle.trim()) {
            alert("This item is already in the cart.");
            return;
        }
    }

    const cartBox = document.createElement("div");
    cartBox.classList.add("cart-box");
    cartBox.setAttribute("data-design-id", designId);
    cartBox.setAttribute("data-size", size);

    cartBox.innerHTML = `
        <img src="${productImgsrc}" class="cart-img">
        <div class="cart-detail">
            <h2 class="cart-product-title">${productTitle}</h2>
            <span class="cart-price">${productPrice}</span>
            <div class="cart-quantity">
                <button class="decrement">-</button>
                <span class="number">1</span>
                <button class="increment">+</button>
            </div>
            <div class="cart-size">
                <span>Size: ${size}</span>
            </div>
        </div>
        <i class="ri-delete-bin-line cart-remove"></i>
    `;
    cartContent.appendChild(cartBox);

    setupCartBoxEvents(cartBox);
    updateCartCount();
    updateTotalPrice();
    saveCartToLocalStorage(); // save after everything is added
};


// Quantity change & remove listeners
const setupCartBoxEvents = (cartBox) => {
    cartBox.querySelector(".cart-remove").addEventListener("click", () => {
        cartBox.remove();
        updateCartCount();
        updateTotalPrice();
        saveCartToLocalStorage();
    });

    cartBox.querySelector(".cart-quantity").addEventListener("click", event => {
        const numberElement = cartBox.querySelector(".number");
        let quantity = parseInt(numberElement.textContent);

        if (event.target.classList.contains("decrement") && quantity > 1) {
            quantity--;
        } else if (event.target.classList.contains("increment")) {
            quantity++;
        }

        numberElement.textContent = quantity;
        updateTotalPrice();
        saveCartToLocalStorage();
    });
};

// Update total price
const updateTotalPrice = () => {
    const updateTotalPriceElement = document.querySelector(".total-price");
    const cartBoxes = cartContent.querySelectorAll(".cart-box");
    let total = 0;

    cartBoxes.forEach(cartBox => {
        const price = parseFloat(cartBox.querySelector(".cart-price").textContent.replace("₹", ""));
        const quantity = parseInt(cartBox.querySelector(".number").textContent);
        total += price * quantity;
    });

    updateTotalPriceElement.textContent = `₹${total.toFixed(2)}`;
};

// Update cart item count badge
const updateCartCount = () => {
    const cartCount = cartContent.querySelectorAll(".cart-box").length;
    cartItemCountBadge.textContent = cartCount;
    cartItemCountBadge.style.visibility = cartCount > 0 ? "visible" : "hidden";
};

// Buy now button handler
buyNowButton.addEventListener("click", async () => {
    const cartBoxes = cartContent.querySelectorAll(".cart-box");

    if (cartBoxes.length === 0) {
        alert("Your cart is empty. Please add items to your cart before buying.");
        return;
    }

    // Prepare cart data in the correct format
    const cart_data = Array.from(cartBoxes).map(cartBox => {
        return {
            design_id: cartBox.getAttribute("data-design-id") || "N/A",
            size: cartBox.getAttribute("data-size") || "N/A",
            quantity: parseInt(cartBox.querySelector(".number").textContent),
            price: parseFloat(cartBox.querySelector(".cart-price").textContent.replace("₹", "")),
            title: cartBox.querySelector(".cart-product-title").textContent.trim()
        };
    });

    
        localStorage.setItem("cart-data",JSON.stringify(cart_data));
    
       window.location.href="address.html";

        
});



// Save cart to local storage
function saveCartToLocalStorage() {
    const cartBoxes = cartContent.querySelectorAll(".cart-box");
    const cartItems = [];

    cartBoxes.forEach(cartBox => {
        const title = cartBox.querySelector(".cart-product-title").textContent.trim();
        const price = cartBox.querySelector(".cart-price").textContent.trim();
        const quantity = cartBox.querySelector(".number").textContent.trim();
        const size = cartBox.getAttribute("data-size") || "N/A";
        const img = cartBox.querySelector(".cart-img").src;
        const design_id = cartBox.getAttribute("data-design-id") || "N/A";

        cartItems.push({ title, price, quantity, size, img, design_id });
    });

    localStorage.setItem("checkoutCart", JSON.stringify(cartItems));
}

// Restore cart on page load
window.addEventListener('DOMContentLoaded', () => {
    const savedCart = JSON.parse(localStorage.getItem('checkoutCart')) || [];

    if (savedCart.length > 0 && cartContent.children.length === 0) {
        savedCart.forEach(item => {
            const cartBox = document.createElement("div");
            cartBox.classList.add("cart-box");
            cartBox.setAttribute("data-design-id", item.design_id || "N/A");
            cartBox.setAttribute("data-size", item.size || "N/A");

            cartBox.innerHTML = `
                <img src="${item.img}" class="cart-img">
                <div class="cart-detail">
                    <h2 class="cart-product-title">${item.title}</h2>
                    <span class="cart-price">${item.price}</span>
                    <div class="cart-quantity">
                        <button class="decrement">-</button>
                        <span class="number">${item.quantity || 1}</span>
                        <button class="increment">+</button>
                    </div>
                    <div class="cart-size">
                        <span>Size: ${item.size || 'N/A'}</span>
                    </div>
                </div>
                <i class="ri-delete-bin-line cart-remove"></i>
            `;
            cartContent.appendChild(cartBox);
            setupCartBoxEvents(cartBox);
        });

        updateCartCount();
        updateTotalPrice();
    }
});
