
<?php

use App\Events\Message;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatSecondExampleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatFirstExampleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Pay\EsewaController;
use App\Http\Controllers\Pay\OrderController;
use App\Http\Controllers\Pay\KhaltiController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Pay\FonepayController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return 'hello world';
    return view('welcome');
});

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LogoutController::class, 'store'])->name('logout.store');

Route::get('/login/github', [LoginController::class, 'loginGithub'])->name('login.github');
Route::get('/login/github/redirect', [LoginController::class, 'loginGithubRedirect']);

Route::get('/login/{providerN}', [LoginController::class, 'loginGoogle'])->name('login.google');
Route::get('/login/{providerN}/redirect', [LoginController::class, 'loginGoogleRedirect'])->name('login.google.redirect');

Route::get('/login/facebook', [LoginController::class, 'loginFacebook'])->name('login.facebook');
Route::get('/login/facebook/redirect', [LoginController::class, 'loginFacebookRedirect']);

// Route::get('/login/{provider}', [LoginController::class, 'loginProvider'])->name('login.provider');
// Route::get('/login/{provider}/redirect', [LoginController::class, 'loginProviderRedirect']);

Route::group(['prefix' => 'chat-first-example'], function () {
    Route::get('/chat', [ChatFirstExampleController::class, 'chat'])->name('chat-first-example.public');
    // Route::post('/chat/send-message', function (Request $request) {
    //     event(
    //         new Message(
    //             $request->input('username'),
    //             $request->input('message')
    //         )
    //     );
    //     return ["success" => true];
    // });
    Route::post('/chat/send-message', [ChatFirstExampleController::class, 'chatSendMessage'])->name('chat-first-example.public.sendMessages');
    Route::get('/chat-users', [ChatFirstExampleController::class, 'chatUsers'])->name('chat-first-example.users');
    Route::get('/personal-chat/{id}', [ChatFirstExampleController::class, 'personalChat'])->name('chat-first-example.personal');
    Route::get('/chat/messages', [ChatFirstExampleController::class, 'fetchMessages'])->name('chat-first-example.fetchMessages');
    Route::post('/chat/messages', [ChatFirstExampleController::class, 'sendMessage'])->name('chat-first-example.sendMessages');
});

Route::group(['prefix' => 'chat-second-example', 'as' => 'chat-second-example.'], function () {
    Route::get('/home', [ChatSecondExampleController::class, 'index'])->name('home');
    Route::get('/message/{id}', [ChatSecondExampleController::class, 'getMessage'])->name('getMessage');
    Route::post('message', [ChatSecondExampleController::class, 'sendMessage'])->name('sendMessage');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
});



//You can add auth() middleware in Controller for authentication      OR
Route::group([
    'middleware' => ['auth'],
    'prefix' => 'admin'
], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    // Route::get('/product-list', function () {
    //     $products = Product::all();
    //     return view('product.product-checkout.product-list', compact('products'));
    // })->name('product-list');
    // Route::post('/checkout', function (Request $request) {
    //     $product = Product::where('id', $request->pid)->first();
    //     return view('product.product-checkout.checkout', compact('product'));
    // })->name('checkout');

    Route::get('/product-list', [ProductController::class, 'productList'])->name('product-list');


    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');

    Route::post('/main', [EsewaController::class, 'main'])->name('main'); //PHP-PAY

    Route::any('/esewa/success', [EsewaController::class, 'success'])->name('esewa.success');
    Route::any('/esewa/fail', [EsewaController::class, 'fail'])->name('esewa.fail');
    Route::get('/esewa/fail/{id}', [EsewaController::class, 'fail'])->name('esewa.fail.cancel');
    Route::get('/payment/response', [EsewaController::class, 'payment_response'])->name('payment.response');

    Route::any('/fonepay/return', [FonepayController::class, 'fonepay_response'])->name('fonepay.return');


    Route::any('/khalti/success', [KhaltiController::class, 'success'])->name('khalti.success');
    Route::any('/khalti/fail', [KhaltiController::class, 'fail'])->name('khalti.fail');


    Route::get('/category/index', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/create', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{slug}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/{slug}/edit', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{slug}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

    Route::post('/category/search', [CategoryController::class, 'searchCategories'])->name('category.search');

    Route::get('/product/index', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/create', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{slug}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/{slug}/edit', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{slug}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

    Route::post('/product/search', [ProductController::class, 'searchProducts'])->name('product.search');

    Route::post('/product/searchCat', [ProductController::class, 'searchProductsCat'])->name('product.searchCat'); //

    Route::get('/product/select2search', [ProductController::class, 'select2Search'])->name('select2.search'); //

});
