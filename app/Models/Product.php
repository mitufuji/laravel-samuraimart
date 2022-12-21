<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use HasFactory, Favoriteable, Sortable;

    protected $fillable = [
        'name','description','price','category_id',
    ];

    public function category()
    {
        // 子テーブルで親テーブルのリレーション定義　今回　1対1
        return $this->belongsTo('App\Models\Category');
        
    }
    // productからみてreviewは多　だからs
    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }
}
