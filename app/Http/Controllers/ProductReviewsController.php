<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductReviewCreateRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductReviewsController extends Controller
{
    public function __construct()
    {
        if (\Request::is('api*')) {
            $this->middleware(['auth:api'], ['except' => ['', '']]);
        }
    }

    public function store(ProductReviewCreateRequest $request, $slug) // Product $product, , $id
    {
        //$product = Post::find($id);
        $product = Product::where('slug', $slug)->first();

        // if ($product->reviewedBy($request->user())) {
        //     if (\Request::is('api*')) {
        //         return response()->json([ 'message' => 'already reviewed',
        //     ]);
        //     } else {
        //         return response(null, 409); //controller level protection //conflict http code
        //     }
        // }
        // dd(auth()->user());
        $review = $product->reviews()->create([
            'user_id' => $request->user()->id,
            'star' => $request->star,
            'comment' => $request->comment
        ]);


        //Mail::to($product->user)->send(new PostLiked($request->user(), $product));
        // if (!$product->likes()->onlyTrashed()->where('user_id', $request->user()->id)->count()) {
        //     Mail::to($post->user)->send(new ProductReviewed(auth()->user(), $product));
        // }

        if (\Request::is('api*')) {
            return response()->json([
                'message' => 'success',
                'review' => $review
            ]);
        } else {
            return back();
        }
    }

    public function destroy(Request $request, $id) //Product $product, 
    {
        $request->user()->reviews()->where('product_id', $id)->delete();

        return back();
    }
}
