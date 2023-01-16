<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Category\CategoryCreateRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Repository\Category\CategoryInterface;

class CategoryController extends Controller
{
    private $category;

    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;

        // $this->middleware('auth');

        // $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index', 'show']]);
        // $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:category-delete', ['only' => ['destroy']]);
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
        //$categories = Category::get();

        //Repo
        $categories = $this->category->list();
        // dd($categories);
        // $parentCategories = $this->category->getParentCategories();
        $parentCategories = $this->category->getParentWithChildCategories();

        // dd($parentCategories->toArray());
        // return view('category.index', [
        //     'categories' => $categories,
        //     'parentCategories' => $parentCategories
        // ]);

        if (\Request::is('api/*')) {
            // return CategoryResource::collection($categories);
            return [
                'all' => new CategoryCollection($categories),
                'parent' => new CategoryCollection($parentCategories),
            ];
        } else {
            // $categories = $this->category->list();
            // $parentCategories = $this->category->getParentCategories();
            return view('category.index', [
                'categories' => $categories,
                'parentCategories' => $parentCategories
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $parentCategories = $this->category->getParentCategories();
        // $parentCategories = $this->category->list();

        $parentCategories = $this->category->getParentWithChildCategories();
        // dd($parentCategories->toArray());
        return view('category.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $crequest)
    {

        // dd(asdfghjk);
        // return 'hello world';
        //dd($crequest);
        // $data = $crequest->validated();
        // dd($data);
        //Handle file upload
        if ($crequest->hasFile('myfile')) {
            //Get Filename with extension
            $fileNameWithExt = $crequest->file('myfile')->getClientOriginalName();
            //Get just filename //no laravel helper class so Pure PHP
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just Extension
            $extension = $crequest->file('myfile')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //upload image
            $path = $crequest->file('myfile')->storeAs('public/myfiles', $fileNameToStore);
            $fileNameToStore = 'myfiles/' . $fileNameToStore;
        } else {
            $fileNameToStore = '';
        }
        // $data['fileNameToStore'] = $fileNameToStore;


        // Category::create([
        //     'title' => $crequest->title,
        //     'myfile' => $fileNameToStore,
        // ]);
        // OR
        //$crequest->category->create([
        //     'title' => $crequest->title,        
        //     'myfile' => $fileNameToStore

        //'model-column-name{database-column}' => 'entered-data'

        // ]);
        //      OR
        //using Repo
        $category = $this->category->createS($crequest->title, $fileNameToStore, $crequest->parent_id);
        // $category = $this->category->createS($data);

        if (\Request::is('api/*')) {

            return new CategoryResource($category);
            // return response()->json([
            //     'message' => 'category '.$category->title.' successfully created'
            // ], 200);

        } else {
            return redirect()->route('category.index');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //$category = Category::where('slug', $slug)->first();

        //Repo
        $category = $this->category->editMain($slug);
        $parentCategories = $this->category->getParentWithChildCategories();

        return view('category.edit', [
            'category' => $category,
            'parentCategories' => $parentCategories

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $urequest, $slug)
    {
        // dd(das);
        $data = $urequest->validated();
        // dd($data);
        //Handle file upload
        if ($urequest->hasFile('myfile')) {
            //Get Filename with extension
            $fileNameWithExt = $urequest->file('myfile')->getClientOriginalName();
            //Get just filename //no laravel helper class so Pure PHP
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just Extension
            $extension = $urequest->file('myfile')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //upload image
            $path = $urequest->file('myfile')->storeAs('public/myfiles', $fileNameToStore);
            $fileNameToStore = 'myfiles/' . $fileNameToStore;
        } else {
            $fileNameToStore = '';
        }
        $data['fileNameToStore'] = $fileNameToStore;
        // $data['myfile'] = $fileNameToStore;

        //$category = Category::where('slug', $slug)->first();

        // $category->update([
        //     'title' => $urequest->title,
        //     'myfile' => $fileNameToStore,
        //     'status' => $urequest->status
        // ]);

        // dd($data);
        //Repo
        $category = $this->category->updateE($data, $slug);

        // if($urequest->hasFile('myfile')){
        //     $category->update(['myfile' => $fileNameToStore]);}

        // dd($category);



        if (\Request::is('api/*')) {

            return new CategoryResource($category);
            //             return response()->json([
            //     'message' => 'category  successfully updated'
            // ], 200);

        } else {
            return redirect()->route('category.index');
        }
        // return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        //     $category = Category::where('slug', $slug)->first();
        //     if($category->myfile != 'noimage.jpg'){
        //         Storage::delete('public/myfiles/'.$category->myfile);
        //     }
        //    $category->delete();

        // $category = $this->category->show1($slug);

        $category = $this->category->delete($slug);
        if (\Request::is('api/*')) {
            return response()->json([
                'message' => 'category ' . $category->title . ' successfully deleted'
            ], 200);
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
        //$category = Category::where('slug', $slug)->first();

        //Repo
        $category = $this->category->show1($slug);

        // return view('category.show', [
        //     'category' => $category
        // ]);
        // dd($category->childCategories());

        if (\Request::is('api/*')) {
            // return [
            //     'data'=> new CategoryResource($category),
            // ];
            return new CategoryResource($category);
            // return response()->json($category);
        } else {
            return view('category.show', [
                'category' => $category
            ]);
        }
    }


    public function searchCategories(Request $request)
    {
        $categories = $this->category->getSearchCategories($request);

        $view = view('category.tabledata', compact('categories'))->render();

        return response()->json($view, 200);
    }
}
