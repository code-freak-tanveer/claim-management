<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Management extends Authenticatable
{
    protected $primaryKey = 'management_id';
    protected $guard='admin';
   public function faculties(){
        return $this->belongsTo('App\Faculty','management_id');
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