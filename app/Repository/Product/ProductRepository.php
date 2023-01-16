<?php

namespace App\Repository\Product;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSpecification;
use Illuminate\Support\Facades\Storage;

class ProductRepository implements ProductInterface
{
    public function list()
    {
        return Product::with(['thecategory'])->get();
    }

    public function getReviewsDetails($products)
    {
        // $reviews = $products[2]->reviews()->get();
        // dd($reviews);
        foreach ($products as $product) {
            // dd($product->reviews);
            if ($product->reviews) {
                // $reviews = $product->reviews->pluck('star')->toArray();
                $product->total_reviews = count($product->reviews);

                if (count($product->reviews) > 0) {
                    // $average_star = array_sum($reviews) / count($reviews);
                    $average_star = $product->reviews()->avg('star');
                    $product->avg_rating = $average_star; //Creating new attribute for $product
                }
            }
        }
    }



    public function createS($data)
    {
        return Product::create([
            'title' => $data['title'],
            'short_description' => $data['short_description'],
            'long_description' => $data['long_description'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
            'pImage' => $data['pImage'],
        ]);
    }

    public function createPS($data, $pid)
    {
        // dd($data);

        $keys = array_keys($data['spec']['title'] ?? []);
        //or
        // $keys  = array_keys($data['spec']); //or $title[]

        // dd($keys);
        //$keys :array // [$keys] :array of array keys 

        // dd($data['spec']['title'][$keys[0]]); //gives value of spec[title] at 0th index
        // dd($data['spec']['specification'][$keys[0]]); //gives value of spec[specification] at 0th index

        // dd([$keys]);// array inside array
        // dd($data['spec']['title']); //array of spec[title]

        foreach ($keys as $key) {
            // foreach ($data->spec[$key] as $y => $value) {
            // }
            ProductSpecification::create([
                'title' => $data['spec']['title'][$key],
                'product_id' => $pid,
                'description' => $data['spec']['specification'][$key]
            ]);
        }

        // $countt = count($data['spec_title']);
        // $spec = [];

        // for($i = 0; $i < count($data['spec']['title']); $i++){
        //     ProductSpecification::create([
        //         'title' => $data['spec']['title'][$i],
        //         'product_id' => $pid,
        //         'description' => $data['spec']['description'][$i]
        //     ]);

        // }


        // dd($data['spec']['title']);
        //     foreach ($data['spec']['title'] as $value) {
        //         ProductSpecification::create([
        //             'title' => $value['title'],
        //             'product_id' => $pid,
        //             'description' => $data['specification']

        //         ]);
        //     }
        //dd($spec);


    }


    public function findBySlug($slug)
    {
        // dd(Product::with(['theSpecifications'])->where('slug', $slug)->first());
        return Product::with(['theSpecifications', 'thecategory'])->where('slug', $slug)->first();
    }

    public function getReviewsDetail($product)
    {
        // $reviews = $products->reviews()->get();
        // dd($products->toArray());

        $star1 = 0;
        $star2 = 0;
        $star3 = 0;
        $star4 = 0;
        $star5 = 0;

        // dd($this->reviews);
        foreach ($product->reviews as $review) {
            // dd($review->star);
            switch ($review->star) {
                case 1:
                    $star1++;
                    break;
                case 2:
                    $star2++;
                    break;
                case 3:
                    $star3++;
                    break;
                case 4:
                    $star4++;
                    break;
                case 5:
                    $star5++;
                    break;
                default:
                    break;
            }
        }
        $product->star1 = $star1;
        $product->star2 = $star2;
        $product->star3 = $star3;
        $product->star4 = $star4;
        $product->star5 = $star5;

        // $reviews = $product->reviews->pluck('star')->toArray();

        // dd(count($product->reviews));
        $product->total_reviews = count($product->reviews);
        if (count($product->reviews) > 0) {
            // $average_star = array_sum($reviews) / count($reviews);
            $average_star = $product->reviews->avg('star');
            $product->avg_rating = $average_star;
        }
    }


    public function updateE($data, $slug)
    {
        $product = Product::where('slug', $slug)->first();
        $product->update([
            'title' => $data['title'],
            'short_description' => $data['short_description'],
            'long_description' => $data['long_description'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
            'status' => $data['status'],
        ]);
        if ($data['fileNameToStore']) {
            $product->update([
                'pImage' => $data['fileNameToStore']
            ]);
        }

        // dd($product);
        return $product;
    }

    public function updatePE($data, $pid)
    {
        // dd($data);
        $keys = array_keys($data['spec']['title'] ?? []);

        // dd($keys);
        // dd($data['spec']['title'][$keys[3]]);

        // dd([$keys[3]]);//gives array of all keys
        // dd($keys[3]);//gives value of array keys at index 3. e.g random id or id

        //delete removed specs
        ProductSpecification::whereIn('id', $data['deleted_ids'] ?? [])->delete(); //multiple row delete

        //addOredit
        foreach ($keys as $key) {
            // dd($key);//gives value of id e.g. 35 or random id for new in edit
            // dd([$key]); //gives array of id e.g. 0 => 35 (key=>vaule pair) , [$key] gives value at key
            // dd($data['spec']['specification'][$key]);
            // dd($data['spec']['title'][$keys[3]]);

            ProductSpecification::updateOrCreate([
                'id' => $key, //update ProductSpecification where 'id' is  $key with new data // if not matching then create new in {auto id } row

            ], [
                'title' => $data['spec']['title'][$key], //if random id, then create new and id is assigned in db auto. 
                'product_id' => $pid,
                'description' => $data['spec']['specification'][$key]
            ]);
        }

        // for($i = 0; $i < count($data['spec']['title']); $i++){
        //     ProductSpecification::where('id',$data['spec']['title']['id'])->update([
        //         'title' => $data['spec']['title'][$i],
        //         'product_id' => $pid,
        //         'description' => $data['spec']['description'][$i]
        //     ]);

        // }

        //     dd($data);        
    }

    public function deleteE($slug)
    {
        // dd($slug);
        $product = Product::where('slug', $slug)->first();
        // dd($product);
        if ($product->pImage != '') {
            Storage::delete('public/pImages/' . $product->pImage);
        }
        $product->delete();
        return $product;
    }

    public function getSearchProducts($data)
    {
        $products = Product::query(); // at beginning similar to Product:: but query is specified later
        if ($data->get('selectCategory')) {

            $products = $products->where('category_id', $data->get('selectCategory'));
        }
        if ($data->get('selectStatus')) {

            $products = $products->where('status', $data->get('selectStatus'));
        }
        if ($data->get('fromprice') && $data->get('toprice')) {

            $products = $products->whereBetween('price', [$data->get('fromprice'), $data->get('toprice')]);
        }
        if ($data->get('searchP')) {
            $products = $products->where('title', 'like', '%' . $data->get('searchP') . '%');
        }

        // dd($data->all());

        //HERE ONE QUESTION, how index method is called at first

        // $products = Product::where('title', 'like', '%'. $data->searchP . '%' )->get();

        return $products->get();
    }
}
