<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\MajorCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Service\ProductIndexService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    public function index(Request $request)
    {
        // $category_id = Category::where('id', $request->category);
        if($request->category !== null){
            logger($id = $request->category);    
        }else{
            logger('aaa');
        }
        if($request->category !== null){
            $category_request = resolve(ProductIndexService::class)->excute(request()->only('category'));
            
            return view('products.index')->with($category_request);
        }else{
            $products = new Product;
                $total_count = "";
                $category = null;
                $major_category = null;
            $products =Product::sortable()
                ->orderBy('price', 'desc')
                ->paginate(config('const.paginate'));
        

        return view('products.index')->with([
            'products' => $products,
            'category' => $category,
            'categories' => Category::all(),
            'major_categories' => MajorCategory::all(),
            'major_category' => $major_category,
            'total_count' => $total_count,
        ]);
        }
       

        
        

        // return view('product.index')->with($category_request);
        // if($request->category !== null){
        //     $products = Product::where('category_id', $request->category);
        //     $total_count = Product::where('category_id', $request->category)
        //         ->count();
        //     $category = Category::find($request->category);
        //     $major_category = MajorCategory::find($category->major_category_id);
        // }else{
        //     $products = new Product;
        //     $total_count = "";
        //     $category = null;
        //     $major_category = null;
        // }

        // $products =Product::sortable()
        //     ->orderBy('price', 'desc')
        //     ->paginate(config('const.paginate'));
                 
            // return view('products.index')->with([
            // 'products' => $products,
            // 'category' => $category,
            // 'categories' => Category::all(),
            // 'major_categories' => MajorCategory::all(),
            // 'major_category' => $major_category,
            // 'total_count' => $total_count,
            // ]);
       
        
    }
    // public function index(Request $request){
    
        
    //     $paginate = config('const.paginate');
        
    //     if($request->category !== null){
    //         // whereテーブルから条件にあてはまるものを抽出
    //         $products = Product::where('category_id', $request->category)
    //             ->orderBy('price', 'desc')                
    //             ->sortable()
    //             ->paginate($paginate);
    //         // Product::where('category_id',$request->category)の実行回数
    //         $total_count = Product::where('category_id', $request->category)
    //             ->count();
    //         $category = Category::find($request->category);
    //     }else{
            
    //         $products = Product::sortable()
    //             ->orderBy('price', 'desc')
    //             ->paginate($paginate);
                         
    //         $total_count = "";
    //         $category = null;
    //         // logger($products);
    //         // dd();
        
    //     }

        
    //     $categories = Category::all();
    //     // Categoryからmajor_category_namesのみ取り出す（pluck）　uniqueで重複部分を削除
    //     $major_category_names = Category::pluck('major_category_name')
    //         ->unique();
      
       
    //     return view('products.index', compact('products', 'category','categories', 'major_category_names','total_count'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * 新しい商品加える
     */
    public function create(){
        $categories = Category::all();

        return view('products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.

     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request){
        
        $product = new Product();
        
        $product->fill($request->all())
                 ->save();
        // $product->name = $request->input('name');
        // $product->description = $request->input('description');
        // $product->price = $request->input('price');
        // $product->category_id = $request->input('category_id');
        
        //   $product->save();
        return to_route('products.index');

    }

    /**
     * Display the specified resource.
     *指定された商品表示
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    // ここに来るまでに$productはidを送信して指定されている。例　index.blade.php
    // 引数はProductクラスの指定されたidを持つ値
    public function show(Product $product){
        
        // 引数をcompactで配列化
   
        $reviews = $product
            ->reviews()
            ->get();

        return view('products.show', compact('product', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     * 編集する商品のデータをビューに渡す
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product){
        // ここに来るまでに$productはidを送信して指定されている。例　index.blade.php
        // 引数はProductクラスの指定されたidを持つ値

        // ここに来るまでにCategoryクラスは何も指定されていないのでインスタンス化
        $categories = Category::all();
        return view('products.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *変更データを受け取る
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    // formで入力を受け取った$requestと指定されたidの値を受け取った引数が指定されている
    // edit.balde.phpからきてる
    public function update(Request $request, Product $product){

        $product->fill($request->all())
                 ->update();
        // $product->name = $request->input('name');
        // $product->description = $request->input('description');
        // $product->price = $request->input('price');
        // $product->category_id = $request->input('category_id');
        // // 入力内容をアップデート
        // $product->save();
        // to_route　は　redirect()->route('')と一緒。
        // uodateアクションは表示するページがない　その時はto_route？？
        return to_route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product){
        $product->delete();
        //ここに来るまでに$productはidを送信して指定されている。例 index.blade.php
        //引数はProductクラスの指定されたidを持つ値
        return to_route('products.index');
    }

    public function favorite(Product $product)
    {
        // ログイン中のユーザーがお気に入りしてなければ登録、してれば解除できるらしい
        // Githubにおいてあった
        Auth::user()->togglefavorite($product);

        return back();
    }
}
