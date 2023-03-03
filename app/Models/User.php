<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'phone',
         'password',
         'special',

    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['roles'];


    public function isManager() {
        return $this->isA('manager');
    }
    public function isGuide() {
        return $this->isA('guide');
    }
    public function isDoctor() {
        return $this->isA('doctor');
    }

    public function isbenficary() {
        return $this->isA('benficary');
    }





    public function setManager() {
        $this->assign('manager')->refresh();
    }
    public function setGuide() {
        $this->assign('Guide')->refresh();
    }
    public function setDoctor() {
        $this->assign('Doctor')->refresh();
    }
    public function setbenficary() {
        $this->assign('benficary')->refresh();
    }

    public function getRolesAttribute() {
        return $this->getRoles()->toArray();
    }
}
