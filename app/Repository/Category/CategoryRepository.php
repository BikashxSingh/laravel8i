<?php

namespace App\Repository\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryRepository implements CategoryInterface
{
    public function list()
    {
        // return Category::get();
        return Category::paginate(2);

        // return Category::with(['parentCategory'])->get();
        // return Category::with(['parentCategory', 'childCategories'])->get();
        
        // return Category::with(['parentCategory', 'childCategories.childCategories'])->get();

    }

    public function getParentCategories()
    {
        return Category::where('parent_id', null)->get();
    }

    public function getParentWithChildCategories()
    {
        // return Category::where('parent_id', null)
        //     // ->childCategories()
        //     ->with(['childCategories.childCategories'])
        //     ->get();
        return Category::where('parent_id', null)
        // ->childCategories()
        ->with(['childCategories.childCategories'])
        ->paginate(1);

    }

    public function createS($title, $filename, $parent_id)
    {
        return Category::create([
            'title' => $title,
            'myfile' => $filename,
            'parent_id' => $parent_id
        ]);
    }


    public function editMain($slug2)
    {
        return Category::with(['parentCategory'])->where('slug', $slug2)->first();
    }

    public function updateE($data2, $slug2)
    {

        $category = Category::where('slug', $slug2)->first();
        $category->update([
            'title' => $data2['title'],
            'status' => $data2['status'],
            'parent_id' => $data2['parent_id']
        ]);
        if ($data2['fileNameToStore']) {
            $category->update([
                'myfile' => $data2['fileNameToStore']
            ]);
        }
        return $category;
    }

    public function delete($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if ($category->myfile != '') {
            Storage::delete('public/myfiles/' . $category->myfile);
        }
        $category->delete();
        return $category;
    }

    public function show1($slug)
    {
        $category = Category::with(['parentCategory'])->where('slug', $slug)->first();
        // $category = Category::with(['parentCategory.parentCategory', 'childCategories.childCategories.childCategories'])->where('slug', $slug)->first();
        // $category = Category::with(['parentCategory', 'childCategories'])->where('slug', $slug)->first();
        // dd($category);
        return $category;
    }

    public function getSearchCategories($request)
    {

        $categories = Category::query();
        if ($request->get('selectCategory')) {

            $categories = $categories->where('parent_id', $request->get('selectCategory'));
        }
        if ($request->get('selectStatus')) {

            $categories = $categories->where('status', $request->get('selectStatus'));
        }
        // $categories = Category::where('title', 'like', '%'. $request->get('searchC') . '%' )->get();

        return $categories->get();
    }
}
