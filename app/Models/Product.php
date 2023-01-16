<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use App\Models\Category;
use App\Models\ProductSpecification;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'long_description',
        'category_id',
        'pImage',
        'status',
        'price',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],

        ];
    }


    public function thecategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function theSpecifications()
    {
        return $this->hasMany(ProductSpecification::class, 'product_id'); //OneToMany
    }


    public function file()
    {
        return url('storage/' . $this->pImage);
    }
   

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function reviewedBy(User $user)
    {
        // dd($this->reviews->contains('user_id', $user->id));
        return $this->reviews->contains('user_id', $user->id); 
        //contains is laravel collection method
    }

    // public function products()
    // {
    //     return $this->hasMany(Order::class, 'product_order');
    // }

}
