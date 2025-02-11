@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>

    <div class="container mt-5">
        <a class="btn btn-primary mb-4" href="{{ route('cart.show') }}">Back</a>
        <h1 class="text-center mb-4">Checkout</h1>

        <!-- Full Card Layout -->
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('order.place') }}">
                    @csrf

                    <div class="row">
                        <!-- Billing Information Section (Left Side) -->
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-4">
                                <h3>Billing Information</h3>

                                <!-- Name Field -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter your full name" value="{{ old('name') }}">
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" name="email"  placeholder="Enter your email address" value="{{ old('email') }}">
                                    @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Address Field -->
                                <div class="mb-3">
                                    <label for="address" class="form-label">Billing Address</label>
                                    <textarea class="form-control" name="address" placeholder="Enter your billing address">{{ old('address') }}</textarea>
                                    @error('address')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Country Field -->
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-select" name="country">
                                        <option value="" selected disabled>Select your country</option>
                                        <option value="USA" {{ old('country') == 'USA' ? 'selected' : '' }}>USA</option>
                                        <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                        <option value="UK" {{ old('country') == 'UK' ? 'selected' : '' }}>UK</option>
                                        <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                                        <option value="Australia" {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                                    </select>
                                    @error('country')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Product Details Section (Right Side) -->
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-4">
                                <h3>Order Summary</h3>

                                <ul class="list-group">
                                    @foreach($cart as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <!-- Product Image -->
                                            <img src="{{ asset('storage/images/' . $item['image']) }}" alt="{{ $item['name'] }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">

                                            <!-- Product Name and Quantity -->
                                            <div class="d-flex flex-column">
                                                <span>{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                                                <span class="text-muted">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                            </div>

                                            <!-- Product Total Price -->
                                            <span class="badge bg-primary">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                        </li>
                                    @endforeach
                                </ul>

                                <h5 class="mt-3">Total: ${{ number_format($total, 2) }}</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Section -->
                    <div class="bg-light p-3 rounded mb-4">
                        <h3>Payment Method</h3>

                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" value="cash_on_delivery" checked>
                                <label class="form-check-label">Cash on Delivery</label>
                                @error('payment_method')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg">Place Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
@endsection
