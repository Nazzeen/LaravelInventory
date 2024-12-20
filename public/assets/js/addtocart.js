

// Initialize cart items and count
let cart = [];
let cartCount = 0;

document.addEventListener('DOMContentLoaded', function() {
  // Get references to elements
  const addToCartButton = document.querySelector('.add-to-cart-button');
  const cartCountElement = document.createElement('div');
  cartCountElement.id = 'cartCount';
  cartCountElement.textContent = cartCount;
  document.getElementById('cartIcon').appendChild(cartCountElement);

  // Handle Add to Cart button click
  addToCartButton.addEventListener('click', function() {
    const productName = document.getElementById('product-name').textContent;
    const productPrice = document.getElementById('product-price').textContent;
    const quantity = parseInt(document.getElementById('quantity').value, 10);

    // Add item to cart
    cart.push({ name: productName, price: productPrice, quantity: quantity });
    cartCount += quantity;

    // Update cart count
    cartCountElement.textContent = cartCount;
  });

  // Handle Cart Icon click
  document.getElementById('cartIcon').addEventListener('click', function() {
    localStorage.setItem('cart', JSON.stringify(cart));
    window.location.href = 'cart.html'; // Redirect to cart page
  });
});
