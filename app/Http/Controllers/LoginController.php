<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Provider;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;

class LoginController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['guest']);
        // if (\Request::is('api*')) {
        // }
        $this->middleware(['auth:api'], ['except' => ['store', 'index', 'loginGithub', 'loginGithubRedirect', 'loginGoogle', 'loginGoogleRedirect', 'loginFacebook', 'loginFacebookRedirect']]);
    }

    public function index()
    {
        return view('admin.login');
    }

    public function store(LoginRequest $loginrequest)
    {
        // if ($loginrequest->expectsJson()) {
        //     // api() //Auth::guard('api')
        //     if (!$token = auth('api')->attempt($loginrequest->only('email', 'password'))) {
        //         return response()->json(['error' => 'Unauthorized'], 401);
        //     }
        //     return $this->createNewToken($token);
        //     // return $this->respondWithToken($token);    

        // } else {
        //     // dd(Auth::attempt($loginrequest->only('email', 'password')));
        //     if (Auth::attempt($loginrequest->only('email', 'password'))) {
        //         return redirect()->route('dashboard')->with('success', 'User Logged In');
        //     }
        //     return back()->with('error', 'Credentials do not match')
        //         ->withErrors(['email' => 'The provided credentials do not match our records.']);
        // }

        if ($loginrequest->is('api/*')) {
            if (!$token = auth('api')->attempt($loginrequest->only('email', 'password'))) {
                return response()->json(['error' => 'Unauthorized ep'], 401);
            }
            return $this->createNewToken($token);
        } else {
            if (Auth::attempt($loginrequest->only('email', 'password'))) {
                return redirect()->route('dashboard')->with('success', 'User Logged In');
            }
            return back()->with('error', 'Credentials do not match')
                ->withErrors(['email' => 'The provided credentials do not match our records.']);
        }
    }


    public function refresh()
    {
        return $this->createNewToken(auth('api')->refresh());
    }

    public function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 5400,
            // 'expires_in' => auth()->factory()->getTTL()*60 ,
            'user' => auth('api')->user(),
        ]);
    }


    public function profile()
    {
        if (\Request::is('api*')) {
            return response()->json(auth('api')->user());
            // return response()->json(auth()->user());

            // try {
            //         $user = auth('api')->userOrFail();
            //                 return response()->json($user);
            //     } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            //         return response()->json($e, 400);
            //     }

        }
    }

    // try {
    //     $user = auth()->userOrFail();
    // return response()->json(auth('api')->user());
    // } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
    //     return response()->json($e);
    // }


    // if( identifier == "web")
    // {
    //     return view('backend.access.create');
    //     // return view("path to view'');
    // }
    // else
    // {
    //     // return response()->json(array_here);
    //     return response()->json(['name' => 'Abigail', 'state' => 'CA']);
    // }


    public function loginGithub()
    {
        //send the user request to github
        // dd('k xa?');
        // dd(Socialite::driver('github')->stateless()->redirect());
        return Socialite::driver('github')->stateless()->redirect();
    }

    public function loginGithubRedirect()
    {
        //get oauth request back from github to authenticate user
        // $user = Socialite::driver('github')->user();
        // dd('asd');
        // dd(Socialite::driver('github')->stateless()->user());

        $user = Socialite::driver('github')->stateless()->user();

        // dd($user);

        //if user doesn't exist, add them
        //if they do get them,
        //either way, authenticate the user into the application and redirect afterwards
        $user = User::firstOrCreate(
            ['email' => $user->email],
            [
                'name' => $user->name,
                'password' => Hash::make(Str::random(10))
            ]
        );
        // dd($user);
        if (\Request::is('api/*')) {
            if (!$token = $user->token) {
                // dd($token);
                return redirect()->json(['error' => 'Unauthorized creds'], 401);
            }
            return $this->createNewToken($token);
        } else {
            Auth::login($user, true);
            return redirect()->route('dashboard')->with('success', 'User Logged In');
        }
    }


    public function loginFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function loginFacebookRedirect()
    {
        $user = Socialite::driver('facebook')
            ->stateless()
            ->user();
        $user = User::firstOrCreate(
            [
                'email' => $user->email,
            ],
            [
                'name' => $user->name,
                'password' => Hash::make(Str::random(10))
            ]
        );
        if (\Request::is('api/*')) {
            if (!$token = Auth::guard('api')->login($user, true)) {
                return redirect()->json(['error' => 'Unauthorized creds'], 401);
            }
            return $this->createNewToken($token);
        } else {
            Auth::login($user, true);
            return redirect()->route('dashboard');
        }
    }


    public function loginGoogle($providerN)
    {
        return Socialite::driver($providerN)->redirect();
        // dd('sd');
    }

    public function loginGoogleRedirect($providerN)
    {
        $social_user = Socialite::driver($providerN)
            ->stateless()
            ->user();

        // dd($user);   

        $provider = Provider::where('provider_id', $social_user->getId())->first();
        if (!$provider) {
            // dd('asdf');
            $user = User::firstOrCreate(
                [
                    'email' => $social_user->email,
                ],
                [
                    'name' => $social_user->name,
                    'password' => Hash::make(Str::random(10)),
                    // 'remember_token' => null
                ]
            );
            // dd($user);
            //$user_id filled with relationship
            $user->providers()->create(
                [
                    'provider_id' => $social_user->id,
                    'provider' => $providerN,
                    'avatar' => $social_user->avatar
                ]
            );
            // dd($user);
        } else {
            $user = $provider->user;
        }
        if (\Request::is('api/*')) {
            if (!$token = Auth::guard('api')->login($user, true)) {
                return redirect()->json(['error' => 'Unauthorized creds'], 401);
            }
            return $this->createNewToken($token);
        } else {
            Auth::login($user, true);
            return redirect()->route('dashboard');
        }
    }






    // public function loginProvider($providerN)
    // {
    //     $validated = $this->validateProvider($provider);
    //     if (!is_null($validated)) {
    //         return $validated;
    //     }

    //     return Socialite::driver($providerN)->stateless()->redirect();
    // }



    // public function loginProviderCallback($providerN)
    // {
    //     $validated = $this->validateProvider($providerN);
    //     if (!is_null($validated)) {
    //         return $validated;
    //     }

    //     try {
    //         $user = Socialite::driver($provider)->stateless()->user();
    //     } catch (ClientException $exception) {
    //         return response()->json(['error' => 'Invalid credentials provided.'], 422);
    //     }

    //     dd($user);

    //     $userCreated = User::firstOrCreate(
    //         [
    //             'email' => $user->email()
    //         ],
    //         [
    //             // 'email_verified_at' => now(),
    //             'name' => $user->name(),
    //             // 'status' => true,
    //         ]
    //     );
    //     $userCreated->providers()->updateOrCreate(
    //         [
    //             'provider' => $provider,
    //             'provider_id' => $user->id(),
    //         ],
    //         [
    //             'avatar' => $user->getAvatar()
    //         ]
    //     );
    //     $token = JWTAuth::fromUser($userCreated);
    //     dd($token);
    //     if (!$token) {
    //         return response()->json(['error' => 'invalid_credentials'], 401);
    //     }
    //     // return response()->json($token, 200, ['Access-Token' => $token]);
    //     return $this->createNewToken($token);
    //     // if (\Request::is('api/*')) {
    //     //     if (!$token = Auth::guard('api')->login($user, true)) {
    //     //         // return redirect()->json(['error' => 'Unauthorized creds'], 401);
    //     //     }
    //     //     return $this->createNewToken($token);
    //     // } else {
    //     //     if (Auth::login($user, true)) {
    //     //         // return redirect()->route('dashboard');
    //     //     }
    //     //     // return back()->with('error', 'Credentials do not match')
    //     //     //     ->withErrors(['email' => 'The provided credentials do not match our records.']);
    //     // }
    // }




    // protected function validateProvider($provider)
    // {
    //     if (!in_array($provider, ['facebook', 'github', 'google'])) {
    //         if (\Request::is('api/*')) {
    //             return response()->json(['error' => 'Please login using facebook, github or google'], 422);
    //         } else {
    //             return back()->with('error', 'Please login using facebook, github or google');
    //         }
    //     }
    // }
}
