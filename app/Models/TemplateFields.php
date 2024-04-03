<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateFields extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'template_field_details';

    protected $guarded = [];

    public function templateName() {
       return $this->hasOne(TemplateName::class, 'id', 'template_name_id');
    }

    
    public function validationDetails() {
        return $this->belongsTo(Validation::class, 'validation_id', 'id');
    }

    public function dataTypeDetails() {
        return $this->belongsTo(DataType::class, 'data_type_id', 'id');
    }

}
