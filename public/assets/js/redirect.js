document.addEventListener('DOMContentLoaded', function() {
  const navLinks = document.querySelectorAll('.navbar a');
  navLinks.forEach(link => {
    const section = link.getAttribute('data-section');
    if (section) {
      link.setAttribute('href', `mainIndex.html#${section}`);
    }
  });
});
