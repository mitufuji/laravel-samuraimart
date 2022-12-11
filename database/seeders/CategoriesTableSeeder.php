<?php
// php artisan make:seeder CategoriesTableSeeder　で作成
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// Categoryモデル使う
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 各カラムに値を入れている
        $major_category_names = [
            '本', 'コンピュータ', 'ディスプレイ'
        ];

        $book_categories = [
            'ビジネス', '文学・評論', '人文・思想', 'スポーツ',
            'コンピュータ・IT', '資格・検定・就職', '絵本・児童書', '写真集',
            'ゲーム攻略本', '雑誌', 'アート・デザイン', 'ノンフィクション'
        ];

        $computer_categories = [
            'ノートPC', 'デスクトップPC', 'タブレット' 
        ];

        $display_categories = [
            '19~20インチ', 'デスクトップPC', 'タブレット' 
        ];
// $major_category_namesを一個づつ出す。 
        foreach ($major_category_names as $major_category_name) {
            // 本が来たら
            if ($major_category_name == '本') {
                //また$book_categoriesを一個づつ出してる。理解しづらいけど、
                // 結局は$major_category_nameが'本'の場合、$book_categoryの各値をカラムに代入してる
                foreach ($book_categories as $book_category) {
                    // モデルクラスのcreateメソッド　インスタンスの作成、カラムの代入、保存までしてくれる
                    Category::create([
                        'name' => $book_category,
                        'description' => $book_category,
                        'major_category_name' => $major_category_name
                    ]);
                }
            }

            if ($major_category_name == 'コンピュータ') {
                foreach ($computer_categories as $computer_category) {
                    Category::create([
                        'name' => $computer_category,
                        'description' => $computer_category,
                        'major_category_name' => $major_category_name
                    ]);
                }
            }

            if ($major_category_name == 'ディスプレイ') {
                foreach ($display_categories as $display_category) {
                    Category::create([
                        'name' => $display_category,
                        'description' => $display_category,
                        'major_category_name' => $major_category_name
                    ]);
                }
            }
        }
    }
}
// このあとの処理
// composer dump-autoload　　　シーダーファイルを読み込む　どうゆうこと？？？
// php artisan db:seed --class=CategoriesTableSeeder　　 php artisan db:seedでシーダクラスを実行する
// --class=でどのシーダークラスかを指定している

