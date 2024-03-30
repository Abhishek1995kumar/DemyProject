<?php

namespace App\Models;

use App\Models\TemplateFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataType extends Model {
    use HasFactory;
    protected $table = 'data_types';
    protected $guarded = [];

    public function templateFieldDataType() {
        return $this->hasMany(TemplateFields::class, 'data_type_id', 'id');
    }


}
