<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provider extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'provider',
        'provider_id',
        'user_id',
        'avatar',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
