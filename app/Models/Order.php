<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'total', 'invoice_no', 'status'];

    // public function orders()
    // {
    //     return $this->hasMany(Product::class, 'product_order');
    // }
}
