<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    protected $primaryKey = 'student_id';
   public function claim(){
        return $this->hasMany('App\Claim');
    }
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public $timestamps=false;
    protected $hidden = [
        'password', 'remember_token',
    ];
}
