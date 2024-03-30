<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateName extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'template_names';

    protected $guarded = [];

    public function templateField() {
        return $this->hasMany(TemplateFields::class, 'template_name_id', 'id');
    }

    // protected $casts = [
    //     'field_name' => 'array', // whenever we want to use to store data as a json/array form in table than we used $casts method in model class 
    // ];

    
}
