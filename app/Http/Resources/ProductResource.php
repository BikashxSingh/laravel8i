<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductReviewResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $star1 = 0;
        // $star2 = 0;
        // $star3 = 0;
        // $star4 = 0;
        // $star5 = 0;

        // // dd($this->reviews);
        // foreach ($this->reviews as $review) {
        //     // dd($review->star);
        //     switch ($review->star) {
        //         case '1':
        //             $star1++;
        //             break;
        //         case '2':
        //             $star2++;
        //             break;
        //         case '3':
        //             $star3++;
        //             break;
        //         case '4':
        //             $star4++;
        //             break;
        //         case '5':
        //             $star5++;
        //             break;

        //         default:
        //             // 'No reviews';
        //             break;
        //     }
        // }

        // $reviews = $this->reviews->pluck('star')->toArray();
        // if (count($reviews) > 0) {
        //     $average_star = array_sum($reviews) / count($reviews);
        // }

        return ([
            'id' => (string)$this->id,
            'type' => 'product',
            'attributes' => [
                'title' => $this->title,
                'slug' => $this->slug,
                'short_description' => $this->short_description,
                'long_description' => $this->long_description,
                'category' => new CategoryResource($this->thecategory),
                'pImage' => $this->pImage ? asset(Storage::url($this->pImage)) : null,
                'status' => $this->status,
                'price' => $this->price,
                'created_at' => (string)$this->created_at,
                'updated_at' => (string)$this->updated_at,
            ],

            'specifications' => ProductSpecificationResource::collection($this->theSpecifications),
            'reviews' => ProductReviewResource::collection($this->reviews),
            'total_reviews' => $this->total_reviews,
            'avg_rating' => $this->avg_rating,
            'rating_type' => [
                'star1 ' => $this->star1,
                'star2 ' => $this->star2,
                'star3 ' => $this->star3,
                'star4 ' => $this->star4,
                'star5 ' => $this->star5,
            ],
            // 'reviewers' => new ProductResource($this->reviewedBy($this->user)),
        ]);
    }
}
