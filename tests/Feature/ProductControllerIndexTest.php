<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\ProductController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Database\factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mockery;
use Mockery\MockInterface;
use App\Models\Product;
use App\Models\Category;
use App\Models\MajorCategory;
use App\Service\ProductIndexService;



class ProductControllerIndexTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_category_id未指定()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('products.index'));
        $response->assertStatus(200);
        $response->assertViewHas(['total_count' => null]);
    }

    public function test_category_id指定()
    {
        $products = Product::where('category_id', 1)
            ->orderBy('price', 'desc')
            ->paginate(config('const.paginate'));
        $total_count = Product::where('category_id', 1)
            ->count();
        $category = Category::find(1);
        $major_category = MajorCategory::find($category->major_category_id);
        $category_request = [
            'products' => $products,
            'category' => $category,
            'categories' => Category::all(),
            'major_categories' => MajorCategory::all(),
            'major_category' => $major_category,
            'total_count' => $total_count,
        ];

        $user = User::factory()->create();
        $this->actingAs($user);
    
        $response = $this->get('products?category=1');
        $response->assertStatus(200);
        $response->assertViewHas(['total_count' => $total_count]);
    }

    public function test_異常()
    {
        $products = Product::where('category_id', 1)
            ->orderBy('price', 'desc')
            ->paginate(config('const.paginate'));
        $total_count = Product::where('category_id', 1)
            ->count();
        $category = Category::find(1);
        $major_category = MajorCategory::find($category->major_category_id);
        $category_request = [
            'products' => $products,
            'category' => null,
            'categories' => Category::all(),
            'major_categories' => MajorCategory::all(),
            'major_category' => $major_category,
            'total_count' => $total_count,
        ];

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('products?category=1');

        $response->assertStatus(400);
        $response->assertViewHas(['total_count' => $total_count]);
    }
}

