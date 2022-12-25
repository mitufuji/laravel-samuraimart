<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
        // テーブル名を指定しない場合、スネークケース（クラス名の複数形）がテーブル名に使用される。
        // 今回Categoriesがテーブル名　
    public function products()
    {
        // リレーション定義　親テーブル（Categories)で子テーブル（Products)を定義。
        // 今回　1対多　なのでhasmany('モデルの場所') 1対1なら　hasOne()
        // 多対多　なら　belongsToMany()
        return $this->hasMany('App\Models\Product');
        // テーブル名指定するなら　ここに  protected $table = 'テーブル名';
    }

    public function major_category()
    {
        return $this->belongsTo('App\Models\MajorCategory');
    }
}
