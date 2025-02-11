<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>

    <div class="container mt-5">
        <a class="btn btn-primary mb-4" href="<?php echo e(route('cart.show')); ?>">Back</a>
        <h1 class="text-center mb-4">Checkout</h1>

        <!-- Full Card Layout -->
        <div class="card">
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('order.place')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <!-- Billing Information Section (Left Side) -->
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-4">
                                <h3>Billing Information</h3>

                                <!-- Name Field -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter your full name" value="<?php echo e(old('name')); ?>">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-danger"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Email Field -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" name="email"  placeholder="Enter your email address" value="<?php echo e(old('email')); ?>">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-danger"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Address Field -->
                                <div class="mb-3">
                                    <label for="address" class="form-label">Billing Address</label>
                                    <textarea class="form-control" name="address" placeholder="Enter your billing address"><?php echo e(old('address')); ?></textarea>
                                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-danger"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Country Field -->
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-select" name="country">
                                        <option value="" selected disabled>Select your country</option>
                                        <option value="USA" <?php echo e(old('country') == 'USA' ? 'selected' : ''); ?>>USA</option>
                                        <option value="Canada" <?php echo e(old('country') == 'Canada' ? 'selected' : ''); ?>>Canada</option>
                                        <option value="UK" <?php echo e(old('country') == 'UK' ? 'selected' : ''); ?>>UK</option>
                                        <option value="India" <?php echo e(old('country') == 'India' ? 'selected' : ''); ?>>India</option>
                                        <option value="Australia" <?php echo e(old('country') == 'Australia' ? 'selected' : ''); ?>>Australia</option>
                                    </select>
                                    <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-danger"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Product Details Section (Right Side) -->
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded mb-4">
                                <h3>Order Summary</h3>

                                <ul class="list-group">
                                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <!-- Product Image -->
                                            <img src="<?php echo e(asset('storage/images/' . $item['image'])); ?>" alt="<?php echo e($item['name']); ?>" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">

                                            <!-- Product Name and Quantity -->
                                            <div class="d-flex flex-column">
                                                <span><?php echo e($item['name']); ?> (x<?php echo e($item['quantity']); ?>)</span>
                                                <span class="text-muted">$<?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?></span>
                                            </div>

                                            <!-- Product Total Price -->
                                            <span class="badge bg-primary">$<?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?></span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>

                                <h5 class="mt-3">Total: $<?php echo e(number_format($total, 2)); ?></h5>
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
                                <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-danger"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\sanjay-personal\sanmals_cart\mycart_backend\resources\views/checkout/index.blade.php ENDPATH**/ ?>