<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model {
    use HasFactory, SoftDeletes;

    protected $table ='schools';
    protected $guarded = [];
    protected $dates = ['deleted_at'];  
    public $timestamps = true;

    public function students() {
        return $this->hasMany(Student::class, 'id', 'school_id');
    }

    public function state() {
        return $this->belongsTo(State::class, 'state_id','id');
    }

    public function city() {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function country() {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

}
