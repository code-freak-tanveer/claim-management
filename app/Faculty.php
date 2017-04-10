<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $primaryKey='faculty_id';

    public function courses(){
    	return $this->hasMany('App\Course');
    }
}
