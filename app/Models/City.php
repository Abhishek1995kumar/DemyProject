<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'cities';
    protected $guarded = [];

    public function state() {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
    public function country() {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function school() {
        return $this->hasMany(School::class, 'city_id', 'id');
    }

}
