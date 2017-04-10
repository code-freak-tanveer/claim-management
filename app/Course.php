<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $primaryKey='course_id';
    
 

	public function modules(){
		return $this->belongsToMany('App\Course','course_module','course_id','module_id');
	}

	public function batches(){
		return $this->hasMany('App\Batch');
	}
	public function faculties(){
		return $this->belongsTo('App\Faculty','faculty_id');
	}
}
