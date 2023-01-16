<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'myfile',
        'status',
        'parent_id'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],

        ];
    }


    // public function parent()
    // {
    //     return $this->belongsTo(self::class, 'parent_id'); //This Category Model belongs to Parent Category Model
    // }

    public function parentCategory()
    {
        return $this->belongsTo(self::class, 'parent_id'); //This Category Model belongs to Parent Category Model
        // return $this->parent()->with('parentCategory'); //This Category Model belongs to Parent Category Model

    }

    // public function categories()
    // {
    //     return $this->hasMany(self::class, 'parent_id'); //This Category model has many Child Categories Model
    // }

    public function childCategories()
    {
        return $this->hasMany(self::class, 'parent_id');

        // return $this->categories()->with('childCategories');
        // ->with('categories'); //This Category model has many Child Categories Model
    }

    public function theproducts()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }


    public function file()
    {
        return url('storage/' . $this->myfile);
    }
}
