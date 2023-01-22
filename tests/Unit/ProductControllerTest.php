<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\Category;
use App\Models\MajorCategory;
use Illuminate\Http\Request;
use App\Models\User;


class ProductControllerTest extends TestCase
{
    /**
     * @test
     */
    public function test_category受け取っている()
    {
    $request = new Request;

    $request->merge([
    'category' => '1',
    ]);

    $mock = Mockery::mock(ProductController::class,function (MockInterface $mock) {
            $mock->shouldReceive('index')
                ->once();                 
        }
    );

    }

}
