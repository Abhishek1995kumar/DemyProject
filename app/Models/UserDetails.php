<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetails extends Model {
    use HasFactory, SoftDeletes;

    const DATA_CREATED = 1;
    const DATA_UPDATED = 2;
    const DATA_DELETED = 3;
    protected $table = 'user_details';
    protected $guarded = [];
}
