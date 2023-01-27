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
        $products = Product::where('category_id', $data['category'])
                                ->orderBy('price', 'desc')
                                ->paginate(config('const.paginate'));
        $total_count = Product::where('category_id', $data['category'])
                                ->count();
        $category = Category::find($data['category']);
        $major_category = MajorCategory::find($category->major_category_id);

        $category_request = [
            'products' => $products,
            'category' => $category,
            'categories' => Category::all(),
            'major_categories' => MajorCategory::all(),
            'major_category' => $major_category,
            'total_count' => $total_count,
        ];
        // logger($category_request);

        return $category_request;
    }
}