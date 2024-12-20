<!DOCTYPE html>
<html>
<head>

  <title>Nazete Grocery Registration</title>
  <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
</head>
<body>


  <section class="intro-section">
    <div id="intro2">
      <div class="logo-container">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/images/LOGOCOMP.png') }}" alt="Logo" class="logo">
        </a>
      </div>
    </div>
  </section>


  <div class="registration-container">
    <div class="semi-circle"></div>
    <form class="registration-form" action="{{ route('register') }}" method="POST">
        @csrf
        <h5>Register with Us!</h5>

        <div class="logo-container">
            <img src="{{ asset('assets/images/LOGOCOMP.png') }}" alt="Logo" class="form-logo">
        </div>

        <!-- Name Field -->
        <label for="username"></label>
        <input type="text" id="username" name="username" placeholder="USERNAME" value="{{ old('username') }}" required>
        @error('username')
            <p class="error">{{ $message }}</p>
        @enderror

        <!-- Email Field -->
        <label for="email"></label>
        <input type="text" id="email" name="email" placeholder="EMAIL" value="{{ old('email') }}" required>
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror

        <!-- Password Field -->
        <label for="password"></label>
        <input type="password" id="password" name="password" placeholder="PASSWORD" required>
        @error('password')
            <p class="error">{{ $message }}</p>
        @enderror

        <!-- Confirm Password Field -->
        <label for="password_confirmation"></label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="CONFIRM PASSWORD" required>
        @error('password_confirmation')
            <p class="error">{{ $message }}</p>
        @enderror

        <h5>Already have an account? <a href="{{ route('login') }}">Login</a></h5>
        <button type="submit">Register</button>
    </form>


  </div>


  <script>
    function registerUser(event) {
      event.preventDefault(); // Prevent form submission

      const username = document.getElementById('username').value;
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirm-password').value;

      if (password !== confirmPassword) {
        alert('Passwords do not match');
        return;
      }

      // Save the user data in localStorage
      localStorage.setItem('username', username);
      localStorage.setItem('email', username);
      localStorage.setItem('password', password);

      alert('Registration successful');

      window.location.href = '{{ route('login') }}'; // Redirect to the login page
    }
  </script>

</body>
</html>
