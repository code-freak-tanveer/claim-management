<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Evidence;

class Claim extends Model
{
    protected $primaryKey='claim_id';
    public $timestamps = false;
    
    protected $fillable=['claim_details'];
    
    public function Evidences(){
        return $this->hasMany('App\Evidence');
    }

     public function assessments(){
        return $this->belongsTo('App\Assessment','assessment_id');
    }
  

    public function delete()
    {
        // delete all related photos 
        $this->Evidences()->delete();
        // as suggested by Dirk in comment,
        // it's an uglier alternative, but faster
        // Claim::where("claim_id", $this->id)->delete()

        // delete the user
        return parent::delete();
    }

}
