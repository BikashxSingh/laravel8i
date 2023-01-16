<?php

namespace App\Repository\Category;

interface CategoryInterface
{
    public function list();

    public function getParentCategories();

    public function getParentWithChildCategories();

    public function createS($title, $filename, $parent_id);

    public function editMain($slug1);

    public function updateE($data1, $slug1);

    public function delete($slug);

    public function show1($slug);

    public function getSearchCategories($request);
}
