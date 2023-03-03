<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class guide extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = 'guides';
    public $role = "guide";
    protected $fillable = [
        'name',
        'phone',
         'password',
         'special',

    ];

          /**
     * Get the guideprofile associated with the guide
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function guideprofile(): HasOne
    {
        return $this->hasOne(guideprofile::class);
    }

}
