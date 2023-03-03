<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doctorPost extends Model
{
    use HasFactory;

    protected $table = 'doctor_posts';

    protected $fillable = [
     'doctor_id',
    'title',
     'content',
     'image',
     'record',
    ];
/**
 * Get the user that owns the post
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function Doctor(): BelongsTo
{
    return $this->belongsTo(Doctor::class, 'doctor_id');
}

/**
 * Get all of the comments for the doctorPost
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}



}
