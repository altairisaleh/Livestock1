<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Benificary extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = 'benificaries';
    public $role = "benificary";
    protected $fillable = [
        'name',
        'phone',
         'password',
         'special',

    ];
    /**
     * Get the Benficaryprofile associated with the Benificary
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Benficaryprofile(): HasOne
    {
        return $this->hasOne(Benficaryprofile::class);
    }

}
