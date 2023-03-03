<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class answers_guide extends Model
{
    use HasFactory;
    public $table = "answers_guide";
    protected $fillable = [
        'guide_id',
        'ask_id',
        'content',
        'record',
    ];


    public function Benific(): BelongsTo
{
    return $this->belongsTo(guide::class, 'guide_id');
}
}
