<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Repository\Product\ProductInterface;
use App\Repository\Category\CategoryInterface;
use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductUpdateRequest;

class ProductController extends Controller
{
    private $product, $category;

    public function __construct(ProductInterface $product, CategoryInterface $category)
    {
        $this->product = $product;
        $this->category = $category;

        // $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        // $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:product-delete', ['only' => ['destroy']]);

        if (\Request::is('api*')) {
            $this->middleware(['auth:api'], ['except' => ['', '']]);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->list();
        $categories = $this->category->getParentWithChildCategories();
        $reviews = $this->product->getReviewsDetails($products);

        // return view('product.index', compact('products', 'categories'));

        if (\Request::is('api/*')) {
            // return response()->json($products);
            // return ProductResource::collection($products);

            return new ProductCollection($products);
        } else {
            return view('product.index', compact('products', 'categories'));
        }
    }

    public function productList()
    {
        $products = $this->product->list();
        $categories = $this->category->getParentWithChildCategories();
        $reviews = $this->product->getReviewsDetails($products);
        // return view('product.index', compact('products', 'categories'));

        if (\Request::is('api/*')) {
            // return response()->json($products);
            // return ProductResource::collection($products);

            return new ProductCollection($products);
        } else {
            return view('product.product-checkout.product-list', compact('products', 'categories'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->category->getParentWithChildCategories();
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $pcrequest)
    {
        // dd($pcrequest);

        $data = $pcrequest->validated();
        // $data = $pcrequest->all();

        // dd($data);
        //Handle file upload
        if ($pcrequest->hasFile('pImage')) {
            //Get Filename with extension
            $fileNameWithExt = $pcrequest->file('pImage')->getClientOriginalName();
            //Get just filename //no laravel helper class so Pure PHP
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just Extension
            $extension = $pcrequest->file('pImage')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //upload image
            $path = $pcrequest->file('pImage')->storeAs('public/pImages', $fileNameToStore);

            $fileNameToStore = 'pImages/' . $fileNameToStore;
        } else {
            $fileNameToStore = '';
        }
        $data['pImage'] = $fileNameToStore;
        // dd($pcrequest->all());
        $productC =  $this->product->createS($data);
        // dd($productC);

        $productS = $this->product->createPS($data, $productC->id);

        if (\Request::is('api/*')) {
            return new ProductResource($productC);
            // return response()->json([
            //     'message' => 'product  successfully created'
            // ], 200);
        } else {
            return redirect()->route('product.index');
        }

        // return redirect()->route('product.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $editProduct = $this->product->findBySlug($slug);
        //dd($editProduct);
        $categories = $this->category->getParentWithChildCategories();
        // dd($editProduct);
        return view('product.edit', compact('editProduct', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $purequest, $slug)
    {
        // dd($purequest->title);
        // $data = $purequest->validated();
        $data = $purequest->all();
        dd($data);
        //Handle file upload
        if ($purequest->hasFile('pImage')) {
            //Get Filename with extension
            $fileNameWithExt = $purequest->file('pImage')->getClientOriginalName();
            //Get just filename //no laravel helper class so Pure PHP
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just Extension
            $extension = $purequest->file('pImage')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //upload image
            $path = $purequest->file('pImage')->storeAs('public/pImages', $fileNameToStore);
            $fileNameToStore = 'pImages/' . $fileNameToStore;
        } else {
            $fileNameToStore = '';
        }
        $data['fileNameToStore'] = $fileNameToStore;

        // dd($data);

        $productU =  $this->product->updateE($data, $slug);
        // dd($productU);
        //$productU = Product::where('slug',$slug)->first();
        $productSU = $this->product->updatePE($data, $productU->id);

        if (\Request::is('api/*')) {
            return new ProductResource($productU);
            // return response()->json([
            //     // $productU, $productSU,
            //     'message' => 'product  successfully updated'
            // ], 200);
        } else {
            return redirect()->route('product.index');
        }

        // return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {

        $product = $this->product->deleteE($slug);
        if (\Request::is('api*')) {
            return response()->json([
                'message' => $product->title . ' product deleted'
            ]);
        } else {
            return back();
        }

        // return back();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // dd('sdfsf');
        $showproduct = $this->product->findBySlug($slug);
        // dd($showproduct);
        $reviews = $this->product->getReviewsDetail($showproduct);

        // $ratings = Review::select('star', DB::raw('count(id) as count'))
        // ->groupBy('star')
        // ->get();
        // dd($ratings);
        // return view('product.show', compact('showproduct'));

        if (\Request::is('api/*')) {
            // return response()->json($showproduct);
            return new ProductResource($showproduct);
        } else {
            return view('product.show', [
                'showproduct' => $showproduct
            ]);
        }
    }

    public function searchProducts(Request $request)
    {
        // dd($request->all());

        $products = $this->product->getSearchProducts($request);
        // dd($products);
        // return json_encode($products);
        $view = view('product.tabledata', compact('products'))->render();

        // dd($view);
        return response()->json($view, 200);
    }

    // public function searchProductsCat(Request $request)
    // {
    //     // dd($request->all());

    //     $products = Product::where('category_id', $request->get('selectCategory'))->get();

    //     // dd($products);
    //     // return json_encode($products);

    //     $view = view('product.tabledata', compact('products'))->render();

    //     // dd($view);
    //     return response()->json($view, 200);
    // }

    // public function select2Search(Request $request)
    // {
    //     // dd('here');
    //     // $products = $this->product->getSearchProducts($request);
    //     $products = [];

    // $products = Product::select("id","title")->where('title', 'like', '%'. $request->q . '%' )->get();

    //     dd($products);
    //     return response()->json($products, 200);
    // }
}
