<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['guest']);
        // $this->middleware(['auth:api'], ['except' => ['store', 'index']]);

    } 
    
    public function index()
    {
        return view('admin.register');
    }


    public function store(RegisterRequest $registerrequest)
    {

        $user = User::create([
            'name' => $registerrequest->name,
            'email' => $registerrequest->email,
            'username' => $registerrequest->username,
            'password' => Hash::make($registerrequest->password)
        ]);
        if ($registerrequest->expectsJson()) {
            return response()->json([
                'message' => 'User created successfully',
                'user' => $user
            ], 201);
        }
        else{
            return redirect()->route('login')->with('success','User created successfully');
        }

    }
}
