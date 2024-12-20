<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Create Inventory Item - Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Include Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/styles/style.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<div id="wrapper">
    <!-- Navbar -->
    <nav class="navbar header-top fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Left Side Navbar -->
                @auth('admin')
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('inventory.create') }}">Add New Item</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('inventory.index') }}">View Inventory</a>
                    </li>
                </ul>
                @endauth

                <!-- Right Side Navbar -->
                <ul class="navbar-nav ml-auto">
                    @auth('admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-toggle="dropdown">
                                {{ Auth::guard('admin')->user()->username }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-5 pt-4">
        <div class="row">
            <div class="col-md-12">
                <h3>Create New Inventory Item</h3>

                <!-- Display Success Message -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Form to Add New Item -->
                <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Item Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="section">Section</label>
                        <select name="section" class="form-control" id="section" required>
                            <option value="">Select Section</option>
                            <option value="meat">Meat</option>
                            <option value="vegetables">vegetables</option>
                            <option value="seafood">seafood</option>
                            <option value="dairy">Dairy</option>
                            <option value="eggs">eggs</option>
                            <option value="fruits">Fruits</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" class="form-control" id="price" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Item Image</label>
                        <input type="file" name="image" class="form-control" id="image">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="4" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Item</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
