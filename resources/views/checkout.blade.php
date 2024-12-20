<!DOCTYPE html>
<html>
<head>
    <title>Preview Checkout - Egz Grocery</title>
    <link rel="stylesheet" href="{{ asset('assets/css/previewCheckOut.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="items.js"></script>
</head>
<body>

    <section class="intro-section">
        <p id="intro1">Free Shipping For All Egz family</p>
        <div id="intro2">
            <div class="logo-container">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/LOGOCOMP.png') }}" alt="Logo" class="logo">
                </a>
            </div>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search items..." oninput="searchItems()">
                <button class="search-button"><i class="fas fa-search"></i></button>
                <ul id="searchResults" class="search-results"></ul>
              </div>
            <div class="profile-cart">
                @if(Auth::check())
                    <span class="username">{{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}" id="logoutIcon"><i class="fas fa-sign-out-alt"></i></a>
                @else
                    <a href="{{ route('login') }}" id="profileIcon"><i class="fas fa-user"></i></a>
                @endif

                <!-- Cart icon always available -->
                <a href="{{ route('checkout') }}" id="cartIcon">
                    <i class="fas fa-shopping-cart"></i>
                </a>
                <span id="cartCount" class="cart-count">0</span> <!-- This dynamically updates via JavaScript -->
            </div>
        </div>
    </section>


    <nav class="navbar">
        <a href="{{ route('index', ['section' => 'dairy']) }}">Dairy</a>
    <a href="{{ route('index', ['section' => 'fruits']) }}">Fruits</a>
    <a href="{{ route('index', ['section' => 'vegetables']) }}">Vegetables</a>
    <a href="{{ route('index', ['section' => 'meat']) }}">Meat</a>
    <a href="{{ route('index', ['section' => 'seafood']) }}">Seafood</a>
    <a href="{{ route('index', ['section' => 'eggs']) }}">Eggs</a>
    </nav>


    <div class="cart-container">
        <div class="cart-items">
            <h2>My Cart</h2>
            <table id="cartTable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Cart items will be added here by JavaScript -->
                </tbody>
            </table>
        </div>
        <div class="cart-summary">
            <h2>Summary</h2>
            <div id="cartTotalPrice">Total: RM 0.00</div>
            <button class="checkout-button" id="checkoutButton">Checkout</button>
            <button id="resetCartButton" class="reset-button">Reset Cart</button>
        </div>
    </div>


    <div class="footer">
        <p>&copy; 2023 Grocery Store. All rights reserved.</p>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            renderCart(cart);
            updateCartTotal(cart);

            // Reset Cart button functionality
            document.getElementById('resetCartButton').addEventListener('click', function () {
                resetCart();
            });

            // Checkout button functionality
            document.getElementById('checkoutButton').addEventListener('click', function () {
                checkout();
            });

            updateCartCount(); // Update cart count on page load
        });

        // Render cart items in the table
        function renderCart(cart) {
            const cartTableBody = document.querySelector('#cartTable tbody');
            cartTableBody.innerHTML = '';

            if (cart.length === 0) {
                cartTableBody.innerHTML = '<tr><td colspan="4">Your cart is empty.</td></tr>';
                return;
            }

            cart.forEach(item => {
                const total = (parseFloat(item.price) * item.quantity).toFixed(2);
                const cartRow = document.createElement('tr');
                cartRow.innerHTML = `
                    <td><img src="${item.image}" alt="${item.name}" class="cart-item-img"></td>
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>RM ${total}</td>
                `;
                cartTableBody.appendChild(cartRow);
            });
        }

        // Search functionality
        function searchItems() {
  const searchTerm = document.getElementById('searchInput').value.trim().toLowerCase();
  const resultsContainer = document.getElementById('searchResults');
  resultsContainer.innerHTML = ''; // Clear previous results

  if (searchTerm.length > 0) {
    fetch(`{{ route('search.items') }}?query=${encodeURIComponent(searchTerm)}`)
      .then(response => response.json())
      .then(items => {
        if (items.length > 0) {
          items.forEach(item => {
            // Create a list item with a link to the item's detail page
            const listItem = document.createElement('li');
            listItem.innerHTML = `
              <a href="{{ route('detail', ['id' => '__ID__']) }}?section=${encodeURIComponent(item.section)}"
                 class="search-result-item">
                ${item.name}
              </a>`;
            listItem.innerHTML = listItem.innerHTML.replace('__ID__', item.id);

            resultsContainer.appendChild(listItem);
          });
        } else {
          resultsContainer.innerHTML = '<li>No results found</li>';
        }
      })
      .catch(error => {
        console.error('Error fetching search results:', error);
      });
  }
        }

        // Update total price of the cart
        function updateCartTotal(cart) {
            const cartTotalPriceContainer = document.getElementById('cartTotalPrice');
            const total = cart.reduce((sum, item) => sum + parseFloat(item.price) * item.quantity, 0);
            cartTotalPriceContainer.textContent = `Total: RM ${total.toFixed(2)}`;
        }

        // Update the cart item count displayed in the cart icon
        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            document.getElementById('cartCount').textContent = cart.length;
        }

        // Reset the cart
        function resetCart() {
            if (confirm('Are you sure you want to clear the cart?')) {
                localStorage.removeItem('cart');
                renderCart([]);
                updateCartTotal([]);
                updateCartCount();
                alert('Cart has been reset.');
            }
        }

        // Checkout process
        function checkout() {
            if (confirm('Proceed to checkout?')) {
                window.location.href = '{{ route("pay") }}';
                //localStorage.removeItem('cart');
                renderCart([]);
                updateCartTotal([]);
                updateCartCount();

            }
        }
    </script>

</body>
</html>
