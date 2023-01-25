<?php

namespace App\Service;

use App\Models\Category;
use App\Models\Product;
use App\Models\MajorCategory;
use App\Http\Controllers\ProductController;

class ProductIndexService 
{
    public function excute(array $data)
    {
        logger($data['category']);
        // if($data['category'] !== null){
        $products = Product::where('category_id', $data['category']);
        $total_count = Product::where('category_id', $data['category'])
            ->count();
        $category = Category::find($data['category']);
        $major_category = MajorCategory::find($category->major_category_id);
        // }else{
            // $products = new Product;
            // $total_count = "";
            // $category = null;
            // $major_category = null;
        // }

        $products =Product::sortable()
            ->orderBy('price', 'desc')
            ->paginate(config('const.paginate'));

        $category_request = [
            'products' => $products,
            'category' => $category,
            'categories' => Category::all(),
            'major_categories' => MajorCategory::all(),
            'major_category' => $major_category,
            'total_count' => $total_count,
        ];
        logger($category_request);

        return $category_request;
    }
}