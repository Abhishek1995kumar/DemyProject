<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model {
    use HasFactory, SoftDeletes;
    protected $table ='states';

    protected $guarded = [];

    public function city() {
        return $this->hasMany(City::class, 'state_id', 'id');
    }

    public function country() {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
