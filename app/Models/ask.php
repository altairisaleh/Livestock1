<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ask extends Model
{
    use HasFactory;


    protected $table = 'asks';

    protected $fillable = [
     'Benificary_id',
    'title',
     'content',
     'image',
     'record',
    ];

/**
 * Get the Benificary that owns the ask
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function Benificary(): BelongsTo
{
    return $this->belongsTo(Benificary::class, 'Benificary_id');
}




/**
 * Get the answer associated with the ask
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasOne
 */
public function answer(): HasOne
{
    return $this->hasOne(answer::class);
}


public function answer_guide(): HasOne
{
    return $this->hasOne(answers_guide::class);
}







}
