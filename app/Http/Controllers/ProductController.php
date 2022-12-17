<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    public function index(Request $request){
        // 引数ないため、Productsテーブル全て習得。この状態は単純に値を習得してるだけで、配列ではない。配列にするには、
        // $products = Product::all()->toArray();
        // view()ヘルパー　引数のviewとして指定する。ページ（URL）ではない
        // 引数は フォルダ名・ファイル名 で指定（blade.php）要らない
        // compact()関数　引数を配列にする
        // 引数$products（productテーブル）の情報を全て配列にする　
        // [id=>'1' name=>'本' price=>'2000']

        // productモデルのデータベースを15件ずつ、ページネーションで表示

        if($request->category !== null){
            // whereテーブルから条件にあてはまるものを抽出
            $products = Product::where('category_id', $request->category)
                          ->orderBy("price","desc")                
                          ->sortable()
                          ->paginate(15);
            // Product::where('category_id',$request->category)の実行回数
            $total_count = Product::where('category_id',$request->category)->count();
            $category = Category::find($request->category);
        }else{
            
            $products = Product::sortable()
                         ->orderBy("price","desc")
                         ->paginate(15);
                         
            $total_count = "";
            $category = null;
            // logger('elseproducts');
        }
        $categories = Category::all();
        // Categoryからmajor_category_namesのみ取り出す（pluck）　uniqueで重複部分を削除
        $major_category_names = Category::pluck('major_category_name')->unique();
      
       
        return view('products.index', compact('products', 'category','categories', 'major_category_names','total_count'));
    }

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
     *Requestクラスを使い、データを受け取り保存
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Requestクラスの型宣言
    public function store(Request $request){
        // インスタンス化　各カラムを変数宣言し値を入力可能に
        $product = new Product();
        // フォームから送信されたデータは$requestにある。nameにinputされた値は$productのnameカラムにいれます。
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        // 最後はsave　updateでも可。updateのほうが使われる。
        $product->save();
        //return to_route('products.index') データ保存後、リダイレクトする 
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
   
        $reviews = $product->reviews()->get();

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
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        // 入力内容をアップデート
        $product->update();
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
