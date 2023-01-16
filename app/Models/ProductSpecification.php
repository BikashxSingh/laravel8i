<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSpecification extends Model
{
    protected $table = 'product_specifications';
    use HasFactory;
    protected $fillable = [
        'title',
        'product_id',
        'description',
    ];

    public function theProduct()
    {
        return $this->belongsTo(Product::class, 'product_id'); //OneToMany(Inverse)
    }
}
