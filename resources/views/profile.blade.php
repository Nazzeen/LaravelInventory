<!DOCTYPE html>
<html>
<head>
  <title>Profile - Egz Grocery</title>
  <link rel="stylesheet" href="profile.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="items.js"></script>
</head>
<body>

  <section class="intro-section">
    <p id="intro1">Free Shipping for All Egz family &lt;3</p>
    <div id="intro2">
      <div class="logo-container">
        <a href="HomePage.html">
          <img src="LOGOCOMP.png" alt="Logo" class="logo">
        </a>
      </div>

      <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search items..." oninput="searchItems()">
        <button class="search-button"><i class="fas fa-search"></i></button>
        <ul id="searchResults" class="search-results"></ul>
      </div>

      <div class="profile-cart">
        <a href="profile.html" id="profileLink"><i class="fas fa-user"></i></a>
        <a href="previewCheckOut.html" id="cartIcon"><i class="fas fa-shopping-cart"></i></a>
        <span id="cartCount" class="cart-count">0</span>
      </div>
    </div>
  </section>

  <section class="profile-section">
    <div class="profile-sidebar">
      <div class="profile-header">
        <i class="fas fa-user-circle"></i>
        <h2>Hello<br> <span class="profile-name"></span></h2>
      </div>

      <div class="profile-content">
        <h3>My Account</h3>
        <ul>
          <li><a href="profile.html">Profile</a></li>
        </ul>
      </div>

      <div class="about-us">
        <a href="about-us.html">About Us</a>
      </div>

      <div class="contact-us">
        <a href="contact-us.html">Contact Us</a>
      </div>

      <div class="term-condition">
        <a href="term-condition.html">Term & Condition</a>
      </div>

      <div class="privacy-policy">
        <a href="privacy-policy.html">Privacy & Policy</a>
      </div>
    </div>

    <div class="profile-content">
      <div class="profile-form">
        <form id="profileForm">
          <div class="form-group logo-group">
            <img src="LOGOCOMP.png" alt="Logo" class="form-logo">
            <h1>Profile</h1>
            <br>
            <p><b>Basic Information</b></p>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="title">Title</label>
              <select id="title" name="title">
                <option value="mr">Mr.</option>
                <option value="mrs">Mrs.</option>
                <option value="ms">Ms.</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="firstName">First Name</label>
              <input type="text" id="firstName" name="firstName">
            </div>

            <div class="form-group">
              <label for="lastName">Last Name</label>
              <input type="text" id="lastName" name="lastName">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="race">Race</label>
              <input type="text" id="race" name="race">
            </div>

            <div class="form-group">
              <label for="dob">Date of Birth</label>
              <input type="text" id="dob" name="dob" placeholder="DD-MM-YYYY">
            </div>
          </div>

          <br>

          <p><b>Contact Information</b></p>

          <br>

          <div class="form-row">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email">
            </div>

            <div class="form-group">
              <label for="phoneNumber">Phone Number</label>
              <input type="text" id="phoneNumber" name="phoneNumber">
            </div>
          </div>

          <br>

          <p><b>Address</b></p>

          <br>

          <div class="form-row">
            <div class="form-group">
              <label for="address1">Address line 1</label>
              <input type="text" id="address1" name="address1">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="address2">Address line 2</label>
              <input type="text" id="address2" name="address2">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="city">City</label>
              <input type="text" id="city" name="city">
            </div>

            <div class="form-group">
              <label for="state">State</label>
              <input type="text" id="state" name="state">
            </div>

            <div class="form-group">
              <label for="postcode">Postcode</label>
              <input type="text" id="postcode" name="postcode">
            </div>
          </div>

          <div class="form-group">
            <button type="submit">Save</button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script>

// Functionality to be executed after DOM content is loaded
document.addEventListener('DOMContentLoaded', function()
 {

  // Retrieve username from session storage
  const username = sessionStorage.getItem('username');

  // If username exists, display it; otherwise, redirect to login
  if (username) {
    document.querySelector('.profile-name').textContent = username;
  } else {
    alert('Please log in to access your profile.');
    window.location.href = 'login.html';
  }

  // Update cart count on page load
  updateCartCount();

  // Handle profile form submission
  const profileForm = document.getElementById('profileForm');
  profileForm.addEventListener('submit', function(event) {
    event.preventDefault();
    saveProfileInformation();
    alert('Your information is saved.');
    profileForm.reset();
  });
});

// Function to search items based on input
function searchItems() {
  console.log("searchItems function called");
  const searchTerm = document.getElementById('searchInput').value.toLowerCase();
  console.log("Search Term:", searchTerm);
  const resultsContainer = document.getElementById('searchResults');
  resultsContainer.innerHTML = '';

  // Filter items based on search term
  if (searchTerm && typeof allItems !== 'undefined') {
    console.log("allItems:", allItems);
    const filteredItems = allItems.filter(item => item.name.toLowerCase().startsWith(searchTerm));

    // Display filtered items in search results
    filteredItems.forEach(item => {
      const listItem = document.createElement('li');
      listItem.textContent = item.name;
      listItem.addEventListener('click', () => {
        window.location.href = `details.html?name=${item.name}&section=${item.section}`;
      });
      resultsContainer.appendChild(listItem);
    });
  }
}

// Function to update cart count
function updateCartCount() {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const uniqueItemCount = cart.length; // Count unique items
  document.getElementById('cartCount').textContent = uniqueItemCount;
}

// Function placeholder for saving profile information (no database for this project)
function saveProfileInformation() {
  console.log('Profile information saved!');
}
</script>
</body>
</html>
