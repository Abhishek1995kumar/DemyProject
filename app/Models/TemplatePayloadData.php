<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemplatePayloadData extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'template_payload_data';

    protected $guarded = [];

    public function templatePayloadDetails() {
        return $this->belongsTo(TemplateName::class, 'template_name_id', 'id');
    }

    protected $casts = [
        'data' => 'array'
    ];
}
