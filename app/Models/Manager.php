<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;
    protected $table = 'managers';
    public $role = "manager";

    protected $fillable = [
        'name',
        'phone',
         'password',
         'special',

    ];

}
