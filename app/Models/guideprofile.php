<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guideprofile extends Model
{
    use HasFactory;

    protected $fillable = [
        'guide_id',
        'image' ,
        'name',
        'phone',
         'password',

    ];
/**
 * Get the doctor that owns the Doctorprofile
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function guide(): BelongsTo
{
    return $this->belongsTo(guide::class, 'guide_id');
}










}
