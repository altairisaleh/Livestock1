<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class answer extends Model
{
    use HasFactory;
    public $table = "answers";
    protected $fillable = [
        'doctor_id',
        'ask_id',
        'content',
        'record',
    ];

/**
 * Get the user that owns the comment
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function Benificary(): BelongsTo
{
    return $this->belongsTo(Doctor::class, 'doctor_id');
}


}
