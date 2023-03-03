<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guidePost extends Model
{
    use HasFactory;

    protected $table = 'guidee_post';

    protected $fillable = [
     'guide_id',
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
public function guide(): BelongsTo
{
    return $this->belongsTo(guide::class, 'guide_id');
}

public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}






}
