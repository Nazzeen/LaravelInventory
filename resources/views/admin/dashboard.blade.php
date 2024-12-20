<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
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
            <a class="navbar-brand" href="#">Admin Panels</a>
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
                        <!-- Hello, [username] Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-toggle="dropdown">
                                Hello, {{ Auth::guard('admin')->user()->username }}  <!-- Debugging output -->
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
                            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-5 pt-4">
        <!-- Admin Section -->
        <div class="row">
            <div class="col-md-12">
                <h3>Admin Section</h3>
                <ul class="list-group">
                    @foreach($admins as $admin)
                        <li class="list-group-item">
                            {{ $admin->username }} - {{ $admin->email }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Inventory Item Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>Inventory Items</h3>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <a href="{{ route('inventory.create') }}" class="btn btn-primary mb-3">Add New Item</a>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Section</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventoryItems as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->section }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>
                                    @if($item->image)
                                        <img src="{{ asset('assets/images/'. $item->image) }}" alt="Image" width="100">
                                    @else
                                        <span>No image</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('inventory.edit', $item->id) }}" class="btn btn-warning">Edit</a>

                                    <form action="{{ route('inventory.delete', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>
