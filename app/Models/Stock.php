<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Stock extends Model {
    use HasFactory, SoftDeletes;
    protected $table = 'stocks';
    protected $guarded = [];

    public function product() {
        return $this->hasOne(Product::class, 'product_id', 'id');
    }

    public function stockProduct() {
        return $this->belongsTo(Product::class, 'id', 'product_id');
    }

}
