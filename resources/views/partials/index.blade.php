<body style="font-family: 'Poppins', sans-serif;">
@foreach($products as $product)
    <div class="col-md-4 mb-4 product-item" data-name="{{ strtolower($product->name) }}" data-description="{{ strtolower($product->description) }}">
        <div class="card">
            <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">{{ $product->quantity }}</p>
                <p class="card-text">${{ number_format($product->price, 2) }}</p>
                <a href="{{ route('cart.add', $product->id) }}" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
    </div>
@endforeach

<!-- If no products match, show a no products found message -->
@if($products->isEmpty())
    <div id="noProductsMessage">
        <p>No products found!</p>
    </div>
@endif
</body>
