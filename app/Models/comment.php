<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;
public $table = "commentss";
    protected $fillable = [
        'Benificary_id',
        'post_id',
        'content',
        'record',
    ];
    protected $guarded = [];
public function Benificary(): BelongsTo
{
    return $this->belongsTo(Benificary::class, 'Benificary_id');
}







}
