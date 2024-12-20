<!DOCTYPE html>
<html>
<head>
  <title>Nazete Grocery Selection</title>
  <link rel="stylesheet" href="{{ asset('assets/css/main-menu.css') }}">
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

  <!-- Slideshow -->
  <div class="slideshow-container">
    <div class="mySlides fade">
      <img src="{{ asset('assets/images/banner_meat.jpeg') }}" alt="Meat" class="banner-image">
    </div>
    <div class="mySlides fade">
      <img src="{{ asset('assets/images/banner_vegetable.jpeg') }}" alt="Vegetables" class="banner-image">
    </div>
    <div class="mySlides fade">
      <img src="{{ asset('assets/images/banner_seafood.jpeg') }}" alt="Seafood" class="banner-image">
    </div>
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
  </div>

  <!-- Selection Boxes -->
  <div class="selection-boxes">
    <div class="selection-box" id="meat-section">
      <h3>Meat</h3>
      <p>Local and Imported</p>
      <button onclick="window.location.href='{{ route('index', ['section' => 'meat']) }}'">Shop now</button>
    </div>
    <div class="selection-box" id="vegetable-section">
      <h3>Vegetables</h3>
      <p>Fresh Vegetables</p>
      <button onclick="window.location.href='{{ route('index', ['section' => 'vegetables']) }}'">Shop now</button>
    </div>
    <div class="selection-box" id="seafood-section">
      <h3>Seafood</h3>
      <p>Fresh Seafood</p>
      <button onclick="window.location.href='{{ route('index', ['section' => 'seafood']) }}'">Shop now</button>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <p>&copy; 2023 Grocery Store. All rights reserved.</p>
  </div>

  <!-- Scripts -->
  <script>
    let slideIndex = 0;

    // Function to Show Slides in a Loop
    function showSlides() {
      let slides = document.getElementsByClassName("mySlides");
      for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      slideIndex++;
      if (slideIndex > slides.length) {
        slideIndex = 1;
      }
      slides[slideIndex - 1].style.display = "block";
      setTimeout(showSlides, 5000); // Change image every 5 seconds
    }
    showSlides();

    // Function to Navigate Slides
    function plusSlides(n) {
      slideIndex += n - 1;
      showSlides();
    }

    // Search Items Functionality
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



    // Update Cart Count on Page Load
    function updateCartCount() {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      document.getElementById('cartCount').textContent = cart.length;
    }
    document.addEventListener('DOMContentLoaded', updateCartCount);

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
