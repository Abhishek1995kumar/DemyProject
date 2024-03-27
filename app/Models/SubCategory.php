<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SubCategory extends Model {
    use HasFactory, SoftDeletes;
    protected $table = 'sub_categories';
    protected $guarded = [];

    public function categorySub() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function categoryInSub() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

}



