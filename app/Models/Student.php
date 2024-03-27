<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model {
    use HasFactory, SoftDeletes;
    protected $table ='students';
    protected $guarded = [];

    public function school() {
        return $this->hasOne(School::class, 'id', 'school_id');
    }

}
