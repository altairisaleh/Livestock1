<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chat_ask extends Model
{
    use HasFactory;
    protected $table = 'chat_ask';
    protected $fillable = [
        'Benificary_id',
        'mesage',
        'record',
    ];


    protected $guarded=[];
    protected $with=["funanswer"];
    public function funanswer(){
        return $this->hasMany(chat_answer::class);

    }
}
