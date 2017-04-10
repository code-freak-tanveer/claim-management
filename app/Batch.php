<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $primaryKey='batch_id';

    public $timestamps=false;
    public function courses(){
    	return $this->belogsTo('App\Course','course_id');
    }

    public function students(){
    	return $this->hasMany('App\Student');
    }

    public function modules(){
    	return $this->belongsToMany('App\Module','batch_course_module','batch_id','module_id')->withPivot('module_start','module_end');
    }

}
