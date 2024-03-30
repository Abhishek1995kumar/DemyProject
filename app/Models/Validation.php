<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model {
    use HasFactory;
    protected $table = 'validations';
    protected $guarded = [];

    public function templateFieldValidation() {
        return $this->hasOne(TemplateFields::class, 'validation_id', 'id');
    }


}
