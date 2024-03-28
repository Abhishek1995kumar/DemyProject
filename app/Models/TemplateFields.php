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
       return $this->hasOne(TemplateName::class, 'template_name_id', 'id');
    }

}
