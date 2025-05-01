<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'component_type', 'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
