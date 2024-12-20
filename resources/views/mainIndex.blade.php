<!DOCTYPE html>
<html>
<head>
  <title>Nazete Grocery Selection</title>
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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

  <nav class="navbar">
    <a href="{{ route('index', ['section' => 'dairy']) }}">Dairy</a>
    <a href="{{ route('index', ['section' => 'fruits']) }}">Fruits</a>
    <a href="{{ route('index', ['section' => 'vegetables']) }}">Vegetables</a>
    <a href="{{ route('index', ['section' => 'meat']) }}">Meat</a>
    <a href="{{ route('index', ['section' => 'seafood']) }}">Seafood</a>
    <a href="{{ route('index', ['section' => 'eggs']) }}">Eggs</a>
  </nav>

  <div id="content">
    <section id="barang" class="item-section">
      <h2>{{ ucfirst($category) }}</h2>
      <div class="MainItem">
        @foreach ($inventory_item as $item)
          <div class="Items">
            <img src="{{ asset('assets/images/'.$item->image) }}" alt="{{ $item->name }}">
            <div class="item-content">
              <p><b>{{ $item->name }}</b></p>
              <p>RM{{ $item->price }}</p>
            </div>
            <a href="{{ route('detail', ['id' => $item->id]) }}">
              <button>Details</button>
            </a>
          </div>
        @endforeach
      </div>
    </section>
  </div>

  <div class="footer">
    <p>&copy; 2023 Grocery Store. All rights reserved.</p>
  </div>

  <script>
    // Function to filter items based on search input
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

    // Function to update cart count (assuming cart is stored in localStorage)
    function updateCartCount() {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      const uniqueItemCount = cart.length;
      document.getElementById('cartCount').textContent = uniqueItemCount;
    }

    // On page load
    document.addEventListener('DOMContentLoaded', function() {
      updateCartCount();
    });

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
