<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
	protected $table="assessments";
	protected $primaryKey='assessment_id';
	public $timestamps=false;

	public function claims(){
		return $this->hasMany('App\Claim');
	}

	public function modules(){

		return $this->belongsTo('App\Module','module_id');
	}
    
    
}
