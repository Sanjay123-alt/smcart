<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Add Poppins font (optional for better font styling) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="font-family: 'Poppins', sans-serif;">

    <div class="container mt-5">
        <a class="btn btn-primary mb-4" href="<?php echo e(route('products.index')); ?>">Back</a>

        <!-- Full Card Wrapper -->
        <div class="card shadow-lg">
            <div class="card-header text-center">
                <h1>Your Cart</h1>
            </div>

            <div class="card-body">
                <?php if(session('cart') && count(session('cart')) > 0): ?>
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>S.No</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $__currentLoopData = session('cart'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->index+1); ?></td>
                                    <td>
                                        <img src="<?php echo e(asset('storage/images/' . $item['image'])); ?>" alt="<?php echo e($item['name']); ?>" class="img-fluid" style="width: 50px; height: auto; margin-right: 10px;">
                                        <?php echo e($item['name']); ?>

                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-sm btn-secondary" onclick="updateQuantity('<?php echo e(route('cart.update', $id)); ?>', -1)">-</button>
                                            <span class="mx-2"><?php echo e($item['quantity']); ?></span>
                                            <button class="btn btn-sm btn-secondary" onclick="updateQuantity('<?php echo e(route('cart.update', $id)); ?>', 1)">+</button>
                                        </div>
                                    </td>
                                    <td>$<?php echo e(number_format($item['price'], 2)); ?></td>
                                    <td>$<?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('cart.remove', $id)); ?>" class="btn btn-danger btn-sm">Remove</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between mt-4">
                        <h4 class="text-end">Total: $<?php echo e(number_format(array_reduce(session('cart'), function ($carry, $item) {
                            return $carry + ($item['price'] * $item['quantity']);
                        }, 0), 2)); ?></h4>
                        <a href="<?php echo e(route('checkout')); ?>" class="btn btn-success btn-lg">Proceed to Checkout</a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning text-center">
                        <p>Your cart is empty!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function updateQuantity(url, change) {
            // Send an AJAX request to update the quantity
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                },
                body: JSON.stringify({
                    change: change,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the page with the new quantity
                    location.reload();
                } else {
                    alert('Error updating quantity.');
                }
            });
        }
    </script>
</body>
</html>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\sanjay-personal\sanmals_cart\mycart_backend\resources\views/cart/index.blade.php ENDPATH**/ ?>