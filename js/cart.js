const cartIcon = document.querySelector("#cart-icon"); 
const cart = document.querySelector(".cart");
const cartClose = document.querySelector("#cart-close");
cartIcon.addEventListener("click", () => cart.classList.add("active"));
cartClose.addEventListener("click", () => cart.classList.remove("active"));

const addCartButtons = document.querySelectorAll(".add-cart");
addCartButtons.forEach(button => {
    button.addEventListener("click", event => {
        const productBox = event.target.closest(".product-box");
        addToCart(productBox);
    })
});

// Popup for adding items to the cart
document.querySelectorAll('.add-cart').forEach(item => {
    item.addEventListener('click', function() {
      const popup = document.getElementById('product-added-popup');
      popup.style.display = 'block';
      setTimeout(() => {
        popup.style.display = 'none';
      }, 2000);
    });
});

const cartContent = document.querySelector(".cart-content");

// Add product to cart
const addToCart = productBox => {
    const productImgsrc = productBox.querySelector("img").src;
    const productTitle = productBox.querySelector(".product-title").textContent;
    const productPrice = productBox.querySelector(".price").textContent;

    const cartItems = cartContent.querySelectorAll(".cart-product-title");
    for (let item of cartItems) {
        if (item.textContent.trim() === productTitle.trim()) {
            alert("This item is already in the cart.");
            return;
        }
    }

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

    // Remove item from cart
    cartBox.querySelector(".cart-remove").addEventListener("click", () => {
        cartBox.remove();
        updateCartCount(-1);
        updateTotalPrice();
    });

    // Update quantity in cart
    cartBox.querySelector(".cart-quantity").addEventListener("click", event => {
        const numberElement = cartBox.querySelector(".number");
        const decrementButton = cartBox.querySelector("#decrement");
        let quantity = parseInt(numberElement.textContent);

        if (event.target.id === "decrement" && quantity > 1) {
            quantity--;
            if (quantity === 1) {
                decrementButton.style.color = "#999";
            }
        } else if (event.target.id === "increment") {
            quantity++;
            decrementButton.style.color = "#333";
        }

        numberElement.textContent = quantity;
        updateTotalPrice();
    });

    updateCartCount(1);
    updateTotalPrice();
};

// Update total price
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

// Update the number of items in the cart
let cartItemCount = 0;
const updateCartCount = change => {
    const cartItemCountBadge = document.querySelector(".cart-item-count");
    cartItemCount += change;
    if (cartItemCount > 0) {
        cartItemCountBadge.style.visibility = "visible";
        cartItemCountBadge.textContent = cartItemCount;
    } else {
        cartItemCountBadge.style.visibility = "hidden";
        cartItemCountBadge.textContent = "";
    }
};

// Checkout functionality
const buyNowButton = document.querySelector(".btn-buy");

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
    cartItemCount = 0;
    const cartItemCountBadge = document.querySelector(".cart-item-count");
    cartItemCountBadge.textContent = "";
    cartItemCountBadge.style.visibility = "hidden";

    const updateTotalPriceElement = document.querySelector(".total-price");
    updateTotalPriceElement.textContent = "₹0";

    // Redirect to address page
    window.location.href = "adress.html";
});

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

            // Setup listeners
            cartBox.querySelector(".cart-remove").addEventListener("click", () => {
                cartBox.remove();
                updateCartCount(-1);
                updateTotalPrice();
            });

            cartBox.querySelector(".cart-quantity").addEventListener("click", event => {
                const numberElement = cartBox.querySelector(".number");
                const decrementButton = cartBox.querySelector("#decrement");
                let quantity = parseInt(numberElement.textContent);

                if (event.target.id === "decrement" && quantity > 1) {
                    quantity--;
                    if (quantity === 1) {
                        decrementButton.style.color = "#999";
                    }
                } else if (event.target.id === "increment") {
                    quantity++;
                    decrementButton.style.color = "#333";
                }

                numberElement.textContent = quantity;
                updateTotalPrice();
            });

            updateCartCount(1);
        });

        updateTotalPrice();
    }
});
