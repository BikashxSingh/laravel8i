<?php

namespace App\Repository\Product;

interface ProductInterface
{
    public function list();

    public function getReviewsDetails($products);
    
    public function getReviewsDetail($product);


    public function createS($data);
    public function createPS($data, $pid);

    public function findBySlug($slug);
    // public function showP($slug);

    public function updateE($data, $slug);

    public function updatePE($data, $pid);

    public function deleteE($slug);

    public function getSearchProducts($data);
}
