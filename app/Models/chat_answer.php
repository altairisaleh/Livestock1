<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class chat_answer extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'chat_answer';
    protected $fillable = [
        'answer',
        'record',
        'doctor_id',
        'ask_id',
    ];
/**
 * Get the user that owns the chat_answer
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function chat_ask(): BelongsTo
{
    return $this->belongsTo(chat_ask::class, 'ask_id');
}



}
