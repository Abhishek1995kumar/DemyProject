<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model {
    use HasFactory, SoftDeletes;

    const SINGLE_UPLOAD = 1;
    const BULK_UPLOAD = 2;
    protected $table = 'products';
    protected $guarded = [];

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function subCategory() {
        return $this->hasOne(SubCategory::class, 'id', 'sub_category_id');
    }

    public function brand() {
        return $this->hasOne(ProductBrand::class, 'id', 'brand_id');
    }

    public function productImage() {
        return $this->hasOne(ProductAttribute::class, 'id', 'product_id');
    }

    public function dimension() {
        return $this->hasOne(Dimension::class, 'id', 'product_id');
    }

    public function stocks() {
        return $this->belongsTo(Stock::class, 'id', 'product_id');
    }

}
