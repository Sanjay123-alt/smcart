<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller {
    public function index(Request $request) {

        $products = Product::query();

        if ($request->has('search') && $request->search != '') {

            $searchQuery = strtolower($request->search);

            $products = $products->where(function ($query) use ($searchQuery) {

                $query->whereRaw('LOWER(name) LIKE ?', ["%$searchQuery%"])

                    ->orWhereRaw('LOWER(quantity) LIKE ?', ["%$searchQuery%"])

                    ->orWhereRaw('LOWER(price) LIKE ?', ["%$searchQuery%"]);
            });
        }

        $products = $products->get();

        $orders = Order::all();

        if ($request->ajax()) {

            return view('partials.index', compact('products', 'orders'));

        }

        return view('home.index', compact('products', 'orders'));
    }
    public function store(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',

            'quantity' => 'required|integer|min:1',

            'price' => 'required|numeric|min:0.01',

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $imageName = time() . '.' . $request->file('image')->extension();

        $request->file('image')->storeAs('images', $imageName, 'public');

        Product::create([

            'name' => $request->name,

            'quantity' => $request->quantity,

            'price' => $request->price,

            'image' => $imageName,
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    // Add product to the cart
    public function addToCart($id) {

        $product = Product::find($id);

        $cart = session()->get('cart', []);

        $cartCount = session()->get('cartCount', 0);

        // If the product is already in the cart, increase the quantity
        if (isset($cart[$id])) {

            $cart[$id]['quantity']++;

        } else {

            $cart[$id] = [

                "id" => $product->id,

                "name" => $product->name,

                "quantity" => 1,

                "price" => $product->price,

                "image" => $product->image
            ];

            $cartCount++;
        }

        session()->put('cart', $cart);

        session()->put('cartCount', $cartCount);

        return redirect()->route('products.index');
    }

    // Show cart page
    public function showCart()
    {
        return view('cart.index');
    }

    // Remove a product from the cart
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        $cartCount = session()->get('cartCount', 0);

        if (isset($cart[$id])) {

            $cartCount -= $cart[$id]['quantity'];

            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        if (empty($cart)) {

            session()->put('cartCount', 0); // Set cart count to 0 if the cart is empty

        } else {

            session()->put('cartCount', max($cartCount, 0));
        }

        return redirect()->route('cart.show');
    }
    public function updateCart(Request $request, $id)
    {
        $cart = session('cart', []);

        if (!isset($cart[$id])) {

            return response()->json(['success' => false], 404);

        }

        // Update the quantity
        $cart[$id]['quantity'] += $request->change;

        if ($cart[$id]['quantity'] <= 0) {

            unset($cart[$id]);
        }

        session(['cart' => $cart]);

        return response()->json(['success' => true]);
    }

    // Checkout page
    public function checkout() {

        $cart = session('cart', []);

       $cartCount = session('cartCount', 0);

        // Calculate total price

        $total = array_reduce($cart, function ($carry, $item) {

            return $carry + ($item['price'] * $item['quantity']);

        }, 0);

        return view('checkout.index', compact('cart', 'total'));
    }


    // Place order (store order in session)

    public function placeOrder(Request $request)
    {
        $request->validate([

            'name' => 'required|string|max:255',

            'email' => 'required|email',

            'address' => 'required|string',

            'country' => 'required|string',

            'payment' => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {

            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $totalPrice = 0;

        $orderProducts = [];

        $productIds = [];

        foreach ($cart as $product) {

            if (empty($product['id']) || empty($product['price']) || empty($product['quantity'])) {

                continue;
            }

            $dbProduct = Product::find($product['id']);

            if ($dbProduct->quantity < $product['quantity']) {

                return redirect()->route('cart.index')->with('error', "Not enough stock for {$product['name']}.");
            }

            $dbProduct->quantity -= $product['quantity'];

            $dbProduct->save();

            $totalPrice += $product['price'] * $product['quantity'];

            $orderProducts[] = [
                'product_id' => $product['id'],
                'name' => $product['name'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'total' => $product['price'] * $product['quantity'],
                'image' => $product['image'],
            ];

            $productIds[] = $product['id'];
        }

        $concatenatedProductIds = implode(',', $productIds);

         Order::create([

            'name' => $request->input('name'),

            'email' => $request->input('email'),

            'address' => $request->input('address'),

            'country' => $request->input('country'),

            'payment_method' => $request->input('payment'),

            'total_price' => $totalPrice,

            'product_id' => $concatenatedProductIds,
        ]);

        // Send order confirmation email to the user
        Mail::to($request->input('email'))->send(new OrderConfirmationMail($orderProducts, $totalPrice));

        session()->forget('cart');

        session()->put('cartCount', 0);

        // Redirect to the success page
        return redirect()->route('order.success');
    }

     // Order success page
    public function success() {

        $order = Order::latest()->first();

        $productIds = explode(',', $order->product_id);

        $products = DB::table('products')->whereIn('id', $productIds)->select('id', 'name', 'image', 'price')->get(); // Get all the matching products

        $order->products = $products;

        return view('success.index', compact('order'));
    }
}
