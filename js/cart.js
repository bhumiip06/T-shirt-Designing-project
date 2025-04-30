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

//popup 
document.querySelectorAll('.add-cart').forEach(item => {
    item.addEventListener('click', function() {
      // Show the popup
      const popup = document.getElementById('product-added-popup');
      popup.style.display = 'block';
  
      // Hide the popup after 2 seconds
      setTimeout(() => {
        popup.style.display = 'none';
      }, 2000);
    });
  });

const cartContent = document.querySelector(".cart-content");
const addToCart = productBox => {
    const productImgsrc = productBox.querySelector("img").src;
    const productTitle = productBox.querySelector(".product-title").textContent;
    const productPrice = productBox.querySelector(".price").textContent;

    const cartItems = cartContent.querySelectorAll(".cart-product-title");
    for (let item of cartItems) {
        if(item.textContent.trim() === productTitle.trim()) {
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

    cartBox.querySelector(".cart-remove").addEventListener("click", () => {
        cartBox.remove();
        updateCartCount(-1);
        updateTotalPrice();
    });

    cartBox.querySelector(".cart-quantity").addEventListener("click", event => {
        const numberElement = cartBox.querySelector(".number");
        const decrementButton = cartBox.querySelector("#decrement");
        let quantity = parseInt(numberElement.textContent);

        if(event.target.id === "decrement" && quantity > 1) {
            quantity--;
            if(quantity === 1) {
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

const updateTotalPrice = () => {
    const updateTotalPriceElement = document.querySelector(".total-price");
    const cartBoxes = cartContent.querySelectorAll(".cart-box");
let total = 0;
    cartBoxes.forEach(cartBox => {
        const priceElement = cartBox.querySelector(".cart-price");
        const quantityElement = cartBox.querySelector(".number");
        const price = priceElement.textContent.replace("₹","");
        const quantity = quantityElement.textContent;
        total += price * quantity;
    });
    updateTotalPriceElement.textContent = `₹${total}`;
};

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

const buyNowButton = document.querySelector(".btn-buy");
buyNowButton.addEventListener("click", () => {
    const cartBoxes = cartContent.querySelectorAll(".cart-box");
    if (cartBoxes.length === 0) {
        alert("Your cart is empty. Please add items to your cart before buying.");
        return;
    }
    
   /* buyNowButton.addEventListener("click", () => {
        const cartBoxes = cartContent.querySelectorAll(".cart-box");
        if (cartBoxes.length === 0) {
            alert("Your cart is empty. Please add items to your cart before buying.");
            return;
        }
    
        // Optional: save cart items to localStorage if you want to display them on the address page
        const cartData = [];
        cartBoxes.forEach(cartBox => {
            const title = cartBox.querySelector(".cart-product-title").textContent;
            const price = cartBox.querySelector(".cart-price").textContent;
            const quantity = cartBox.querySelector(".number").textContent;
            const img = cartBox.querySelector(".cart-img").src;
            cartData.push({ title, price, quantity, img });
        });
    
        localStorage.setItem("checkoutCart", JSON.stringify(cartData));
    
        // ✅ Redirect only if cart is not empty
        window.location.href = "adress.html";
    });
    
    cartBoxes.forEach(cartBox => cartBox.remove());

    cartItemCount = 0;
    const cartItemCountBadge = document.querySelector(".cart-item-count");
    cartItemCountBadge.textContent = cartItemCount;
    cartItemCountBadge.style.visibility = "hidden";

    const updateTotalPriceElement = document.querySelector(".total-price");
    updateTotalPriceElement.textContent = "₹0";

    alert("Thank you for your purchase!");
});*/

const buyNowButton = document.querySelector(".btn-buy");

buyNowButton.addEventListener("click", () => {
    const cartBoxes = cartContent.querySelectorAll(".cart-box");

    if (cartBoxes.length === 0) {
        alert("Your cart is empty. Please add items to your cart before buying.");
        return;
    }

    // Save cart items to localStorage
    const cartData = [];
    cartBoxes.forEach(cartBox => {
        const title = cartBox.querySelector(".cart-product-title").textContent;
        const price = cartBox.querySelector(".cart-price").textContent;
        const quantity = cartBox.querySelector(".number").textContent;
        const img = cartBox.querySelector(".cart-img").src;
        cartData.push({ title, price, quantity, img });
    });

    localStorage.setItem("checkoutCart", JSON.stringify(cartData));

    // Optional: clean up cart UI
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
});