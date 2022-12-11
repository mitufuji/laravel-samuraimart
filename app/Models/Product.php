<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        // 子テーブルで親テーブルのリレーション定義　今回　1対1
        return $this->belongTo('App\Models\category');
    }
}
