<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['guest']);
        // $this->middleware(['auth:api'], ['except' => ['store']]);
    }

    public function store(Request $request)
    {

        if ($request->is('api/*')) {
            $user = auth('api')->user();
            // dd($user->username);

            Auth::guard('api')->logout();
            return response()->json([
                'message' => 'user '.$user->username.' successfully logged out'
            ]);
        } else {
            Auth::logout();
            return redirect()->route('login')->with('success', 'Logged Out');
        }
    }
}
