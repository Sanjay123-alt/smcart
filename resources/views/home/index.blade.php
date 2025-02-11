@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SM CART</title>
    <style>
        #scrollToTopBtn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 10px;
            font-size: 18px;
            display: none;
            z-index: 1000;
        }

        #scrollToTopBtn:hover {
            background-color: #0056b3;
        }

        .nav-tabs .nav-link {
            border: 1px solid #ddd;
            border-radius: 0.25rem;
            color: #333;
            font-weight: 600;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-tabs .nav-link.active {
            background-color: #9c5992!important;
            color: white!important;
        }

        .tab-content {
            margin-top: 30px;
        }

        .tab-pane {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            height: 250px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
        }

        .card-title {
            font-size: 1.2rem;
            color: #333;
        }

        .modal-header {
            background-color: #9c5992!important;
            color: white;
        }

        .modal-footer {
            background-color: #f1f1f1;
        }

        .product-card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <button class="btn btn-success mt-5" style="float: right;"  data-bs-toggle="modal"
            data-bs-target="#addProductModal">Add Product</button>

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="product-list-tab" data-bs-toggle="tab" href="#product-list"
                    role="tab" aria-controls="product-list" aria-selected="true">Product List</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="order-list-tab" data-bs-toggle="tab" href="#order-list" role="tab"
                    aria-controls="order-list" aria-selected="false">Order List</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="productTabContent">
            <!-- Product List Tab -->
            <div class="tab-pane fade show active" id="product-list" role="tabpanel" aria-labelledby="product-list-tab">
                <h2 class="text-center mb-4">Products</h2>
                <!-- Search Form -->
                <form method="GET" action="{{ url('/') }}" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" placeholder="Search products"
                            value="{{ request()->search }}" class="form-control">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>

                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm product-card">
                                <img src="{{ asset('storage/images/' . $product->image) }}" class="card-img-top"
                                    alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">Quantity: {{ $product->quantity }}</p>
                                    <p class="card-text"><strong>₹{{ number_format($product->price, 2) }}</strong></p>
                                    <a href="{{ url('/cart/add/' . $product->id) }}" class="btn btn-success" onclick="showProductAddedToast()">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Order List Tab -->
            <div class="tab-pane fade" id="order-list" role="tabpanel" aria-labelledby="order-list-tab">
                <h2 class="text-center mb-4">Orders</h2>
                <form method="GET" action="{{ url('/') }}" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" placeholder="Search orders" value="{{ request()->search }}"
                            class="form-control">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
                <div class="row">
                    @if ($orders->count() > 0)
                        @foreach ($orders as $order)
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">Order #{{ $order->id }}</h5>
                                        <p class="card-text">Total: ₹{{ number_format($order->total_price, 2) }}</p>
                                        <p class="card-text">Ordered : {{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</p>
                                        <p class="card-text">Status: <span
                                                class="badge bg-warning text-dark">Pending</span></p>
                                        <a href="javascript:void(0);" class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#orderModal"
                                            onclick="showOrderDetails({{ $order->id }})">View Order</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-warning text-center w-100">No orders found.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <button id="scrollToTopBtn" title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    @include('popup.orderdetailspopup')

    @include('popup.addnewproductpopup')

    <script>


        function showOrderDetails(orderId) {

            const orders = @json($orders);

            const products = @json($products);

            const selectedOrder = orders.find(order => order.id === orderId);

            if (!selectedOrder) {

                console.error('Order not found:', orderId);

                return;
            }

            document.getElementById('orderModalLabel').innerText = 'Order #' + selectedOrder.id;
            document.getElementById('orderDetails').innerText = 'Name: ' + selectedOrder.name + '\n\n' +
                'Email: ' + selectedOrder.email + '\n\n' +
                'Address: ' + selectedOrder.address + '\n\n' +
                'Country: ' + selectedOrder.country + '\n\n' +
                'Payment Method: ' + selectedOrder.payment_method;
            document.getElementById('orderTotalPrice').innerText = 'Total Price: ₹' + parseFloat(selectedOrder.total_price)
                .toFixed(2);
            document.getElementById('orderStatus').innerHTML = 'Status: <span class="badge bg-' + (selectedOrder.status ===
                'Completed' ? 'success' : 'warning') + '" style="color: ' + (selectedOrder.status === 'Pending' ?
                'black' : 'black') + ';">' + (selectedOrder.status || 'Pending') + '</span>';
            document.getElementById('orderDate').innerText = 'Ordered on: ' + new Date(selectedOrder.created_at)
                .toLocaleDateString();

            const productDetailsContainer = document.getElementById('orderProducts');

            productDetailsContainer.innerHTML = '';

            const productIds = selectedOrder.product_id.split(',');

            productIds.forEach(productId => {

                const product = products.find(product => product.id === parseInt(productId));

                if (product) {

                    const productDiv = document.createElement('div');

                    productDiv.classList.add('product-details', 'mb-3');

                    productDiv.innerHTML = `
                        <div class="row">
                            <div class="col-4">
                                <img src="{{ asset('storage/images/${product.image}') }}" alt="${product.name}" class="img-fluid" style="max-height: 100px;">
                            </div>
                            <div class="col-8">
                                <h6>Name: ${product.name}</h6>
                                <p>Price: ₹${parseFloat(product.price).toFixed(2)}</p>
                                <p>Quantity: ${selectedOrder.quantity || 1}</p>
                            </div>
                        </div>
                        <hr>  <!-- Add a horizontal rule after each product -->
                    `;
                    productDetailsContainer.appendChild(productDiv);

                } else {
                    console.error('Product not found for order:', orderId);
                }
            });

            if (productIds.length === 0) {

                productDetailsContainer.innerHTML = '<p>No products found for this order.</p>';

            }
        }

        let scrollToTopBtn = document.getElementById("scrollToTopBtn");

        window.onscroll = function() {

            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {

                scrollToTopBtn.style.display = "block";

            } else {

                scrollToTopBtn.style.display = "none";

            }
        };

        scrollToTopBtn.onclick = function() {

            window.scrollTo({

                top: 0,

                behavior: 'smooth'

            });
        };

        function showProductAddedToast() {
        const loadingToast = Toastify({
            text: "Adding to cart...",
            duration: -1,
            close: false,
            backgroundColor: "#007bff",
            position: "center",
            stopOnFocus: true,
            onClick: function() {}
        }).showToast();

        setTimeout(function() {
            loadingToast.remove();
            Toastify({
                text: "Product added to cart successfully!",
                duration: 3000,
                close: true,
                backgroundColor: "#28a745",
                position: "center",
                stopOnFocus: true,
            }).showToast();
        }, 3000);
    }
    </script>
</body>
</html>
@endsection
