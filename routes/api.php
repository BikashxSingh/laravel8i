<?php

use App\Events\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProductReviewsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/users', [
//     'as' => 'users.index',
//     'uses' => 'Api\RegisterController@index'
// ]);


// Route::middleware('api')->prefix('v1')->group(function () {
//     Route::post('/register', [RegisterController::class], 'store');
//     Route::post('/login', [LoginController::class], 'store');
//     Route::post('/logout', [LogoutController::class], 'store');

//     // Route::get('/user', [UserController::class], 'index');
// });

// , 'accept_json'
// Route::group([ 'prefix' => 'v1'], function ($router) {
Route::group(['middleware' => ['api'], 'prefix' => 'v1'], function ($router) {
    Route::post('/register', [RegisterController::class, 'store']);
    Route::post('/login', [LoginController::class, 'store']);
    Route::post('/logout', [LogoutController::class, 'store']);
    Route::get('/profile', [LoginController::class, 'profile']);
    Route::get('/refresh', [LoginController::class, 'refresh']);
    Route::get('/login/github', [LoginController::class, 'loginGithub']);
    Route::get('/login/github/redirect', [LoginController::class, 'loginGithubRedirect']);

    Route::get('/login/{providerN}', [LoginController::class, 'loginGoogle'])->name('login.google');
    Route::get('/login/{providerN}/redirect', [LoginController::class, 'loginGoogleRedirect'])->name('login.google.redirect');

    // Route::get('/category/{slug}', [CategoryController::class, 'show']);
    // Route::get('/category', [CategoryController::class, 'index']);

    // Route::get('/product/{slug}', [ProductController::class, 'show']);
    // Route::get('/product', [ProductController::class, 'index']);


    Route::apiResource('/category', CategoryController::class);
    Route::apiResource('/product', ProductController::class);

    // Route::post('/category', [CategoryController::class, 'store']);
    // Route::put('/category/{slug}', [CategoryController::class, 'update']);

    Route::post('/product/{slug}/reviews', [ProductReviewsController::class, 'store']);
    // Route::get('/product/{slug}/reviews', [ProductReviewsController::class, 'index']);
    // Route::put('/product/{slug}/reviews/{id}', [ProductReviewsController::class, 'update']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);


    Route::get('/chat-users', [ChatsController::class, 'chatUsers'])->name('chat.users');
    Route::get('/personal-chat/{id}', [ChatsController::class, 'personalChat'])->name('chat.personal');
    // Route::get('/chat/messages/{id}', [ChatsController::class, 'fetchMessages'])->name('chat.fetchMessages');
    Route::post('/chat/messages', [ChatsController::class, 'sendMessage'])->name('chat.sendMessages');
});


// Route::group([ 'prefix' => 'v1'], function ($router) {
 
// Route::get('/chat', [ChatsController::class, 'index']);
// Route::post('/chat/send-message', function (Request $request) {
//     event(
//         new Message(
//             $request->input('username'),
//             $request->input('message')
//         )
//     );
//     return response()->json([
//         'username' => $request->username,
//         'message' => $request->message
//     ]);
//     // return ["success" => true];
// });

// });