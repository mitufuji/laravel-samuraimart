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
    public function test_request_なし()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('products.index'));
        $response->assertStatus(200);
        logger(6666);
    }

    public function test_request_あり()
    {
        // モックに期待する返り値作成
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
        // 返り値の中身確認
        logger(7777);
        logger($category_request);

        $mock = \Mockery::mock(ProductIndexService::class)->makePartial();
        $mock->shouldReceive('excute')
                 ->once()
                 ->andReturn($category_request);

        // $mock = $this->mock(ProductIndexService::class, function (MockInterface $mock) {
        //     $mock->shouldReceive('excute')
        //         ->once()
        //         ->andReturn();
        // });
        // ProductIndexService::shouldReceive('excute')
        //                         ->once()
        //                         ->andReturn($category_request);

        
        $user = User::factory()->create();
        $this->actingAs($user);
    
        $response = $this->get(route('products.index'));
        logger(44444);
        $response->assertStatus(200);
        $response->assertViewHas($category_request);
    }
}

// 'products' => $products,
//             'category' => $category,
//             'categories' => Category::all(),
//             'major_categories' => MajorCategory::all(),
//             'major_category' => $major_category,
//             'total_count' => $total_count,


// 'products' => Product::where('category_id', 1)
// ->orderBy('price', 'desc')
// ->paginate(config('const.paginate')),
// 'category' => Category::find(1),
// 'categories' => Category::all(),
// 'major_categories' => MajorCategory::all(),
// 'major_category' => MajorCategory::find(1),
// 'total_count' => Product::where('category_id', 1)
// ->count(),