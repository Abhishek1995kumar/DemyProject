<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductBrand extends Model {
    use HasFactory, SoftDeletes;
    protected $table = 'product_brands';
    protected $guarded = [];

    public function product() {
        return $this->hasOne(Product::class, 'brand_id', 'id');
    }
}
