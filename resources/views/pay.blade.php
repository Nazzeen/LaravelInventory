<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pay Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5c5946fe44.js" crossorigin="anonymous"></script>

    <style>
      /* Center the PayPal button */
      #paypal-button-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        transform: scale(1.3);
      }
      .paypal-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 70vh;
      }
    </style>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
      <div class="container">
        <a class="navbar-brand text-white" href="#">Pay Page</a>
      </div>
    </nav>

    <div class="container paypal-wrapper">
      <!-- Load PayPal SDK -->
      <script src="https://www.paypal.com/sdk/js?client-id=ASujuz9yPVm6IcIsHDWnKerIKVaVGzqZEsXQKJjiQbzBtw13Y9jao6IRAKWLCQyWWcY85Tv4BCazblKd&currency=USD"></script>
      <!-- Set up a container element for the button -->
      <div id="paypal-button-container"></div>
    </div>

    <script>
      // Inject the Blade route for redirection
      const homeRoute = "{{ route('home') }}";

      // Function to calculate the total amount dynamically
      function calculateCartTotal() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const total = cart.reduce((sum, item) => {
          const price = parseFloat(item.price.replace('RM', '').trim());
          return sum + (price * item.quantity);
        }, 0);
        return total.toFixed(2);
      }

      // Render PayPal buttons
      paypal.Buttons({
        createOrder: (data, actions) => {
          const totalAmount = calculateCartTotal();
          console.log("Total Amount for PayPal: ", totalAmount);
          return actions.order.create({
            purchase_units: [{
              amount: { value: totalAmount }
            }]
          });
        },
        onApprove: (data, actions) => {
          return actions.order.capture().then(function(orderData) {
            console.log('Capture Result:', orderData);
            alert("Payment Successful! Thank you for your purchase.");
            localStorage.removeItem('cart');
            window.location.href = homeRoute; // Redirect after success
          });
        }
      }).render('#paypal-button-container'); // Render PayPal button
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
  </body>
</html>
