// search.js

function searchItems() {
  // Get the search query
  const query = document.getElementById('searchInput').value.toLowerCase();

  // Get all the items
  const items = document.querySelectorAll('.selection-box');

  // Loop through the items and show/hide based on the query
  items.forEach(item => {
    const itemName = item.getAttribute('data-name').toLowerCase();
    if (itemName.includes(query)) {
      item.style.display = 'block';
    } else {
      item.style.display = 'none';
    }
  });
}
