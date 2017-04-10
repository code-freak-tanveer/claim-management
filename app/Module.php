<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $primaryKey='module_id';
    public $timestamps = false;

    public function courses(){
    	return $this->belongsToMany('App\Course','course_module','module_id','course_id');
    }

     public function assessments(){
       return $this->hasMany('App\Assessment');
    }


   
}
