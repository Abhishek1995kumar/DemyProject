<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'comments';

    protected $guarded = [];

    public function post() {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }

    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
