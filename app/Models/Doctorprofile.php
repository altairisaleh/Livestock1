<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctorprofile extends Model
{
    use HasFactory;
    protected $table = 'doctor_profile';
    protected $fillable = [
        'doctor_id',
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
public function Doctor(): BelongsTo
{
    return $this->belongsTo(Doctor::class, 'doctor_id');
}

}
