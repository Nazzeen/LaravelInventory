<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Detail - Egz Grocery</title>
  <link rel="stylesheet" href="{{ asset('assets/css/details.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <!-- Intro Section -->
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

        <!-- Cart Icon Always Available -->
        <a href="javascript:void(0);"
           id="cartIcon"
           onclick="@if(Auth::check()) openCart() @else promptLogin() @endif">
            <i class="fas fa-shopping-cart"></i>
        </a>
        <span id="cartCount" class="cart-count">0</span>
    </div>
    </div>
  </section>

  <!-- Navbar -->
  <nav class="navbar">
    <a href="{{ route('index', ['section' => 'dairy']) }}">Dairy</a>
    <a href="{{ route('index', ['section' => 'fruits']) }}">Fruits</a>
    <a href="{{ route('index', ['section' => 'vegetables']) }}">Vegetables</a>
    <a href="{{ route('index', ['section' => 'meat']) }}">Meat</a>
    <a href="{{ route('index', ['section' => 'seafood']) }}">Seafood</a>
    <a href="{{ route('index', ['section' => 'eggs']) }}">Eggs</a>
  </nav>

  <!-- Breadcrumb -->
   <div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a> /
    <a href="{{ route('index', ['section' => $category]) }}" id="breadcrumb-category">
      {{ ucfirst($category) }}
    </a> /
    <span id="breadcrumb-item">{{ $item->name }}</span>
  </div>

  <!-- Product Details -->
  <div class="product-detail-container">
    <div class="product-left">
      <div class="product-image">
        <img id="product-image" src="{{ asset('assets/images/' . $item->image) }}" alt="{{ $item->name }}">
      </div>
      <div class="product-description">
        <h2>Description</h2>
        <p id="product-description">{{ $item->description }}</p>
      </div>
    </div>
    <div class="product-right">
      <div class="product-info">
        <h1 id="product-name">{{ $item->name }}</h1>
        <div class="product-unit">
          <label for="quantity">Total Unit</label>
          <input type="number" id="quantity" value="1" min="1">
        </div>
        <div id="productPrice">Price: <span id="product-price">RM{{ $item->price }}</span></div>
        <button class="add-to-cart-button" id="addToCartButton">Add to cart</button>
        <button id="resetCartButton" class="reset-button">Reset Cart</button>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">

    <p>&copy; 2023 Grocery Store. All rights reserved.</p>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const item = {
        name: "{{ $item->name }}",
        price: "{{ $item->price }}",
        image: "{{ asset('assets/images/' . $item->image) }}",
        description: "{{ $item->description }}"
      };

      const category = "{{ $category }}";

      // Render product details dynamically
      renderProductDetail(item, category);

      // Update cart count
      updateCartCount();

      // Add item to cart
      document.getElementById('addToCartButton').addEventListener('click', function () {
        addToCart(item);
      });

      // Reset cart
      document.getElementById('resetCartButton').addEventListener('click', function () {
        resetCart();
      });
    });

    // Update cart count in the UI
    function updateCartCount() {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      document.getElementById('cartCount').textContent = cart.length;
    }

    // Add item to cart
    function addToCart(item) {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      const quantity = parseInt(document.getElementById('quantity').value);
      const cartItem = cart.find(cartItem => cartItem.name === item.name);

      if (cartItem) {
        cartItem.quantity += quantity;
      } else {
        cart.push({ ...item, quantity });
      }

      localStorage.setItem('cart', JSON.stringify(cart));
      updateCartCount();
      alert(`${item.name} has been added to your cart.`);
    }

    // Reset cart
    function resetCart() {
      if (confirm('Are you sure you want to clear the cart?')) {
        localStorage.removeItem('cart');
        updateCartCount();
        alert('Cart has been reset.');
      }
    }

    // Render product details
    function renderProductDetail(item, category) {
      document.getElementById('product-name').textContent = item.name;
      document.getElementById('product-description').textContent = item.description;
      document.getElementById('product-price').textContent = `RM${item.price}`;
      document.getElementById('product-image').src = item.image;
      document.getElementById('product-image').alt = item.name;

      document.getElementById('breadcrumb-item').textContent = item.name;
      document.getElementById('breadcrumb-category').textContent =
        category.charAt(0).toUpperCase() + category.slice(1);
    }

    // Search items (adjust functionality as needed)
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

    function promptLogin() {
    if (confirm('You need to log in to add items to the cart. Would you like to log in now?')) {
        window.location.href = '{{ route('login') }}';
    }
}

function openCart() {
        window.location.href = '{{ route('checkout') }}';
}
  </script>
</body>
</html>
