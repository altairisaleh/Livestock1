<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benficaryprofile extends Model
{
    use HasFactory;
    public $table = "benificaries_profile";
    protected $fillable = [
        'Benificary_id',
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
public function Benificary(): BelongsTo
{
    return $this->belongsTo(Benificary::class, 'Benificary_id');
}

















}
