<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'phone', 'product_title', 'price', 'quantity', 'is_single_product', 'configuration_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
