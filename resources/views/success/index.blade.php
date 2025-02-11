@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Order Placed Successfully!</h1>
        <!-- Continue Shopping Button -->
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-primary" style="float:right;">Continue Shopping</a>
        </div>
        <div class="row">
            <!-- Billing Information Section -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Billing Information</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $order->name }}</p>
                        <p><strong>Email:</strong> {{ $order->email }}</p>
                        <p><strong>Address:</strong> {{ $order->address }}</p>
                        <p><strong>Country:</strong> {{ $order->country }}</p>
                        <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Order Details</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($order->products as $product)
                            <div class="product-item mb-4 d-flex align-items-center">
                                <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="img-fluid" style="max-height: 100px; object-fit: cover; margin-right: 15px;">
                                <div>
                                    <p><strong>Product Name:</strong> {{ $product->name }}</p>
                                    <p><strong>Price per Unit:</strong> ${{ number_format($product->price, 2) }}</p>
                                    <p><strong>Total Price:</strong> ${{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                            <hr>
                        @endforeach

                        <h4 class="mt-3">Total Price for Order: ${{ number_format($order->total_price, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
@endsection
