<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SM CART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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

        /* Tab styling */
        .nav-tabs .nav-link {
            border: 1px solid #ddd;
            border-radius: 0.25rem;
            color: #333;
            font-weight: 600;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-tabs .nav-link.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
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
            background-color: #007bff;
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
        <h1 class="text-center">SM CART</h1>
        <button id="cartIcon" class="btn btn-warning" style="float: right;" title="Go to Cart" onclick="window.location.href='<?php echo e(url('/cart')); ?>'">
            <i class="fas fa-shopping-cart"></i>
            <span id="cartCount"><?php echo e(session()->get('cartCount', 0)); ?></span> <!-- Cart count dynamically updated -->
        </button>

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
                <form method="GET" action="<?php echo e(url('/')); ?>" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" placeholder="Search products"
                            value="<?php echo e(request()->search); ?>" class="form-control">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>

                <div class="row">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm product-card">
                                <img src="<?php echo e(asset('storage/images/' . $product->image)); ?>" class="card-img-top"
                                    alt="<?php echo e($product->name); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo e($product->name); ?></h5>
                                    <p class="card-text">Quantity: <?php echo e($product->quantity); ?></p>
                                    <p class="card-text"><strong>₹<?php echo e(number_format($product->price, 2)); ?></strong></p>
                                    <a href="<?php echo e(url('/cart/add/' . $product->id)); ?>" class="btn btn-success">Add to
                                        Cart</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Add Product Button -->

            </div>

            <!-- Order List Tab -->
            <div class="tab-pane fade" id="order-list" role="tabpanel" aria-labelledby="order-list-tab">
                <h2 class="text-center mb-4">Orders</h2>
                <form method="GET" action="<?php echo e(url('/')); ?>" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" placeholder="Search orders" value="<?php echo e(request()->search); ?>"
                            class="form-control">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
                <div class="row">
                    <?php if($orders->count() > 0): ?>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">Order #<?php echo e($order->id); ?></h5>
                                        <p class="card-text">Total: ₹<?php echo e(number_format($order->total_price, 2)); ?></p>
                                        <p class="card-text">Ordered on:
                                            <?php echo e(\Carbon\Carbon::parse($order->created_at)->format('M d, Y (D)')); ?></p>
                                        <p class="card-text">Status: <span
                                                class="badge bg-warning text-dark">Pending</span></p>
                                        <a href="javascript:void(0);" class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#orderModal"
                                            onclick="showOrderDetails(<?php echo e($order->id); ?>)">View Order</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="alert alert-warning text-center w-100">No orders found.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <button id="scrollToTopBtn" title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </button>
    <!-- Modal for Add Product -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>



    <?php echo $__env->make('popup.orderdetailspopup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('popup.addnewproductpopup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        function showOrderDetails(orderId) {

            const orders = <?php echo json_encode($orders, 15, 512) ?>;

            const products = <?php echo json_encode($products, 15, 512) ?>;

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
                                <img src="<?php echo e(asset('storage/images/${product.image}')); ?>" alt="${product.name}" class="img-fluid" style="max-height: 100px;">
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

        // When the user scrolls down 100px from the top of the document, show the button
        window.onscroll = function() {
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                scrollToTopBtn.style.display = "block";
            } else {
                scrollToTopBtn.style.display = "none";
            }
        };

        // When the user clicks on the button, scroll to the top of the document
        scrollToTopBtn.onclick = function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        };
    </script>
</body>

</html>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\sanjay-personal\sanmals_cart\mycart_backend\resources\views/products/index.blade.php ENDPATH**/ ?>