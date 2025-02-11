<?php

// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'address',
        'country',
        'payment_method',
        'total_price',
        'product_id',
        'quantity',
        'product_id'
    ];

    // You can also get the product from the product_id directly if you need it
    public function product()
    {
        return $this->belongsTo(Product::class, 'id');
    }
}
