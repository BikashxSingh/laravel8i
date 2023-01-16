<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Review;
use App\Models\Message;
use App\Models\Product;
use App\Models\Category;
use App\Models\Provider;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    public function category()
    {
        return $this->hasMany(Category::class);
    }

    // public function product()
    // {
    //     return $this->hasMany(Product::class);
    // }

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'users_roles');
    // }

    // public function permission()
    // {
    //     return $this->belongsToMany(Permission::class, 'users_permissions');
    // }

    public function providers()
    {
        return $this->hasMany(Provider::class, 'user_id');
    }
    
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }


    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    
    public function receivedReviews()
    {
        return $this->hasManyThrough(Review::class, Product::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'from');
    }

}
