<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SM CART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Add Poppins font link -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Include compiled CSS (from Laravel Mix) -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>

<body style="font-family: 'Poppins', sans-serif;">
    <div class="text-center py-2" style="background-color: rgb(137, 87, 126)">
        <h1 class="text-white mb-0">SM CART</h1>
    </div>
    <div class="position-fixed top-10 end-0 m-3">
        <button id="cartIcon" class="btn btn-warning" title="Go to Cart" onclick="window.location.href='{{ url('/cart') }}'">
            <i class="fas fa-shopping-cart"></i>
            <span id="cartCount">{{ session()->get('cartCount', 0) }}</span> <!-- Cart count dynamically updated -->
        </button>
    </div>

    <!-- Content section -->
    <div class="container mt-5">
        @yield('content')
    </div>

</body>

</html>
