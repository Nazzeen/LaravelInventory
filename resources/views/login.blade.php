<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
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

  <div class="login-container">
    <div class="semi-circle"></div>

    <form class="login-form" method="POST" action="{{ route('login.process') }}">
        @csrf
        <h5>Welcome to the</h5>

        <div class="logo-container">
          <img src="{{ asset('assets/images/LOGOCOMP.png') }}" alt="Logo" class="form-logo">
        </div>

        <!-- Display errors here -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label for="email_or_username">Email or Username</label>
        <input type="text" id="email_or_username" name="email_or_username" placeholder="Email or Username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Password" required>

        <div style="display: flex; justify-content: center; align-items: center; margin-top: 10px;">
          <label style="margin-right: 20px;">
            <input type="radio" name="role" value="user" checked>User
          </label>

          <label>
            <input type="radio" name="role" value="admin">Admin
          </label>
        </div>

        <h5>Don't have an account? <a href="{{ route('register') }}">Sign up</a></h5>
        <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
