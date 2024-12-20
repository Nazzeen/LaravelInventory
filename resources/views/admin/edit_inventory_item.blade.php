<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Inventory Item - Admin Dashboard</title>
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
                            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
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
                <h3>Edit Inventory Item</h3>

                <!-- Display Success Message -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Form to Edit Item -->
                <form action="{{ route('admin.inventory.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Item Name</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $item->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="section">Section</label>
                        <select name="section" class="form-control" id="section" required>
                            <option value="meat" {{ $item->section == 'meat' ? 'selected' : '' }}>Meat</option>
                            <option value="vegetables" {{ $item->section == 'vegetables' ? 'selected' : '' }}>Vegetables</option>
                            <option value="seafood" {{ $item->section == 'seafood' ? 'selected' : '' }}>Seafood</option>
                            <option value="dairy" {{ $item->section == 'dairy' ? 'selected' : '' }}>Dairy</option>
                            <option value="eggs" {{ $item->section == 'eggs' ? 'selected' : '' }}>Eggs</option>
                            <option value="fruits" {{ $item->section == 'fruits' ? 'selected' : '' }}>Fruits</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" class="form-control" id="price" value="{{ $item->price }}" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label for="image">Item Image</label>
                        @if ($item->image)
                            <div class="mb-3">
                                <img src="{{ asset('assets/images/' . $item->image) }}" alt="Image" width="100">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" id="image">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="4" required>{{ $item->description }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Item</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
